<!--
	TODO:
	- Make the search_result sortable by columns name
	- Validation
-->
<div id="page_content">
	<!--Start Page Content-->
	<div id="content_wrapper" class="center-layout">
		<!--Start Content Wrapper-->
		<div class='clearfix'>
			&nbsp;
		</div>	
		<div class='title'>
			<h2>Password Reset</h2>
		</div>
		
		<div id="filter_password" class="filter ui-widget ui-widget-content ui-corner-all">
			<!--filter sections - with tab sliding effect-->
			<ul class='filter-tab'>
				<li id="properties" rel="filter_properties"></li>
				<li id="values" rel="filter_values"></li>
			</ul>
			<div id="filter_properties" class="filter-selection">
				<div>
					<label>Account Type</label>
					<div class="select-wrapper">	
						<!--We translate the account template into the matching database here,
						note that the value have to match the model (eg. mysql match Mysql_account.php)
						-->
						<select id="student_type">
							<option value='unknown'>Unknown</option>
							<option value='mysql'>Online</option>
							<option value='ldap'>Residential</option>
							<option value='ldap'>Faculty/Staff</option>
						</select>
					</div>
				</div>
				<div>
					<label>Search By (*)</label>
					<div class="select-wrapper">					
						<select id="search_filter">
							<!--The value here is mapped later on to match the field in each database-->
							<option value='username'>Username</option>
							<option value='lastname'>Last Name</option>
							<option value='firstname'>First Name</option>
							<option value='student_id'>Student ID</option>
						</select>
					</div>
				</div>				
				<div>
					&nbsp;
				</div>
			</div>
			<form id="validate_search_filter">	
			<div id="filter_values" class="filter-selection">												
				<div>
					<label>Search For (*)</label>
					<input type='text' id='search_value' value="" class="validate[required]"/>
					<!--This is a work around since jQuery validation will submit the form if there is only one input - $@!&&@#!-->
					<input type='text' id='fake_input' value="" style="display:none;"/>
					<input type="button" id="search_account" value="search" class="ui-button ui-state-default ui-corner-all ui-button-text-only"/>
				</div>				
			</div>
			</form>	
			<div class="main-instruction">
				&nbsp;
			</div>
			<!--End filter sections-->
			
			<!-- Sideblock-->	
			<div id="reset_history" class='sideblock'>
				<div class="sideblock-header ui-helper-clearfix ui-state-default ui-corner-all ui-helper-reset">History</div>
				<div class="sideblock-content">
					<table id="password_history">
					<tr class="table-header">
						<td>Account Reset</td>
						<td>By User</td>
						<td>Date Reset</td>						
					</tr>
					<?php 
					//load the history List handed down from the controller
					foreach ($historyList AS $record)
					echo "
						<tr>
							<td>".$record['accountReset']."</td>
							<td>".$record['userReset']."</td>
							<td>".$record['dateReset']."</td>
						</tr>
						";		
					?>
				</table>			
				</div>						
			</div>
			<!--End Sideblock-->				
		</div>
		
		<!--Tab Section-->	
		<div class="report ui-tabs ui-widget ui-widget-content ui-corner-all">
			<ul class="ui-tabs-nav ui-helper-clearfix ui-widget-header ui-corner-all">
				<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
					<a href="#overview">Overview</a></li>
				<li class="ui-state-default ui-corner-top">
					<a href="#filter_result">Matched Accounts</a></li>
				<li class="ui-state-default ui-corner-top">
					<a href="#reset_password">Reset</a></li>	
			</ul>
			
			<div id='overview' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom">
				<?php include("overview_password.inc.php");?>
			</div>
			<div id='filter_result' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
				<table id="matched_accounts">
					<tr class="table-header">
						<td>Student ID</td>
						<td>Username</td>
						<td>Firstname</td>
						<td>Lastname</td>
						<td class='account-exist'>Gmail</td>
						<td class='account-exist'>Moodle</td>
						<td class='account-exist'>Lab</td>
						<td>Type</td>
					</tr>
				</table>	
			</div>
			<!--Reset Password-->
			<div id='reset_password' class="report-content ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
				<div class="left">
				<div>
					<form id="validate_passwd_reset">					
					<div id="reset_info">
					</div>
					<!--temp place to store variable for javascript manipulation in different scope-->
					<input type="hidden" id="selected_account" value="" />
					<input type="hidden" id="selected_account_type" value="" />
					
					<div>
						<label>Enter New Password</label>			
						<input type="password" id="new_passwd" value="" class="validate[required,minSize[8],custom[mediumPassword]]"/>
					</div>
					<div>	
						<label>Confirm New Password</label>
						<input type="password" id="confirm_passwd" value= "" class="validate[required,equals[new_passwd]]" />
					</div>
					<div>
						<input type="button" id="reset_passwd" value="Submit" class="ui-button ui-state-default ui-corner-all ui-button-text-only"/>
						<input type="button" id="cancel_passwd" value="Cancel" class="plain-button"/>
					</div>
					</form>
				</div>						
				</div>
				<div class="right">					
					<div id="message_prompt">
						The new password must meet the following requirements:
						<ul>
							<li>Must be at least 8 characters</li>
							<li>Have at least 1 upper case letter</li>
							<li>Have at least 1 lower case letter</li>
							<li>Have at least 1 number</li>
						</ul>	
					</div>					
						
					<div class="email-content">
						<?php include("email_password_reset.inc.php");?>
					</div>		
				</div>			
			</div>
			<!--End Reset Password-->
			
			<div class="waiting-panel">
				<img src="./assets/ams/images/loading.gif"/>
			</div>		
		</div>
		<!--End Tab Section-->
				
		<!--End Content Wrapper-->			
	</div>
	<!--End Page Content-->		
