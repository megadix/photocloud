<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->_isLoggedIn();
    $this->config->load('cloud_storage');

    $params = array(
      'accessKey' => $this->config->item('storage_accessKey'),
      'secretKey' => $this->config->item('storage_secretKey'),
      'useSSL' => $this->config->item('storage_useSSL'),
      'endpoint' => $this->config->item('storage_endpoint')
    );
    $this->load->library('s3', $params);
  }

  // ====== Collection ======

  public function collection_add() {
    $data['main_content'] = 'admin_collection_add';
    $this->_getForm_collection($data);
    $this->load->view('includes/template', $data);
  }

  public function collection_add_post() {
    $data = array();
    $this->_getForm_collection($data);
    if ($this->_validate_collection() == FALSE) {
      $this->collection_add();
    }
    else {
      $this->load->model('Collection_model');
      $this->Collection_model->name = $data['name']['value'];
      $this->Collection_model->description = $data['description']['value'];
      $this->Collection_model->insert();

      // re-save with path information
      $this->Collection_model->path = 'collection_' . $this->Collection_model->id;
      $this->Collection_model->update();

      redirect('collection/get/' . $this->Collection_model->id);
    }
  }

  // ====== Image ======

  public function image_add($collection_id, $data = array()) {
    $data['main_content'] = 'admin_image_add';

    $this->load->model('Collection_model');
    $data['collection'] = $this->Collection_model->get($collection_id);

    $this->_getForm_image($data);
    $this->load->view('includes/template', $data);
  }

  public function image_add_post($collection_id) {

    try {
      $this->load->model('Collection_model');
      $data['collection'] = $this->Collection_model->get($collection_id);

      $this->_getForm_image($data);

      if ($this->_validate_image() == FALSE) {
        $this->image_add($collection_id);
      }
      else {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = '100';
        $config['allowed_types'] = 'jpg';
        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('file')) {
          $this->session->set_flashdata('errorMessages', $this->upload->display_errors());
          $this->image_add($collection_id, $data);
        }
        else {

          $upload_data = $this->upload->data();

          // resize image and create thumbnail
          $image_info = getimagesize($upload_data['full_path']);
          if($image_info[2] == IMAGETYPE_JPEG ) {
             $image = imagecreatefromjpeg($upload_data['full_path']);
          } else {
            unlink($upload_data['full_path']);
            throw new Exception('Formato non supportato');
          }

          $imageWidth = $upload_data['image_width'];
          $imageHeight = $upload_data['image_height'];

          // resize to width = 600 px
          $ratio = 600 / $imageWidth;
          $resizedHeight = $imageHeight * $ratio;

          $resizedImage = imagecreatetruecolor(600, $resizedHeight);

          imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, 600, $resizedHeight, $imageWidth, $imageHeight);
          $resizedImageName = $upload_data['raw_name'] . '_full.jpg';
          imagejpeg($resizedImage, $upload_data['file_path'] . $resizedImageName, 90);

          // create thumbnail

          $ratio = 260 / $imageWidth;
          $thumbHeight = $imageHeight * $ratio;

          $thumbImage = imagecreatetruecolor(260, $thumbHeight);

          imagecopyresampled($thumbImage, $image, 0, 0, 0, 0, 260, $thumbHeight, $imageWidth, $imageHeight);
          $thumbImageName = $upload_data['raw_name'] . '_thumb.jpg';
          imagejpeg($thumbImage, $upload_data['file_path'] . $thumbImageName, 90);

          // upload to cloud storage
          $inputImage = S3::inputFile($upload_data['file_path'] . $resizedImageName);
          $inputThumb = S3::inputFile($upload_data['file_path'] . $thumbImageName);

          $imagePath = $this->config->item('storage_base_path') . '/' .
              $data['collection']->path . '/' . $resizedImageName;
          $imageThumbPath = $this->config->item('storage_base_path') . '/' .
              $data['collection']->path . '/' . $thumbImageName;
              
          if (S3::putObject($inputImage, $this->config->item('storage_bucket_name'), $imagePath, S3::ACL_PUBLIC_READ) == false ||
              S3::putObject($inputThumb, $this->config->item('storage_bucket_name'), $imageThumbPath, S3::ACL_PUBLIC_READ) == false) {
            throw new Exception('errorMessages', 'Problemi nella creazione dell\'oggetto nel cloud storage');
          }
          
          unlink($upload_data['file_path'] . $resizedImageName);
          unlink($upload_data['file_path'] . $thumbImageName);

          $this->load->model('Image_model');
          $this->Image_model->name = $data['name']['value'];
          $this->Image_model->description = $data['description']['value'];
          $this->Image_model->collection_id = $collection_id;

          $this->Image_model->path = 'http://' .
                $this->config->item('storage_bucket_name') . '.' .
                $this->config->item('storage_endpoint') . '/' .
                $imagePath;
          $this->Image_model->width = 600;
          $this->Image_model->height = $resizedHeight;

          $this->Image_model->thumbnail_path = 'http://' .
                $this->config->item('storage_bucket_name') . '.' .
                $this->config->item('storage_endpoint') . '/' .
                $imageThumbPath;
          $this->Image_model->thumbnail_width = 260;
          $this->Image_model->thumbnail_height = $thumbHeight;

          $this->Image_model->insert();

          redirect('collection/get/' . $collection_id);

        }
      }
    } catch(Exception $ex) {
      $errorMessage = "Si è verificato un errore (" . $ex->getCode() . "):\n" . $ex->getMessage();
      $this->session->set_flashdata('errorMessages', $errorMessage);
      redirect('collection/get/' . $collection_id);
    }
  }

  /*
   * private stuff
   */

  private function _isLoggedIn() {
    $logged_in = $this->session->userdata('logged_in');
    if (!isset($logged_in) || $logged_in != true) {
      echo 'Permission denied<br />' . anchor('login/index', 'Login');
      die();
    }
  }

  // ===== Collection =====

  private function _getForm_collection(&$data) {

    $data['name'] = array(
        'name' => 'name',
        'id' => 'name',
        'maxlength' => '128',
        'size' => '50',
        'value' => $this->input->post('name')
      );

    $data['description'] = array(
        'name' => 'description',
        'id' => 'description',
        'rows' => 8,
        'cols' => 80,
        'class' => 'input-xlarge',
        'value' => $this->input->post('description')
      );

      $data['submit'] = array(
        'id' => 'submit',
        'class' => 'btn btn-primary',
        'value' => 'Salva'
      );
  }

  private function _validate_collection() {
    $config = array(
      array(
        'field' => 'name',
        'label' => 'Nome',
        'rules' => 'trim|required'
      )
    );

    $this->form_validation->set_rules($config);

    return $this->form_validation->run();
  }

  // ===== Image =====

  private function _getForm_image(&$data) {

    $data['name'] = array(
        'name' => 'name',
        'id' => 'name',
        'maxlength' => '128',
        'size' => '50',
        'value' => $this->input->post('name')
      );

    $data['description'] = array(
        'name' => 'description',
        'id' => 'description',
        'rows' => 8,
        'cols' => 80,
        'class' => 'input-xlarge',
        'value' => $this->input->post('description')
      );

    $data['file'] = array(
        'name' => 'file',
        'id' => 'file',
        'value' => $this->input->post('file')
      );

    $data['submit'] = array(
        'id' => 'submit',
        'class' => 'btn btn-primary',
        'value' => 'Salva'
      );
  }

  private function _validate_image() {
    $config = array(
      array(
        'field' => 'name',
        'label' => 'Nome',
        'rules' => 'trim|required'
      )
    );

    $this->form_validation->set_rules($config);

    return $this->form_validation->run();
  }

}
