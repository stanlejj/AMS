<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* 
 * This object is a general account. The order of operations are
 * - initialize the Account object
 * - set the username for the Account
 * - set the userType for the Account
 * - call the method queryInfo() to fetch all the info for the Account
 * - retrieve any other information using the getter methods
 */
include_once('account_m.php'); //this is important for inheritance
class Mysql_account_m extends Account_m
{			
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
      
    }
    
    //overwrite general account object
    function queryInfo(){
		//get the online account from the mySql database		
        $sql_query = "SELECT * FROM cas_user WHERE username=?";       
        $query = $this->db->query($sql_query, $this->username);
 		
        if ($query->num_rows() > 0)
        {			
			foreach ($query->result() as $row)
			{								
				$this->accountId = $row->idnumber;
				$this->firstname = $row->firstname;
				$this->lastname = $row->lastname;
				$this->accountType = "mysql"; //this helps resolve the unknown case				 				
			}
			$this->accountExist = true;							
			return true;
		}        
        return false;
	}
	
	//overwrite general account object
	function getUsernameList($filterType, $searchValue, $accountType)
	{
		//we use wild card to match partial searchValue
		$searchValueWC = "%$searchValue%";
		//these field remap the field in the database with the front end selection
		$mysqlField  = array(
			"username" => 'username',
			"lastname" => 'lastname',
			"firstname" => 'firstname',
			"student_id" => 'idnumber'	
		);
		
		$usernameList = array();
				
		$sql = "SELECT username FROM cas_user WHERE ". $mysqlField[$filterType] ." LIKE ". $this->db->escape($searchValueWC);			
		
		$query = $this->db->query($sql);			
		if ($query->num_rows() > 0)
		{			
			foreach ($query->result() as $row)
			{
				array_push($usernameList, $row->username);
			}
		}
		
		return $usernameList;			
	}
	
	//overwrite general account object
	function resetPassword($newPassword){
		$success = false;
		
		//encrypt password to Moodle scheme		
		$encrPassword = md5($newPassword . $this->config->item('moodle_salt'));		
		
		//update mySql password
		$sql = "UPDATE cas_user SET password=".$this->db->escape($encrPassword)." WHERE username=".$this->db->escape($this->username);
		$query = $this->db->query($sql);
		
		//save password history		
		$sql = "INSERT INTO password_reset_history (user_reset,account_reset) VALUES (" .
												$this->db->escape($this->session->userdata('username')) . "," .
												$this->db->escape($this->username) . ");";
		$query = $this->db->query($sql);
		$success = true;
																
		return $success;
	} 
}    