</div>
<script type="text/javascript">
	/*
	* Some global variables used for the whole process
	*/
	var messagePrompt = $("#message_prompt").html();
	
	$(function() {
		
		$("#validate_passwd_reset").validationEngine();
		$("#validate_search_filter").validationEngine();
				
		/*********************************************************
		*   Tab Sliding Effect
		*********************************************************/
		$(".filter-tab li").click(function(){
			//vanish the background main instruction
			$('.main-instruction').animate({opacity:0},"slow");
			
			//slide our tab
			var activeid = $(".tab-active").attr('rel');						
			$("#"+activeid).animate({width: '0px'},'slow', function(){
				$("#"+activeid).css('display','none');
			});
			$(".tab-active").animate({left: '-=520'},'slow');
			
			var divid;
			if (!$(this).hasClass('tab-active'))
			{
				divid = $(this).attr('rel');
				$(".tab-active").removeClass('tab-active');
				$(this).addClass('tab-active');
				$(this).animate({left: '+=520'},'slow');
				$("#"+divid).css('display','block');
				$("#"+divid).animate({width: '460px'},'slow');							
			}	
			else
			{
				$('.main-instruction').animate({opacity:1},"slow");
				$(this).removeClass('tab-active');
			}
			return false;	
		});
		
		/**********************************************************
		*   Tab Effect
		***********************************************************/
		$(".report").tabs();
		//disable the last tab so people does not click on it
		$(".report").tabs("disable", 2);
		
		/**********************************************************
		*   Interaction
		***********************************************************/
		$("#student_type").change(function(){
			selectedAccountType = $(this).val();
		});
		$("#search_filter").change(function(){
			$("#values").click();
		});
		$("#search_value").keyup(function(event){
			if(event.keyCode == 13){
				$("#search_account").click();
			}
		});				
		$("#search_account").click(function(){			
			if(!jQuery('#validate_search_filter').validationEngine('validate'))
				return;
			
			
			searchAccount($("#search_filter").val(),$("#search_value").val());
			
			//reset all previous search and entry
			$("#cancel_passwd").click();
	
		});				
		$("#new_passwd,#confirm_passwd").keyup(function(event){
			if(event.keyCode == 13){
				$("#reset_passwd").click();
			}
		});
		$("#reset_passwd").click(function(){
			//validate the fields
			if(!jQuery('#validate_passwd_reset').validationEngine('validate'))
				return;
				
			//we pass in the variable from here rather than use it directly from the function
			//to make sure that the password is not reset on accident;
			resetPassword(
				$("#selected_account").val(),
				$("#selected_account_type").val(),
				$("#confirm_passwd").val()
			);
			
			//clear the current password
			$("#new_passwd").val("");
			$("#confirm_passwd").val("");						
		});		
		$("#cancel_passwd").click(function(){
			//clear the current password
			$("#new_passwd").val("");
			$("#confirm_passwd").val("");
			
			//tab back to the matched results
			$(".report").tabs('select', 1);
			$(".report").tabs("disable", 2);
		});
	});
	
	/***************************************************************
	* Helper functions
	****************************************************************/	
	function searchAccount(filterTypeParm, searchValueParm){
		$(".waiting-panel").show();
		//clear the previous search result but leave the header		
		var count = 0;
		$("#matched_accounts").find("tr").each(function(){
			if (count > 0)
				$(this).remove();
			count++;	
		});

		//begin new search
		var p = {
			filterType: filterTypeParm,
			searchValue: searchValueParm,
			accountType: $("#student_type").val()
		};		
		var record = "";
		$.ajax({
			url:		"/ams/account/searchAccount",
			cache:		false,
			data: 		p,
			type: 		'POST',
			dataType: 	'json',
			error: function(xhr, status, err) {			 
				alert(err);
			},
			success:  	function(json) {			
				var currentUser;
				
				if (jQuery.isEmptyObject(json)){
					record += "no record found for this search criteria";
				}	
				else{
					//parse the json object
					for (a in json)
					{			
						sid = json[a].sid;
						firstname = json[a].firstname;
						lastname = json[a].lastname;
						username = json[a].username;
						hasMoodle = json[a].hasMoodle;
						hasGmail = json[a].hasGmail;
						hasComputerLab = json[a].hasComputerLab;
						accountType = json[a].accountType;
						
						//append the result to the table
						recordHtml =
						"<tr id='" + username + "' class='account-result'>" +
							"<td>" + sid + "</td>" +
							"<td>" + username + "</td>" +
							"<td>" + firstname + "</td>" +
							"<td>" + lastname + "</td>" +
							"<td class='account-exist'>" + hasGmail + "</td>" +
							"<td class='account-exist'>" + hasMoodle + "</td>" +
							"<td class='account-exist'>" + hasComputerLab + "</td>" +
							"<td class='account-type'>" + accountType + "</td>" +
						"</tr>";
						$("#matched_accounts").append(recordHtml);
					}			
				} //end if
				
				//add the triggered action
				$(".account-result").click(function(){
					//clear all previous data and entry
					$("#cancel_passwd").click();
					
					//set the current user to reset
					$("#selected_account").val( $(this).attr('id') );
					//set the usertype for database selection					
					$("#selected_account_type").val($(this).find('td[class=account-type]').text());
					//prepare the prompt on the reset tab
					$("#reset_info").html("<p>Change password for user: " + $(this).attr('id') + "</p>");
					$("#message_prompt").html(messagePrompt);
					
					//tab to the reset tab
					$(".report").tabs("enable", 2);
					$( ".report" ).tabs("select", 2);
					
					//make sure the reset password form display
					$('#reset_password .left').animate({
								opacity: 1,
								width: 400}, 'fast',function(){
														//to resolve the stacking issue
														$('#reset_password .left div').show();
													});
					//clear any previous form validation
					jQuery('#validate_passwd_reset').validationEngine('hide');								
								
				}); //end click event
				
				$(".waiting-panel").hide();															
			} //end success function			
		}); //end ajax
	}		
		
	function resetPassword(usernameParm, accountTypeParm, newPasswordParm){
		var p = {
			username: usernameParm,
			accountType: accountTypeParm,
			newPassword: newPasswordParm
		};
		
		$.post("/ams/account/resetPassword", p,
			function(data) {
				//hide the reset pane			
				$('#reset_password .left').animate({
								opacity: 0,				
								width: 0}, 700, function(){
												//to resolve the stacking issue
													$('#reset_password .left div').hide();
												});
													
				//display the option to email info
				$("#message_prompt").html(
					"<div><h3>Account password changed successfully!</h3>" +					
						"<p>&nbsp;&nbsp;&nbsp;<a href='#' class='modal_colorbox'> > Email Account Info</a></p>" +
						"<p>&nbsp;&nbsp;&nbsp;<a href='#'> > Start New Search</a></p>" +					
					"</div>"					
				);
				
				//setup the modal box
				$(".modal_colorbox").colorbox({
					width:"950",
					inline:true,
					href:"#email_confirmation"
				});
				
				//fetch the username into email form - password fetching is optional but not recommended
				$(".reset-username").html(usernameParm);
				
				//setup the sendmail ajax function
				$("#sendMail").click(function(){
					var pm = {
						from: $("#txtFrom").val(),
						to: $("#txtTo").val(),
						cc: $("#txtCc").val(),
						subject: $("#txtSubject").val(),
						message: $("#txtMessage").val()
						};
					$("#emailConf").load("/ams/account/mailPasswordReset",pm);
					$(this).attr('disabled','disabled');
				});
				
				//update the history table
				$.ajax({
					url:		"/ams/account/updateHistory",
					cache:		false,
					type: 		'POST',
					dataType: 	'json',
					error: function(xhr, status, err) {			 
						alert(err);
					},
					success:  	function(json) {
						var newRecordHtml = ""+
							"<tr>" +
								"<td>"+json.accountReset+"</td>" +
								"<td>"+json.userReset+"</td>" +
								"<td>"+json.dateReset+"</td>" +
							"</tr>";

						$(newRecordHtml).insertAfter("#password_history .table-header");	
					}
				});				
																	
		});		
	}
</script>


