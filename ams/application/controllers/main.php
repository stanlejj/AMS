<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
    {
            parent::__construct();
            $this->view_data['baseUrl'] = base_url();
            $this->load->model('Authentication_handler');       
    }

	public function index()
	{
		if ($this->session->userdata('username')==null)
        {
			header('Location: /ams/main/login');
			exit();
		}
		else
		{	
			//default to see the password reset page for now - change it to dash board later
			header('Location: /ams/account/password');
			exit();
		}	
	}
	public function login()
	{		
		$this->form_validation->set_rules('username','Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password','Password', 'trim|required|xss_clean');
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$authenticationHandler = $this->Authentication_handler;
		$authenticationHandler->setUsername($username);
		$authenticationHandler->setPassword($password);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('ams_header',$this->view_data);
			$this->load->view('ams_login.php',$this->view_data);               			
		}
		else
		{
			if (!$authenticationHandler->isAuthenticated())
			{
				$this->view_data['authentication'] = "Authentication Failed";
				$this->load->view('ams_header',$this->view_data);
				$this->load->view('ams_login.php',$this->view_data);
			}
			else
			{
				$this->session->set_userdata('username', $username);
				header('Location: /ams/account/password');
				exit();
			}
		}
		
		$this->load->view('ams_footer',$this->view_data);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->login();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
