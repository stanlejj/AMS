<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis extends CI_Controller {

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
		
		//prevent unauthorized access
		if ($this->session->userdata('username')==null)
        {
			header('Location: /ams/main/login');
			exit();
		}
	}

	public function index()
	{
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_body_general',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);
	}
	
	public function crossSystem()
	{
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_cross_system',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);
	}
	
	public function conformity()
	{
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_conformity',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);
	}
	
	public function activity()
	{
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_activity',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);
	}
}

/* End of file password.php */
/* Location: ./application/controllers/password.php */
