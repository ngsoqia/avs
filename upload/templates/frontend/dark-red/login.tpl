<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="well bs-component">
				<form class="form-horizontal" name="login_form" id="login_form" method="post" action="{$relative}/login">
				  <fieldset>
					<legend>{t c='login.title' s=$site_name}</legend>
					
						<div class="form-group {if $errors}has-error{/if}">
							<label for="login_username" class="col-lg-3 control-label">{t c='global.username'}</label>
							<div class="col-lg-9">
								<input name="username" type="text" class="form-control" value="" id="login_username" placeholder="{t c='global.username'}" />
							</div>
						</div>

						<div class="form-group {if $errors}has-error{/if}">
							<label for="login_password" class="col-lg-3 control-label">{t c='global.password'}</label>
							<div class="col-lg-9">
								<input name="password" type="password" class="form-control" value="" id="login_password" placeholder="{t c='global.password'}" />
								<div class="checkbox">
									<label>
										<input name="login_remember" type="checkbox" id="login_remember" /> {t c='global.remember'}
									</label>
								</div>							
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<a href="{$relative}/lost" rel="nofollow">{t c='global.forgot'}</a>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<a href="{$relative}/confirm" rel="nofollow">{t c='global.confirm'}</a>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button name="submit_login" type="submit" class="btn btn-primary">{t c='global.login'}</button>
							</div>
						</div>
						
				  </fieldset>
				</form>		
			</div>
		</div>
		<div class="col-md-6">
			<div class="well bs-component">
				<legend>{t c='global.what_is' s=$site_name}</legend>
				{include file='static/whatis.tpl'}
			</div>
		</div>
	</div>
</div>