<?php

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct('login');
    }

    function index()
    {
        if ($this->Employeer->is_logged_in()) {
            redirect('home');
        } else {
            $this->load->view('login');
        }
        
        if ($this->input->post('username')) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($this->login_check($username, $password)) {
                redirect('home');
            } else {
                $data['result_menager'] = '<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times sign"></i><strong>Opss!</strong>
							Usuário ou Senha não conferem.
							</div>';
                
                $this->load->view('login', $data);
            }
        }
    }

    function login_check($username, $password)
    {
        if (! $this->Employeer->login($username, $password)) {
            return false;
        }
        return true;
    }
}
?>