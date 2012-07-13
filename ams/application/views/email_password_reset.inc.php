<?php
	$controlPanel = array(
		'id'        =>      'frmControlPanel'
	);
	$emailForm = array(
		'id'        =>      'frmEmailUser'
	);
	$txtFrom = array(
		'name'      =>      'txtFrom',
		'id'        =>      'txtFrom',
		'value'     =>      'helpdesk@tntemple.edu'
	);
	$txtTo = array(
		'name'      =>      'txtTo',
		'id'        =>      'txtTo',
		'value'     =>      ''
	);
	$txtCc = array(
		'name'      =>      'txtCc',
		'id'        =>      'txtCc',
		'value'     =>      'admissions@tntemple.edu'
	);
            
	$txtSubject = array(
		'name'      =>      'txtSubject',
		'id'        =>      'txtSubject',
		'value'     =>      'Password Reset Information'
	);	

	//the template	
	$message = "
Dear,
Your login information has been reset to

Your username is:
Your password is:

You can login to webmail service at:
http://webmail.tntemple.edu

You can login to moodle academic service at:
http://lms.tntemple.edu

For password reset request, please visit:
http://support.tntemple.edu/getmylogin

If you have any question or concern, please feel free to contact us
at helpdesk@tntemple.edu or via the web at http://support.tntemple.edu.
";
	$txtMessage = array(
		'name'      =>      'txtMessage',
		'id'        =>      'txtMessage',
		'rows'      =>      '20',
		'value'     =>      $message
	);
?>
<!-- test comment -->
<!-- This contains the hidden content for inline calls -->
<div style='display:none'>
	<div id='email_confirmation' style='padding:10px; background:#fff;'>
		<div class="heading">
			Password change for user: <span class="reset-username"></span>
		</div>                   
		<div class="inline_block" id="emailConf">
			<?php echo form_open('#',$emailForm);?>			
				<div class="inline">
					<label for="txtFrom">From: </label>
					<?php echo form_input($txtFrom);?>
				</div>
				<div class="inline">
					<label for="txtTo">To: </label>
					<?php echo form_input($txtTo);?>
				</div>
				<div class="inline">
					<label for="txtSubject">Subject: </label>
					<?php echo form_input($txtSubject);?>
				</div>
				<div class="inline">
					<label for="txtCc">Cc: </label>
					<?php echo form_input($txtCc);?>
				</div>
			<div id='account_template'>
				<?php echo form_textarea($txtMessage);?>
			</div>
			<?php echo form_close();?>
		</div>                    		
		<div class="button_row">
			<input type="button" id="sendMail" value ="Send Email" />			
		</div>				
	</div>
</div>

	
