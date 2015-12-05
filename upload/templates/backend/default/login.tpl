    <div id="login_errors" align="center">
		{if $err}<div id="errorbox">{$err}</div>{/if}
		{if $msg}<div id="messagebox">{$msg}</div>{/if}
	</div>

    <div id="login" align="center">
        <div id="simpleForm">
        <form name="logig" method="POST" action="login.php">
        <label for="username">Username: </label>
        <input name="username" type="text" class="large"><br>
        <label for="password">Password: </label>
        <input name="password" type="password" class="large">

		<label></label>
        <input type="submit" name="submit_login" value="Login" class="button" style="margin-left: 10px; margin-top: 10px; margin-bottom: 5px;">
        <input type="submit" name="submit_forgot" value="Forgot Password" class="button">

        </form>
        </div>
    </div>
    </div>
</div>