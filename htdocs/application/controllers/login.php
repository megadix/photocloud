<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->config->load('login');
  }
  
  public function index() {
    $data['main_content'] = 'login_form';
    $this->load->view('includes/template', $data);
  }
  
  public function logout() {
    $this->session->sess_destroy();
    redirect('/');
  }
  
  public function validate_credentials() {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
    if ($username == $this->config->item('login_admin_username') &&
        $password == $this->config->item('login_admin_password')) {
    
      $data = array(
        'username' => $username,
        'logged_in' => true
      );
      
      $this->session->set_userdata($data);
      redirect('collection/index');
    }
    else {
      $this->session->set_flashdata('errorMessages', 'combinazione username/password non valida');
      $this->index();
    }
  }
}
