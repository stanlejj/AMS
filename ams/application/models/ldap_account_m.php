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
class Ldap_account_m extends Account_m
{			
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
      
    }
    
    //overwrite general account object
    function queryInfo(){
								
		$this->accountId = '0';
		$this->firstname = 'Ldap';
		$this->lastname = 'Account';
		$this->accountType = 'ldap'; //this helps resolve the unknown case				 				
			     
        return false;
	}
	
	//overwrite general account object
	function getUsernameList($filterType, $searchValue, $accountType)
	{
		$usernameList = array('1','2');
		
		return $usernameList;			
	}
	
	//overwrite general account object
	function resetPassword($newPassword){		
		return "reset ad";
	}  
}    
