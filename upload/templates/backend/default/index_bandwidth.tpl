     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Bandwidth Management</h2>
        <div id="simpleForm">
        <form name="bandwidth_settings" method="POST" action="index.php?m=bandwidth">
        <fieldset>
        <legend>Guest Settings</legend>
            <label for="guest_limit">Guest Limit: </label>
            <select name="guest_limit">
            <option value="0"{if $guest_limit == '0'} selected="selected"{/if}>No</option>
            <option value="1"{if $guest_limit == '1'} selected="selected"{/if}>Yes</option>            
            </select><br>
            <label for="guest_bandwidth">Guest Bandwidth: </label>
            <input name="guest_bandwidth" type="text" value="{$guest_bandwidth}" class="small">&nbsp;MB<br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_bandwidth" value="Update" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>