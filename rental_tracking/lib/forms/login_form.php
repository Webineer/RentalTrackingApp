<form method="POST" action="<?php print $_SERVER["SCRIPT_NAME"] ?>" name="loginForm">
				
				<div align="center">
				
				<table cellpadding="0" cellspacing="2" border="0">
				
				<tr>
				
					<td><p>Username:</p></td>
					
					<td><input type="text" name="uname" id="uname" size="30" maxchars="100"></td>
				
				</tr>
				
				<tr>
				
					<td><p>Password:</p></td>
					
					<td><input type="password" name="pword" id="pword" size="30" maxchars="100"></td>
				
				</tr>
				
				<tr><td colspan="2"><br><div align="center"><button type="submit">Enter</button></div></td></tr>
				
				</table>
	
				</div>
</form>
<script language="Javascript">document.loginForm.uname.focus()</script>			

