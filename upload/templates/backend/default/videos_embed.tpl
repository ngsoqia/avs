     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="embedVideo" method="POST" enctype="multipart/form-data" action="videos.php?m=embed">
        <fieldset>
        <legend>Embed Video</legend>            
            <label for="username">Username: </label>
            <input name="username" type="text" value="{$video.username}"><br>
            <label for="title">Title: </label>
            <input name="title" type="text" value="{$video.title|escape:'html'}" class="large"><br />
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].CHID}"{if $video.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="tags">Tags: </label>
            <textarea name="tags" rows="6">{$video.tags|escape:'html'}</textarea><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $video.type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $video.type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
			<label for="duration">Duration: </label>
			<input name="duration" type="text" class="small" value="{$video.duration}" /><small>minutes:seconds (eg: 17:24)</small><br />
			<label for="embed_code">Embed Code: </label>
			<textarea name="embed_code" rows="10">{$video.embed_code}</textarea>
			<label for="thumb_1">Thumb(s): </label>
			<input name="thumb_1" type="file" id="thumb_1" />&nbsp;<a href="#" id="add_more_thumbs">add more</a><br />
			<div id="add_thumbs_container" style="display: none;"></div>
        </fieldset>
        <div style="text-align: center;">
            <input name="embed_video" type="submit" value="-- Embed Video --" id="save_video_button" class="button" onClick="document.getElementById('save_video_button').value='-- Embedding... --'";>
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
