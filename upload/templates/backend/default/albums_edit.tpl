     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_album" method="POST" action="albums.php?m=edit&AID={$album.AID}">
        <fieldset>
        <legend>Album Information</legend>
            <label for="AID">Album ID: </label>
            <input type="text" name="AID" value="{$album.AID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$album.username}" readonly="readonly" class="large"><br>
            <label for="title">Name: </label>
            <input type="text" name="name" value="{$album.name|escape:'html'}" class="large"><br>
            <label for="tags">Tags: </label>
            <textarea name="tags">{$album.tags}</textarea><br>
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].CHID}"{if $album.category == $categories[i].CHID} selected="yes"{/if}>{$categories[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $album.type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $album.type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
            <label for="status">Status: </label>
            <select name="status">
            <option value="1"{if $album.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $album.status == '0'} selected="selected"{/if}>Suspended</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Album Cover</legend>
            <label for="current_cover">Current Cover:</label>
            <img src="{$relative}/media/albums/{$album.AID}.jpg?{0|rand:100}" id="current_cover" style="margin: 10px;"/><br />
            <label for="select_cover">Select Cover:</label><br />
            <div class="select_cover">
                {section name=i loop=$photos}
                <a href="albums.php?m=viewphoto&AID={$album.AID}&PID={$photos[i].PID}" id="album_photo_{$photos[i].PID}"><img src="{$relative}/media/photos/tmb/{$photos[i].PID}.jpg" id="album_photo_{$photos[i].PID}"  width="150" height="150" /></a>
                {/section}
            </div><br />
			<input name="x1" type="hidden" value="0" id="x1" />
			<input name="y1" type="hidden" value="0" id="y1" />
			<input name="x2" type="hidden" value="400" id="x2" />
			<input name="y2" type="hidden" value="400" id="y2" />
			<input name="width" type="hidden" value="400" id="width" />
			<input name="height" type="hidden" value="400" id="height" />

			<input name="x1-i" type="hidden" value="0" id="x1-i" />
			<input name="y1-i" type="hidden" value="0" id="y1-i" />
			<input name="x2-i" type="hidden" value="400" id="x2-i" />
			<input name="y2-i" type="hidden" value="400" id="y2-i" />
			<input name="width-i" type="hidden" value="400" id="width-i" />
			<input name="height-i" type="hidden" value="400" id="height-i" />							
			
			<input name="photo" type="hidden" value="1" id="photo" />
			<input name="random" type="hidden" value="" id="random" />
			<input name="init-s" type="hidden" value="0" id="init-s" />
            <label for="crop_cover">Crop Cover:</label>
            <img src="{$relative}/media/albums/{$album.AID}.jpg" id="album_cover" class="album_cover" style="border: none!important; margin: 10px!important; padding: 0!important;" /><br />
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="rate">Rating: </label>
            <input type="text" name="rate" value="{$album.rate}"><br>
            <label for="ratedby">Rated by: </label>
            <input type="text" name="ratedby" value="{$album.ratedby}"><br>
            <label for="viewnumber">Views: </label>
            <input type="text" name="total_views" value="{$album.total_views}"><br>
            <label for="com_num">Comments: </label>
            <input type="text" name="total_comments" value="{$album.total_comments}"><br>
            <label for="fav_num">Favorites: </label>
            <input type="text" name="total_favorites" value="{$album.total_favorites}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="submit_album_edit" value="Update Album" class="button">
            <input type="button" name="edit_album_advanced" id="edit_video_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>