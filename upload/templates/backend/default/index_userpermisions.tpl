     <div id="rightcontent">
        {include file="errmsg.tpl"}
		<div id="right">
        <div align="center">
        <h2>User permsions settings</h2>
        <div id="simpleForm">
        <form name="user_permisions" method="POST" action="index.php?m=userpermisions">
        <fieldset>
        <legend>Visitors / Guests</legend>
            <label for="visitors_watch_normal_videos">Watch normal videos</label>
            <select name="visitors_watch_normal_videos">
				<option value='1' {if $visitors_watch_normal_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $visitors_watch_normal_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="visitors_watch_hd_videos">Watch HD videos</label>
            <select name="visitors_watch_hd_videos">
				<option value='1' {if $visitors_watch_hd_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $visitors_watch_hd_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
			<script type='text/javascript'>
			{literal}
				function gbandwidth(id){
					var val = document.getElementById(id).value
					if(val == '1'){
						document.getElementById('gbandw').style.display = "block";
						var val_tmp = document.getElementById('gselbandw').value;
						if (val_tmp == '-1') val_tmp = '';
						document.getElementById('gbandwi').value = val_tmp;
					} else{
						document.getElementById('gbandw').style.display = "none";
						document.getElementById('gbandwi').value = '-1';
					}
				}
				function fbandwidth(id){
					var val = document.getElementById(id).value
					if(val == '1'){
						document.getElementById('fbandw').style.display = "block";
						var val_tmp = document.getElementById('fselbandw').value;
						if (val_tmp == '-1') val_tmp = '';
						document.getElementById('fbandwi').value = val_tmp;
					} else{
						document.getElementById('fbandw').style.display = "none";
						document.getElementById('fbandwi').value = '-1';
					}
				}
				function pbandwidth(id){
					var val = document.getElementById(id).value
					if(val == '1'){
						document.getElementById('pbandw').style.display = "block";
						var val_tmp = document.getElementById('pselbandw').value;
						if (val_tmp == '-1') val_tmp = '';
						document.getElementById('pbandwi').value = val_tmp;
					} else{
						document.getElementById('pbandw').style.display = "none";
						document.getElementById('pbandwi').value = '-1';
					}
				}
	        {/literal}
			</script>
            <label for="visitors_bandwidth">Bandwidth limit</label>
			<select name="visitors_bandwidth_select" id="visitors_bandwidth" onchange="gbandwidth(this.id)">
	        <option value="-1"{if $visitors_bandwidth eq "-1"} selected="selected"{/if}>Disabled</option>
	        <option value="1"{if $visitors_bandwidth > "-1"} selected="selected"{/if}>Enabled</option>
	        </select><br>
			<div id='gbandw' style='display: {if $visitors_bandwidth == '-1'} none; {else} block; {/if}'>
				<input type='hidden' id='gselbandw' style='display: none' value='{$visitors_bandwidth}'>
				<label for="visitors_bandwidth">Bandwidth limit</label>
				<input id='gbandwi' type="text" name="visitors_bandwidth" value="{$visitors_bandwidth}" class="small"> MB<br>
			</div>
            <label for="visitors_sd_downloads">SD downloads</label>
            <select name="visitors_sd_downloads">
				<option value='1' {if $visitors_sd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $visitors_sd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="visitors_hd_downloads">HD downloads</label>
            <select name="visitors_hd_downloads">
				<option value='1' {if $visitors_hd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $visitors_hd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="visitors_mobile_downloads">Mobile downloads</label>
            <select name="visitors_mobile_downloads">
				<option value='1' {if $visitors_mobile_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $visitors_mobile_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="visitors_in_player_ads">In-Player Ads</label>
            <select name="visitors_in_player_ads">
				<option value='1' {if $visitors_in_player_ads == '1'}selected="selected"{/if}>Show</option>
				<option value='0' {if $visitors_in_player_ads == '0'}selected="selected"{/if}>Don't show</option>
			</select><br>
        </fieldset>
        <fieldset>
        <legend>Free (Registered) Users</legend>
            <label for="free_watch_normal_videos">Watch normal videos</label>
            <select name="free_watch_normal_videos">
				<option value='1' {if $free_watch_normal_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_watch_normal_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="free_watch_hd_videos">Watch HD videos</label>
            <select name="free_watch_hd_videos">
				<option value='1' {if $free_watch_hd_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_watch_hd_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="free_bandwidth">Bandwidth limit</label>
			<select name="visitors_bandwidth_select" id="free_bandwidth" onchange="fbandwidth(this.id)">
	        <option value="-1"{if $free_bandwidth eq "-1"} selected="selected"{/if}>Disabled</option>
	        <option value="1"{if $free_bandwidth > "-1"} selected="selected"{/if}>Enabled</option>
	        </select><br>
			<div id='fbandw' style='display: {if $free_bandwidth == '-1'} none; {else} block; {/if}'>
				<input type='hidden' id='fselbandw' style='display: none' value='{$free_bandwidth}'>
				<label for="free_bandwidth">Bandwidth limit</label>
				<input id='fbandwi' type="text" name="free_bandwidth" value="{$free_bandwidth}" class="small"> MB<br>
			</div>
            <label for="free_sd_downloads">SD downloads</label>
            <select name="free_sd_downloads">
				<option value='1' {if $free_sd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_sd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="free_hd_downloads">HD downloads</label>
            <select name="free_hd_downloads">
				<option value='1' {if $free_hd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_hd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="free_mobile_downloads">Mobile downloads</label>
            <select name="free_mobile_downloads">
				<option value='1' {if $free_mobile_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_mobile_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="free_in_player_ads">In-Player Ads</label>
            <select name="free_in_player_ads">
				<option value='1' {if $free_in_player_ads == '1'}selected="selected"{/if}>Show</option>
				<option value='0' {if $free_in_player_ads == '0'}selected="selected"{/if}>Don't show</option>
			</select><br> 
            <label for="free_write_in_blog">Write blogs</label>
            <select name="free_write_in_blog">
				<option value='1' {if $free_write_in_blog == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_write_in_blog == '0'}selected="selected"{/if}>No</option>
			</select><br> 
            <label for="free_upload_video">Upload Videos / Photos / Games</label>
            <select name="free_upload_video">
				<option value='1' {if $free_upload_video == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $free_upload_video == '0'}selected="selected"{/if}>No</option>
			</select><br>          
        </fieldset>
		<fieldset>
		<legend>Premium Users</legend>
			<label for="premium_watch_normal_videos">Watch normal videos</label>
            <select name="premium_watch_normal_videos">
				<option value='1' {if $premium_watch_normal_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_watch_normal_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="premium_watch_hd_videos">Watch HD videos</label>
            <select name="premium_watch_hd_videos">
				<option value='1' {if $premium_watch_hd_videos == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_watch_hd_videos == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="premium_bandwidth">Bandwidth limit</label>
			<select name="visitors_bandwidth_select" id="premium_bandwidth" onchange="pbandwidth(this.id)">
	        <option value="-1"{if $premium_bandwidth eq "-1"} selected="selected"{/if}>Disabled</option>
	        <option value="1"{if $premium_bandwidth > "-1"} selected="selected"{/if}>Enabled</option>
	        </select><br>
			<div id='pbandw' style='display: {if $premium_bandwidth == '-1'} none; {else} block; {/if}'>
				<input type='hidden' id='pselbandw' style='display: none' value='{$premium_bandwidth}'>
				<label for="premium_bandwidth">Bandwidth limit</label>
				<input id='pbandwi' type="text" name="premium_bandwidth" value="{$premium_bandwidth}" class="small"> MB<br>
			</div>
            <label for="premium_sd_downloads">SD downloads</label>
            <select name="premium_sd_downloads">
				<option value='1' {if $premium_sd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_sd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="premium_hd_downloads">HD downloads</label>
            <select name="premium_hd_downloads">
				<option value='1' {if $premium_hd_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_hd_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="premium_mobile_downloads">Mobile downloads</label>
            <select name="premium_mobile_downloads">
				<option value='1' {if $premium_mobile_downloads == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_mobile_downloads == '0'}selected="selected"{/if}>No</option>
			</select><br>
            <label for="premium_in_player_ads">In-Player Ads</label>
            <select name="premium_in_player_ads">
				<option value='1' {if $premium_in_player_ads == '1'}selected="selected"{/if}>Show</option>
				<option value='0' {if $premium_in_player_ads == '0'}selected="selected"{/if}>Don't show</option>
			</select><br>	
            <label for="premium_write_in_blog">Write blogs</label>
            <select name="premium_write_in_blog">
				<option value='1' {if $premium_write_in_blog == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_write_in_blog == '0'}selected="selected"{/if}>No</option>
			</select><br> 
            <label for="premium_upload_video">Upload Videos / Photos / Games</label>
            <select name="premium_upload_video">
				<option value='1' {if $premium_upload_video == '1'}selected="selected"{/if}>Yes</option>
				<option value='0' {if $premium_upload_video == '0'}selected="selected"{/if}>No</option>
			</select><br>  		
		</fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_permisions_users" value="Update Permissions" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>	 </div>