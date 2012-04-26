<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
    
    // FIXME add real login
    if ($username == 'admin' && $password == 'admin') {
      $data = array(
        'username' => $username,
        'logged_in' => true
      );
      
      $this->session->set_userdata($data);
      redirect('collection/index');
    }
    else {
      $this->index();
    }
  }
}
