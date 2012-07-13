<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * This class is a static class to be used for general data handing purposes
 * 
 */ 
class Data_retrieve extends CI_Model
{	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function loadPasswordHistory()
    {
		$recordLimit = 50;		
		$recordList = array();
		
		//we order by id since we know that a later id also means later date in this case - this optimize performance rather than compare date
		$sql = "SELECT * FROM password_reset_history ORDER BY id DESC LIMIT $recordLimit";
		$query = $this->db->query($sql);			
		if ($query->num_rows() > 0)
		{			
			foreach ($query->result() as $row)
			{
				$record = array(
					'accountReset' 	=> $row->account_reset,
					'userReset' 	=> $row->user_reset,
					'dateReset'		=> date('M j Y, g:i A', strtotime($row->date_reset)) //format the date nicely
				);
				array_push($recordList, $record);
			}
		}
				
		return $recordList;
	}
	
	//for performance sake, we will just get the account appended rather than the whole 50 accounts
	function getUpdatedPasswordHistory()
	{
		$newRecord = array();
		
		$sql = "SELECT * FROM password_reset_history ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);			
		if ($query->num_rows() > 0)
		{			
			foreach ($query->result() as $row)
			{
				$newRecord['accountReset'] = $row->account_reset;
				$newRecord['userReset'] = $row->user_reset;
				$newRecord['dateReset'] = date('M j Y g:i A', strtotime($row->date_reset));
			}
		}
		
		return $newRecord;
	}
}        
