<form action="{$PHP_SELF}" method="post" name="loginform" id="loginform" style="margin: 100px;">
  <div align="center">
  	{if $LOGIN_ERROR}
			<p style="color: #FF0000;">The username or password you entered is incorrect.<br />  
				 Please double-check them and try again.
		  </p>
		{/if}
		<table>
			<tr>
				<td><label for="uid" accesskey="u"><u>U</u>sername:</label></td>
				<td><input name="uid" type="text" class="textbox" id="uid" tabindex="1" /></td>
			</tr>
			<tr>
				<td><label for="pwd" accesskey="p"><u>P</u>assword:</label></td>
				<td><input name="pwd" type="password" class="textbox" id="pwd" tabindex="2" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="loginsubmit" value="Submit" tabindex="3"></td>
			</tr>
		</table>
	</div>
</form>