     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Permissions Configuration</h2>
        <div id="simpleForm">
        <form name="permissions_settings" method="POST" action="index.php?m=permissions">
        <fieldset>
        <legend>Permission Settings</legend>
            <label for="user_registration" style="width: 40%;">User Registrations: </label>
            <select name="user_registration">
            <option value="1"{if $user_registration == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $user_registration == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="email_verification" style="width: 40%;">Email Verification: </label>
            <select name="email_verification">
            <option value="1"{if $email_verification == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $email_verification == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="video_view" style="width: 40%;">Video Watching: </label>
            <select name="video_view">
            <option value="all"{if $video_view == 'all'} selected="selected"{/if}>All Visitors</option>
            <option value="registered"{if $video_view == 'registered'} selected="selected"{/if}>Registered Members</option>
            </select><br>
            <label for="video_comments" style="width: 40%;">Video Comments: </label>
            <select name="video_comments">
            <option value="1"{if $video_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="photo_comments" style="width: 40%;">Photo Comments: </label>
            <select name="photo_comments">
            <option value="1"{if $photo_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $photo_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="blog_comments" style="width: 40%;">Blog Comments: </label>
            <select name="blog_comments">
            <option value="1"{if $blog_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $blog_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="wall_comments" style="width: 40%;">Wall Comments: </label>
            <select name="wall_comments">
            <option value="1"{if $video_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="private_msgs" style="width: 40%;">Private Messaging: </label>
            <select name="private_msgs">
            <option value="all"{if $private_msgs == 'all'} selected="selected"{/if}>All</option>
            <option value="friends"{if $private_msgs == 'friends'} selected="selected"{/if}>Friends</option>
            <option value="disabled"{if $private_msgs == 'disabled'} selected="selected"{/if}>Disabled</option>
            </select><br>
            <label for="video_rate" style="width: 40%;">Video Rating: </label>
            <select name="video_rate">
            <option value="user"{if $video_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $video_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
            <label for="photo_rate" style="width: 40%;">Photo Rating: </label>
            <select name="photo_rate">
            <option value="user"{if $photo_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $photo_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
            <label for="game_rate" style="width: 40%;">Game Rating: </label>
            <select name="game_rate">
            <option value="user"{if $game_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $game_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
			<label for="edit_videos" style="width: 40%;">Edit Videos: </label>
			<select name="edit_videos">
            <option value="0"{if $edit_videos == '0'} selected="selected"{/if}>No</option>
            <option value="1"{if $edit_videos == '1'} selected="selected"{/if}>Yes</option>			
			</select><br />
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_permissions" value="Update Permission Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>