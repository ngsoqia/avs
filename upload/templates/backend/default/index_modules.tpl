     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Module Configuration</h2>
        <div id="simpleForm">
        <form name="mail_settings" method="POST" action="index.php?m=modules">
        <fieldset>
        <legend>Module Settings</legend>
            <label for="video_module" style="width: 40%;">Video Module: </label>
            <select name="video_module">
            <option value="1"{if $video_module == '1'} selected="selected"{/if}>Enabled</option>
            <option value="0"{if $video_module == '0'} selected="selected"{/if}>Disabled</option>
            </select><br>
            <label for="photo_module" style="width: 40%;">Photo Module: </label>
            <select name="photo_module">
            <option value="1"{if $photo_module == '1'} selected="selected"{/if}>Enabled</option>
            <option value="0"{if $photo_module == '0'} selected="selected"{/if}>Disable</option>
            </select><br>
            <label for="game_module" style="width: 40%;">Game Module: </label>
            <select name="game_module">
            <option value="1"{if $game_module == '1'} selected="selected"{/if}>Enable</option>
            <option value="0"{if $game_module == '0'} selected="selected"{/if}>Disable</option>
            </select><br>
            <label for="blog_module" style="width: 40%;">Blog Module: </label>
            <select name="blog_module">
            <option value="1"{if $blog_module == '1'} selected="selected"{/if}>Enable</option>
            <option value="0"{if $blog_module == '0'} selected="selected"{/if}>Disable</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_modules" value="Update Module Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>