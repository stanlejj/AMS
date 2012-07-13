<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* 
 * This object extends the attribute
 */
class Gmail_attr extends CI_Model
{
	var $nicknames = null;
	var $groups = null;
		
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $nicknames = array();
        $groups = array();      
    }
    
    function setNicknames($nickNamesParm)
    {
		//itterate through array
		for ($nickNamesParm as $n)
		{
			array_push($this->nicknames, $n);
		}
	}
	
	function setGroups($groupsParm)
	{
		for ($groupsParm as $p)
		{
			array_push($groupsParm, $p);
		}
	}
	
	function getNicknames()
	{
		return $this->nicknames;
	}
	
	function getGroups()
	{
		return $this->groups;
	}
	
	//just for convenient if the user only have one nicknames or one groups
	function getFirstNickname()
	{
		if (count($this->nicknames) > 0)
			return $this->nicknames[0];
		return null;	
	}
	
	function getFirstGroup()
	{
		if (count($this->groups) > 0)
			return $this->groups[0];
		return null;
	}
}   
?>
