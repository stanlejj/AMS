<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

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
	
	/******************************************************
	 * sub pages
	 ******************************************************/
	public function password()
	{
		//get the initial password history list
		$this->load->model('Data_retrieve');		
		$historyList = $this->Data_retrieve->loadPasswordHistory();
		$this->view_data['historyList'] = $historyList;		
		
		//prepare the view
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_password',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);				
	}
	
	public function singleAccount()
	{
		$this->load->view('ams_header',$this->view_data);
		$this->load->view('ams_account',$this->view_data);
		$this->load->view('ams_footer',$this->view_data);
	}
	
	/*******************************************************
	 * 	AJAX section
	 *******************************************************/ 	
	public function searchAccount(){
		//TODO: find a better algorithm to handle the unknown accountType 
		
		//this is for the unknown case
		$availableTemplate = array(
			'ldap'		=> 'Ldap_account_m',
			'mysql'		=> 'Mysql_account_m'
		);
		
		$result = array();
		
		//handling data from the client
		$filterType = $this->input->post('filterType');
		$searchValue = $this->input->post('searchValue');
		$accountType = $this->input->post('accountType');
		
		if (!array_key_exists($accountType, $availableTemplate)){
			//unknown type, we have to loop through both database, or more?	
			foreach ($availableTemplate As $accountT => $templateSearch)
			{
												
				$this->load->model($templateSearch);		
				
				//query the username list first
				$usernameList = $this->$templateSearch->getUsernameList($filterType,$searchValue,$accountType);	
				$userAccount = $this->$templateSearch;
				
				foreach ($usernameList As $username)
				{			
					///this is required before retrieving account information		
					$userAccount->setUsername($username);
					$userAccount->setAccountType($accountT);		
					$userAccount->queryInfo();
					
					//retrieval
					$accountInfo = array(
						'sid' 				=> $userAccount->getAccountId(),
						'firstname' 		=> $userAccount->getFirstname(),
						'lastname' 			=> $userAccount->getLastname(),
						'username'			=> $username,
						'accountType'		=> $userAccount->accountType,
						'hasMoodle'			=> $userAccount->hasMoodleAccount(),
						'hasGmail'			=> $userAccount->hasGmailAccount(),
						'hasComputerLab'	=> $userAccount->hasADAccount()			
					);
					
					//adding the result
					array_push($result, $accountInfo);
				}
					
			}
		}
		else{
			//determine which template to use base on the account type
			$templateModel = ucfirst($accountType) . '_account_m';		
			$this->load->model($templateModel);		
			
			//query the username list first
			$usernameList = $this->$templateModel->getUsernameList($filterType,$searchValue,$accountType);		
			$userAccount = $this->$templateModel;
			
			foreach ($usernameList As $username)
			{			
				///this is required before retrieving account information		
				$userAccount->setUsername($username);
				$userAccount->setAccountType($accountType);		
				$userAccount->queryInfo();
				
				//retrieval
				$accountInfo = array(
					'sid' 				=> $userAccount->getAccountId(),
					'firstname' 		=> $userAccount->getFirstname(),
					'lastname' 			=> $userAccount->getLastname(),
					'username'			=> $username,
					'accountType'		=> $userAccount->accountType,
					'hasMoodle'			=> $userAccount->hasMoodleAccount(),
					'hasGmail'			=> $userAccount->hasGmailAccount(),
					'hasComputerLab'	=> $userAccount->hasADAccount()			
				);
				
				//adding the result
				array_push($result, $accountInfo);
			}	
		} //end filter type condition	
								
		echo json_encode($result);
	}
	
	public function resetPassword(){		
		//handling data from the client
		$username = $this->input->post('username');
		$accountType = $this->input->post('accountType');
		$newPassword = $this->input->post('newPassword');
		
		//by this time we already know the account type so no need to check for unknown case
		
		//determine which template to use base on the account type
		$templateModel = ucfirst($accountType) . '_account_m';		
		$this->load->model($templateModel);
		$userAccount = $this->$templateModel;
	
		///this is required before retrieving account information		
		$userAccount->setUsername($username);
		$userAccount->setAccountType($accountType);
		echo $userAccount->resetPassword($newPassword);
	}
	
	public function updateHistory(){
		$this->load->model('Data_retrieve');
		$newRecord = $this->Data_retrieve->getUpdatedPasswordHistory();
		//return the new row
		echo json_encode($newRecord);
	}
	
	public function mailPasswordReset(){
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$cc = $this->input->post('cc');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');

		$headers = 'From: '.$from."\r\n" .
			'Reply-To: '.$from. "\r\n" .
			'Cc: '.$cc. "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

		echo "<div style='height:350px; width:100%; text-align:center;'>";
		echo "<h2>Congratulation!</h2>";
		echo "<p>Email sent successfully to address".$to."</p>";
		if ($cc != "")
			echo "<p>A copy has also been sent to address".$cc."</p>";
		echo "</div>";
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
