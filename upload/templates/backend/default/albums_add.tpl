     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_album" method="POST" enctype="multipart/form-data" action="albums.php?m=add">
        <fieldset>
        <legend>Album Information</legend>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$album.username}" class="medium"><br>
            <label for="name">Name: </label>
            <input type="text" name="name" value="{$album.name}" class="large"><br>
            <label for="tags">Keywords (tags): </label>
            <textarea name="tags">{$album.tags}</textarea><br>
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].CHID}"{if $album.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $game.type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $game.type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Album Photos</legend>
            <label for="photo_1">File: </label>
            <input name="photo_1" type="file" id="photo_1" /><br />
            <label for="caption_1">Caption (optional): </label>
            <input name="caption_1" type="text" value="" maxlength="100" id="caption_1" class="large" /><br />
            <label for="photo_1">File: </label>
            <input name="photo_2" type="file" id="photo_2" /><br />
            <label for="caption_2">Caption (optional): </label>
            <input name="caption_2" type="text" value="" maxlength="100" id="caption_2" class="large" /><br />
            <label for="photo_1">File: </label>
            <input name="photo_3" type="file" id="photo_3" /><br />
            <label for="caption_3">Caption (optional): </label>
            <input name="caption_3" type="text" value="" maxlength="100" id="caption_3" class="large" /><br />
            <label for="photo_4">File: </label>
            <input name="photo_4" type="file" id="photo_4" /><br />
            <label for="caption_4">Caption (optional): </label>
            <input name="caption_4" type="text" value="" maxlength="100" id="caption_4" class="large" /><br />
            <label for="photo_5">File: </label>
            <input name="photo_5" type="file" id="photo_5" /><br />
            <label for="caption_5">Caption (optional): </label>
            <input name="caption_5" type="text" value="" maxlength="100" id="caption_5" class="large" /><br />
            <label for="photo_6">File: </label>
            <input name="photo_6" type="file" id="photo_6" /><br />
            <label for="caption_6">Caption (optional): </label>
            <input name="caption_6" type="text" value="" maxlength="100" id="caption_6" class="large" /><br />
            <label for="photo_7">File: </label>
            <input name="photo_7" type="file" id="photo_7" /><br />
            <label for="caption_7">Caption (optional): </label>
            <input name="caption_7" type="text" value="" maxlength="100" id="caption_7" class="large" /><br />
            <label for="photo_8">File: </label>
            <input name="photo_8" type="file" id="photo_8" /><br />
            <label for="caption_8">Caption (optional): </label>
            <input name="caption_8" type="text" value="" maxlength="100" id="caption_8" class="large" /><br />
            <label for="photo_9">File: </label>
            <input name="photo_9" type="file" id="photo_9" /><br />
            <label for="caption_9">Caption (optional): </label>
            <input name="caption_9" type="text" value="" maxlength="100" id="caption_9" class="large" /><br />
            <label for="photo_10">File: </label>
            <input name="photo_10" type="file" id="photo_10" /><br />
            <label for="caption_10">Caption (optional): </label>
            <input name="caption_10" type="text" value="" maxlength="100" id="caption_10" class="large" /><br />
            <label for="photo_11">File: </label>
            <input name="photo_11" type="file" id="photo_11" /><br />
            <label for="caption_11">Caption (optional): </label>
            <input name="caption_11" type="text" value="" maxlength="100" id="caption_11" class="large" /><br />
            <label for="photo_12">File: </label>
            <input name="photo_12" type="file" id="photo_12" /><br />
            <label for="caption_12">Caption (optional): </label>
            <input name="caption_12" type="text" value="" maxlength="100" id="caption_12" class="large" /><br />
            <label for="photo_13">File: </label>
            <input name="photo_13" type="file" id="photo_13" /><br />
            <label for="caption_13">Caption (optional): </label>
            <input name="caption_13" type="text" value="" maxlength="100" id="caption_13" class="large" /><br />
            <label for="photo_14">File: </label>
            <input name="photo_14" type="file" id="photo_14" /><br />
            <label for="caption_14">Caption (optional): </label>
            <input name="caption_14" type="text" value="" maxlength="100" id="caption_14" class="large" /><br />
            <label for="photo_15">File: </label>
            <input name="photo_15" type="file" id="photo_15" /><br />
            <label for="caption_15">Caption (optional): </label>
            <input name="caption_15" type="text" value="" maxlength="100" id="caption_15" class="large" /><br />
            <div id="upload_photo_container"></div>
        </fieldset>
        <a href="#add_more" id="add_more_photos" class="add_more_images">Add More Photos</a><br />
        <div style="text-align: center;">
            <input type="submit" name="add_album" value="Add Album" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>