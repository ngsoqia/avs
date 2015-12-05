     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_album" method="POST" enctype="multipart/form-data" action="albums.php?m=addphoto&AID={$album.AID}">
        <fieldset>
        <legend>Album Information</legend>
            <label for="name">Name: </label>
            <input type="text" name="name" value="{$album.name}" class="large"><br>
        </fieldset>
        <fieldset>
        <legend>Album Photos</legend>
            <label for="photo_1">File: </label>
            <input name="photo_1" type="file" id="photo_1" /><br />
            <label for="caption_1">Caption (optional): </label>
            <input name="caption_1" type="text" value="" maxlength="100" id="caption_1" class="large" /><br />
            <div id="upload_photo_container"></div>
        </fieldset>
        <a href="#add_more" id="add_more_photos" class="add_more_images">Add More Photos</a><br />
        <div style="text-align: center;">
            <input type="submit" name="add_photos" value="Add Photos" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>