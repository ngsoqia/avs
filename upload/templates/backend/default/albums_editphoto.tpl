     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_album" method="POST" action="albums.php?m=editphoto&PID={$photo.PID}">
        <fieldset>
        <legend>Photo Information</legend>
            <label for="PID">Photo ID: </label>
            <input type="text" name="PID" value="{$photo.PID}" readonly="readonly"><br>
            <label for="caption">Caption: </label>
            <input type="text" name="caption" value="{$photo.caption}" class="large"><br>
            <label for="status">Status: </label>
            <select name="status">
            <option value="1"{if $album.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $album.status == '0'} selected="selected"{/if}>Suspended</option>
            </select><br>
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="rate">Rating: </label>
            <input type="text" name="rate" value="{$photo.rate}"><br>
            <label for="ratedby">Rated by: </label>
            <input type="text" name="ratedby" value="{$photo.ratedby}"><br>
            <label for="viewnumber">Views: </label>
            <input type="text" name="total_views" value="{$photo.total_views}"><br>
            <label for="com_num">Comments: </label>
            <input type="text" name="total_comments" value="{$photo.total_comments}"><br>
            <label for="fav_num">Favorites: </label>
            <input type="text" name="total_favorites" value="{$photo.total_favorites}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="submit_photo_edit" value="Update Photo" class="button">
            <input type="button" name="edit_album_advanced" id="edit_video_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>