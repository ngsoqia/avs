     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="save_video" method="POST" action="videos.php?m=add">
        {if $video.site != ''}
        <fieldset>
        <legend>Save: {$video.title}</legend>            
            <input name="video_id" type="hidden" value="{$video.id}" />
			<input name="embed" type="hidden" value="{$embed}" />
            <label for="username">Username: </label>
            <input name="username" type="text" value="{$video.username}"><br>
            <label for="site">Site: </label>
            <select name="site">
            {section name=i loop=$sites}
            <option value="{$sites[i].name}"{if $video.site eq $sites[i].name} selected="yes"{/if}>{$sites[i].name}</option>
            {/section}
            </select><br>
            <label for="title">Title: </label>
            <input name="title" type="text" value="{$video.title|escape:'html'}" class="large"><br>
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
			{if $embed == '1'}
			<label for="duration">Duration: </label>
			<input name="duration" type="text" class="small" value="{$video.duration}" /> Duration (minutes:seconds, eg: 17:24)<br />
			<label for="embed_code">Embed Code: </label>
			<textarea name="embed_code" rows="10">{$video.embed_code}</textarea>
			<label for="thumbs">Thumbs: </label>
			<div class="thumbs">
			{foreach from=$video.thumbs item=thumb}
			<input name="thumbs[]" type="hidden" value="{$thumb}" />
			<img src="{$thumb}" width="120" height="90" />
			{/foreach}
			</div>
			{else}                                                                  
            <label for="size">Size: </label>
            <input name="size" type="text" value="{$video.size}" readonly>
            <label for="url">Url: </label>
            <input name="url" type="text" value="{$video.url}" class="large">
			{/if}
        </fieldset>
        <div style="text-align: center;">
            <input name="save_video" type="submit" value="-- Save Video --" id="save_video_button" class="button" onClick="document.getElementById('save_video_button').value='-- Download... --'";>
        </div>
        {else}
        <fieldset>
        <legend>Grab Video</legend>
            <label for="site">Site: </label>
            <select name="site">
            {section name=i loop=$sites}
            <option value="{$sites[i].name}">{$sites[i].name}</option>
            {/section}
            </select><br>
            <label for="url">Url: </label>
            <input name="url" type="text" class="large"><br />
			<label for="embed"></label>
			<input name="embed" type="checkbox" value="1" /> Embed?
        </fieldset>
        <div style="text-align: center;">
            <input name="grab_video" type="submit" value="-- Grab Video --" class="button">
        </div>        
        {/if}
        </form>
        </div>
        </div>
        </div>
     </div>
