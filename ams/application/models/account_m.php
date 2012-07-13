<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* 
 * This object is a general account. The order of operations are
 * - initialize the Account object
 * - set the username for the Account
 * - set the userType for the Account
 * - call the method queryInfo() to fetch all the info for the Account
 * - retrieve any other information using the getter methods
 */
class Account_m extends CI_Model
{
	
	var $username = "";
	var $accountType = "";
	var $accountId = "";
	var $firstname = "";
	var $lastname = "";
	var $moodleAttr = null;
	var $gmailAttr = null;
	var $adAttr = null;
	
	var $accountExist = false;
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        //load the Gmail Attr and Moodle Attr model
/*
        $this->load->model('Gmail_attr'); 
        $this->load->model('Moodle_attr'); 
*/   
        
        //to access gmail directly        
        $this->load->helper('zend_framework');
        Zend_Loader::loadClass('Zend_Http_Client');
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_Gapps');      

    }
       
    /*************************************************************
     * SETTER
     *************************************************************/          
	function setUsername($usernameParm){
		$this->username = $usernameParm;
	}
	
	function setAccountType($accountTypeParm){
		$this->accountType = $accountTypeParm; 
	}
	
	function setAccountId($accountIdParm){
		$this->accountId = $accountIdParm;
	}
	
	function setFirstname($firstnameParm){
		$this->firstname = $firstnameParm;
	}
	
	function setLastname($lastnameParm){
		$this->lastname = $lastnameParm;
	}
		
	/*
	 * $moodleAttrParm is an object model of class Moodle_attr
	 */ 	 
	function setMoodelAttr($moodleAttrParm)
	{
		$this->moodleAttr = $moodleAttrParm;
	}

	/* 
	 * $gmailAttrParm is an object model of class Gmail_attr
	 */ 	  
	function setGmailAttr($gmailAttrParm)		
	{
		$this->gmailAttr = $gmailAttrParm;
	}
 
	/*****************************************************************
	 * --------------MASTER FUNCTIONS-------------------------------
	 * This must be called before others getter
	 * based on the student type we will query the correct database
	 * and set all the information for this user
	 ****************************************************************/
	//overwritten by subclass based on what type of account this is
	function queryInfo(){		
		//if the account is not found
		$this->accountExist = false;
		return false;
	}
	
	/*************************************************************
     * GETTER
     *************************************************************/
	function getAccountId(){
		return $this->accountId;
	}
	
	function getFirstname(){
		return $this->firstname;
	}
	
	function getLastname(){
		return $this->lastname;
	}
	
	function getAccountType(){
		return $this->accountType;
	}
	
	/****************************************************************
	 * UTILITIES
	 ****************************************************************/ 
	//query directly the Moodle database to check if this account exist
	function hasMoodleAccount(){
		$moodle_db = $this->load->database('moodle', TRUE);		
		
		//manually escaping sql variable		
        $sql_query = "SELECT username FROM user WHERE username=?";        
        $query = $moodle_db->query($sql_query,$this->username);
        if ($query->num_rows()>0)
            return true;
        else
            return false;
        return $sql_query;           
	}
	
	//query gmail directly to check if this account exist
	function hasGmailAccount(){
		$domain = $this->config->item('domain');
        $email = $this->config->item('admin_email');
        $passwd = $this->config->item('admin_passwd');

        $client = Zend_Gdata_ClientLogin::getHttpClient($email, $passwd, Zend_Gdata_Gapps::AUTH_SERVICE_NAME);
        $gdata = new Zend_Gdata_Gapps($client, $domain);

        $user = $gdata->retrieveUser($this->username);
        if ($user != NULL)
            return true;
        else
            return false;
	}
	
	//query Active Directory directly to check if this account exist
	function hasADAccount(){
		return false;
	}
	
	//return a list of all the username that match the criteria searched for
	//overwritten by subclass
	function getUsernameList($filterType, $searchValue, $accountType){		
		return array(); 			
	}
	
	//reset the user password
	//overwritten by subclass
	function resetPassword($newPassword){       
        return false;
	} 
} 

