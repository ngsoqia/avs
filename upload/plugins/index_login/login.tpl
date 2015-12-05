{if !isset($smarty.session.uid)}
<div class="box">
	<div class="btitle"><h2>{t c='signup.login'}</h2></div>
	<div class="bcontent">
		<form name="login_form" method="post" action="{$relative}/login">
			<label for="login_username">{t c='global.username'}:</label><br />
			<input name="username" type="text" value="" id="login_username" class="login" /><br />
			<label for="login_password">{t c=global.password'}:</label><br />
            <input name="password" type="password" value="" id="login_password" class="login" /><br /><br />
			<a class="smaller" href="{$relative}/lost" rel="nofollow" id="lost_password">{t c='global.forgot'}</a><br />
			<a class="smaller" href="{$relative}/confirm" rel="nofollow" id="confirmation_email">{t c='global.confirm'}</a><br /><br />			
			<input name="submit_login" type="submit" value="{t c='global.login'}" id="login_submit" class="button" />
		</form>
	</div>
</div>
{/if}