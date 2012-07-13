<div>
<h3>Password Reset Process Overview</h3>
<ul>
	<li>
		<h4>Password Policy</h4>
		<p>
			The new password must meet the following requirements:
			<ul>
				<li>Must be at least 8 characters</li>
				<li>Have at least 1 upper case letter</li>
				<li>Have at least 1 lower case letter</li>
				<li>Have at least 1 number</li>
			</ul>	
		</p>	
	</li>
	<li>
		<h4>Database selection</h4>
		<ul>
			<li>
			If an account is a <strong>residential account</strong> (residential student, staff, faculty,...) This will lookup the account in the <strong>active directory database</strong> and change the password from there.
			</li>
			<li>
			If an account is an <strong>online account</strong> (online student) This will look up the account in the online <strong>mysql database.</strong>
			</li>
			<li>
			If you choose <strong>unknown</strong>, it will first search the mysql database (since we have more online student), then search the active directory database. This method is <strong>not recommended</strong> since it take longer time and heavier load on both database, but in case we need to, it is available.
			</li>
		</ul>	
	</li>
	<li>
		<h4>History</h4>
		<p>
			For record keeping purpose, history of password change is also recorded. To minimize the database load, we only display 50 most recent records. However, the full list can be retrieved from the database.
		</p>
	</li>
	<li>
		<h4>Email Account Info</h4>
		<p>
			For your convenient, a template to email account info to user is provided. After you reset the user password, you will have the option to email it to the user. Please make note that at this version, you still have to type in the username and password manually in the form.
		</p>
	</li>			
</ul>	
</div>
