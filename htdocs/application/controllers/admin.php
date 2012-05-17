<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    $this->_isLoggedIn();
    $this->config->load('cloud_storage');
    
    $params = array(
      'accessKey' => $this->config->item('accessKey'),
      'secretKey' => $this->config->item('secretKey'),
      'useSSL' => $this->config->item('useSSL'),
      'endpoint' => $this->config->item('endpoint')
    );
    $this->load->library('s3', $params);
    
    $this->load->library('upload');
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
      $base_path = $this->config->item('base_path');
      $this->Collection_model->path = $base_path . 'collection_' . $this->Collection_model->id . '/';
      $this->Collection_model->update();
      
      redirect('collection/get/' . $this->Collection_model->id);
    }
  }
  
  // ====== Image ======
  
  public function image_add($collection_id) {
    $data['main_content'] = 'admin_image_add';
    
    $this->load->model('Collection_model');
    $data['collection'] = $this->Collection_model->get($collection_id);
    
    $this->_getForm_image($data);
    $this->load->view('includes/template', $data);
  }
  
  public function image_add_post($collection_id) {
    $data = array();
    
    $this->load->model('Collection_model');
    $data['collection'] = $this->Collection_model->get($collection_id);
    
    $this->_getForm_image($data);
    if ($this->_validate_image() == FALSE) {
      $this->image_add($collection_id);
    }
    else {
      if (! $this->upload->do_upload()) {
        $error = array('error' => $this->upload->display_errors());
        $this->image_add($collection_id);
      }
      else {
        $upload_data = $this->upload->data();
        print_r($upload_data);
        die();
      }
      
      $this->load->model('Image_model');
      $this->Image_model->name = $data['name']['value'];
      $this->Image_model->description = $data['description']['value'];
      $this->Image_model->collection_id = $collection_id;
      $this->Image_model->insert();
      
      // TODO create thumbnail
      
      // re-save with path information
      $base_path = $data['collection']->path;
      $this->Image_model->path = $base_path . $this->Image_model->id . 'TODO filename';
      $this->Image_model->update();
      
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
        'rules' => 'required'
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
      ),
      array(
        'field' => 'file',
        'label' => 'File'
      )
    );

    $this->form_validation->set_rules($config);

    return $this->form_validation->run();
  }
  
}
