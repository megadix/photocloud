<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

  public function index() {
    $data['main_content'] = 'home';
    $data['show_masthead'] = true;
    
    $this->load->model('Collection_model');
    $data['collections'] = $this->Collection_model->get_collections(5);
    
    $this->load->view('includes/template', $data);
  }

  public function about() {
    $data['main_content'] = 'about';
    $this->load->view('includes/template', $data);
  }
}
