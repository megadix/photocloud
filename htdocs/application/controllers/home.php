<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

  public function index() {
    $data['main_content'] = 'home';
    $data['show_masthead'] = true;
    
    $this->load->model('Collection_model');
    $data['collections'] = $this->Collection_model->get_most_recent();
    
    $this->load->view('includes/template', $data);
  }
}
