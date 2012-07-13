<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Authentication_handler extends CI_Model
{
	var $username = '';
	var $password = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('zend_framework');
        Zend_Loader::loadClass('Zend_Http_Client');
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_Gapps');      
    }
    function setUsername($usernameParm)
    {
		$this->username = $usernameParm;
	}
	function setPassword($passwordParm)
	{
		$this->password = $passwordParm;
	}
	function isAuthenticated()
	{
		$domain = $this->config->item('domain');
        $email = $this->username . "@$domain";;
        $passwd = $this->password;
       		
        try {
            $client = Zend_Gdata_ClientLogin::getHttpClient($email, $passwd, Zend_Gdata_Gapps::AUTH_SERVICE_NAME);
            $gdata = new Zend_Gdata_Gapps($client, $domain);
            if ($gdata->isAuthenticated())
            {
				if ($this->_check_permission($this->username)=="admin")
					return true;
				else
					return false;			
            }
            else
                return false;
        } catch (Zend_Gdata_App_Exception $e) {
            return false;
        }
	}
	
	function _check_permission($user)
    {
        $domain = $this->config->item('domain');
        $email = $this->config->item('admin_email');
        $passwd = $this->config->item('admin_passwd');

        $client = Zend_Gdata_ClientLogin::getHttpClient($email, $passwd, Zend_Gdata_Gapps::AUTH_SERVICE_NAME);
        $gdata = new Zend_Gdata_Gapps($client, $domain);
        
        if ($gdata->isMember($user.'@'.$domain, $this->config->item('admin_group')))
        {
            return "admin";
        }
        return "user";
    }
}
