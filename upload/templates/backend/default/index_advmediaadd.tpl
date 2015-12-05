     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" enctype="multipart/form-data" action="index.php?m=advmediaadd">
        <fieldset>
        <legend>Add In-Player Pre/Post Roll Media Ad</legend>
            <label for="name">Name: </label>
            <input name="adv_title" type="text" value="{$adv.title}" class="large"><br />
            <label for="desc">Description: </label>
            <input name="adv_desc" type="text" value="{$adv.desc}" class="large"><br />
            <label for="url">Url: </label>
            <input name="adv_url" type="text" value="{$adv.url}" class="large"><br />
            <label for="duration">Skip after (for video ads) / Duration (for image/flash ads): </label>
            <input name="adv_duration" type="text" value="{$adv.duration}" class="small"><small>(seconds)</small><br />
            {if $adv.video != '0'}
            <label for="video">Video: </label>
            <input name="adv_video" type="hidden" value="{$adv.video}">
            <input name="adv_video_title" type="text" value="{$adv.video_title|escape:'html'}" class="large"><br />
            {/if}
            {if $adv.channel != '0'}
            <label for="channel">Channel: </label>
            <select name="adv_channel">
            <option value="0">Select Channel</option>
            {section name=i loop=$channels}
            <option value="{$channels[i].CHID}"{if $channels[i].CHID == $adv.channel} selected="selected"{/if}>{$channels[i].name|escape:'html'}</option>
            {/section}
            </select><br />
            {/if}
            <label for="media">File: </label>
            <input name="adv_media" type="file"><small>(*.jpg, *.swf, *.flv, *.mp4)</small><br />
            <label for="status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $adv.status == '0'} selected="selected"{/if}>Inactive</optio>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_add" value="Add Media Ad" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
