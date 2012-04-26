<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection extends CI_Controller {

  public function index() {
    $data['main_content'] = 'collection_index';
    
    $this->load->model('Collection_model');
    $data['collections'] = $this->Collection_model->get_most_recent();
    
    $this->load->view('includes/template', $data);
  }
  
  public function get($id) {
    $data['main_content'] = 'collection_get';
    
    $this->load->model('Collection_model');
    $data['collection'] = $this->Collection_model->get($id);
    
    $this->load->model('Image_model');
    $data['images'] = $this->Image_model->get_images($id);
    
    $this->load->view('includes/template', $data);
  }
}
