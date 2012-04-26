<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    $this->_isLoggedIn();
  }

  public function index() {
    $data['main_content'] = 'admin_index';
    $this->load->view('includes/template', $data); 
  }
  
  private function _isLoggedIn() {
    $logged_in = $this->session->userdata('logged_in');
    if (!isset($logged_in) || $logged_in != true) {
      echo 'Permission denied<br />' . anchor('login/index', 'Login');
      die();
    }
  }
}
