     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_video" method="POST" action="videos.php?m=edit&VID={$video[0].VID}">
        <fieldset>
        <legend>Video Information</legend>
            <label for="VID">Vide ID: </label>
            <input type="text" name="VID" value="{$video[0].VID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$video[0].UID}" readonly="readonly" class="large"><br>
            <label for="title">Title: </label>
            <input type="text" name="title" value="{$video[0].title}" class="large"><br>
            <label for="keyword">Keywords (tags): </label>
            <textarea name="keyword">{$video[0].keyword}</textarea><br>
            <label for="channel">Channel: </label>
            <select name="channel">
            {section name=i loop=$channels}
            <option value="{$channels[i].CHID}"{if $video[0].channel == $channels[i].CHID} selected="selected"{/if}>{$channels[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $video[0].type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $video[0].type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
            <label for="active">Approved (active): </label>
            <select name="active">
            <option value="1"{if $video[0].active == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video[0].active == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="featured">Is Featured: </label>
            <select name="featured">
            <option value="yes"{if $video[0].featured == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].featured == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be commented? </label>
            <select name="be_comment">
            <option value="yes"{if $video[0].be_comment == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].be_comment == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be rated? </label>
            <select name="be_rated">
            <option value="yes"{if $video[0].be_rated == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $video[0].be_rated == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_comment">Can be embeded? </label>
            <select name="embed">
            <option value="enabled"{if $video[0].embed == 'enabled'} selected="selected"{/if}>Yes</option>
            <option value="disabled"{if $video[0].embed == 'disabled'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Video Thumb</legend>
            <div style="width: 100%; text-align: center;">
            <input type="hidden" name="thumb" id="{$video[0].vkey}" value="{$video[0].thumb}">
            {insert name=video_thumbs assign=thumbs VID=$video[0].VID vkey=$video[0].vkey thumb=$video[0].thumb}
            {$thumbs}
            </div>
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
			{if $multi_server == '1'}
			<label for="server">Server: </label>
			<input name="server" type="text" value="{$video[0].server}" class="large" /><br />
			{/if}
            <label for="rate">Rating: </label>
            <input type="text" name="rate" value="{$video[0].rate}"><br>
            <label for="ratedby">Rated by: </label>
            <input type="text" name="ratedby" value="{$video[0].ratedby}"><br>
            <label for="viewnumber">Views: </label>
            <input type="text" name="viewnumber" value="{$video[0].viewnumber}"><br>
            <label for="com_num">Comments: </label>
            <input type="text" name="com_num" value="{$video[0].com_num}"><br>
            <label for="fav_num">Favorites: </label>
            <input type="text" name="fav_num" value="{$video[0].fav_num}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="edit_video" value="Update Video" class="button">
            <input type="button" name="edit_video_advanced" id="edit_video_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>