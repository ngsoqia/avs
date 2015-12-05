     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>System Settings</h2>
        <div id="simpleForm">
        <form name="system_settings" method="POST" action="index.php?m=main">
        <fieldset>
        <legend>Site Settings</legend>
            <label for="site_name">Site Name: </label>
            <input type="text" name="site_name" value="{$site_name}" class="large"><br>
            <label for="site_title">Site Title: </label>
            <input type="text" name="site_title" value="{$site_title}" class="large"><br>
            <label for="meta_description">Meta Description: </label>
            <input type="text" name="meta_description" value="{$meta_description}" class="large"><br>
            <label for="meta_keywords">Meta Keywords: </label>
            <input type="text" name="meta_keywords" value="{$meta_keywords}" class="large"><br>
        </fieldset>
        <fieldset>
        <legend>Admin Settings</legend>
            <label for="admin_name">Admin Username: </label>
            <input type="text" name="admin_name" value="{$admin_name}" class="large"><br>
            <label for="admin_pass">Admin Password: </label>
            <input type="password" name="admin_pass" value="{$admin_pass}" class="large"><br>
            <label for="admin_email">Admin Email: </label>
            <input type="text" name="admin_email" value="{$admin_email}" class="large"><br>
            <label for="noreply_email">Admin NoReply Email: </label>
            <input type="text" name="noreply_email" value="{$noreply_email}" class="large"><br>            
        </fieldset>
		<fieldset>
		<legend>Template Settings</legend>
			<label for="template">Template: </label>
			<select name="template">
			{foreach from=$templates key=k item=v}
			<option value="{$k}"{if $k == $template} selected="selected"{/if}>{$v}</option>
			{/foreach}
			</select><br />			
		</fieldset>
        <fieldset>
        <legend>Embed Settings</legend>
            <label for="video_embed">Embed Videos: </label>
            <select name="video_embed">
            <option value="1"{if $video_embed == '1'} selected="selected"{/if}>Enabled</option>            
            <option value="0"{if $video_embed == '0'} selected="selected"{/if}>Disabled</option>
            </select><br />
        </fieldset>
		<fieldset>
		<legend>Language Settings</legend>
			<label for="language">Language:</label>
			<select name="language">
			{foreach from=$languages key=k item=v}
			<option value="{$k}"{if $k == $language} selected="selected"{/if}>{$v.name}</option>
			{/foreach}
			</select><br />
			<label for="multi_language">Multi Language:</label>
			<select name="multi_language">
			<option value="0"{if $multi_language == '0'} selected="selected"{/if}>Disabled</option>
			<option value="1"{if $multi_language == '1'} selected="selected"{/if}>Enabled</option>
			</select>
		</fieldset>
		<fieldset>
		<legend>Enter Page Settings</legend>
			<label for="splash">Enter page:</label>
			<select name="splash">
			<option value="0"{if $splash == '0'} selected="selected"{/if}>Disabled</option>
			<option value="1"{if $splash == '1'} selected="selected"{/if}>Enabled</option>
			</select>
			<br /><br /><small>Please note that if the Enter Page is Enabled, search engine spiders won't be able to index your website.</small>
		</fieldset>
        <fieldset>
        <legend>Advertising Settings</legend>
            <label for="ads">Ads: </label>
            <select name="ads">
            <option value="1"{if $ads == '1'} selected="selected"{/if}>Enabled</option>
            <option value="0"{if $ads == '0'} selected="selected"{/if}>Disabled</option>
            </select><br />
        </fieldset>
        <fieldset>
        <legend>System Settings</legend>
            <label for="gzip_encoding">Gzip Encoding: </label>
            <select name="gzip_encoding">
            <option value="1"{if $gzip_encoding == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $gzip_encoding == '0'} selected="selected"{/if}>No</option>
            </select><small>Please make sure that your server supports this.</small><br>
            <label for="captcha">Signup Captcha: </label>
            <select name="captcha">
            <option value="1"{if $captcha == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $captcha == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="downloads">Videos Downloads: </label>
            <select name="downloads">
            <option value="1"{if $downloads == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $downloads == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="del_original_video">Delete Original Video: </label>
            <select name="del_original_video">
            <option value="1"{if $del_original_video == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $del_original_video == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="approve">Approve Videos: </label>
            <select name="approve">
            <option value="1"{if $approve == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $approve == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="approve_photos">Approve Photos: </label>
            <select name="approve_photos">
            <option value="1"{if $approve_photos == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $approve_photos == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="approve_games">Approve Games: </label>
            <select name="approve_games">
            <option value="1"{if $approve_games == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $approve_games == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="approve_blogs">Approve Blogs: </label>
            <select name="approve_blogs">
            <option value="1"{if $approve_blogs == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $approve_blogs == '0'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Paging Settings</legend>
            <label for="videos_per_page">Videos Per Page: </label>
            <input type="text" name="videos_per_page" value="{$videos_per_page}" class="small"><br>
            <label for="albums_per_page">Albums Per Page: </label>
            <input type="text" name="albums_per_page" value="{$albums_per_page}" class="small"><br>
            <label for="games_per_page">Games Per Page: </label>
            <input type="text" name="games_per_page" value="{$games_per_page}" class="small"><br>
            <label for="blogs_per_page">Blogs Per Page: </label>
            <input type="text" name="blogs_per_page" value="{$blogs_per_page}" class="small"><br>
            <label for="users_per_page">Users Per Page: </label>
            <input type="text" name="users_per_page" value="{$users_per_page}" class="small"><br>
            <label for="watched_per_page">Watched Per Page: </label>
            <input type="text" name="watched_per_page" value="{$watched_per_page}" class="small"><br>
            <label for="recent_per_page">Recent Per Page: </label>
            <input type="text" name="recent_per_page" value="{$recent_per_page}" class="small"><br>        
        </fieldset>
		<fieldset>
		<legend>Multi Server System</legend>
			<label for="multi_server">Multi Server: </label>
			<select name="multi_server">
			<option value="0"{if $multi_server == '0'} selected="selected"{/if}>Disabled</option>
			<option value="1"{if $multi_server == '1'} selected="selected"{/if}>Enabled</option>
			</select>
		</fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_settings" value="Update System Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>