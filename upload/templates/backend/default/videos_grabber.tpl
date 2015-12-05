     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="configureGrabber" method="POST" action="videos.php?m=grabber">
        <fieldset>
        <legend>Configure Grabbers</legend>
        <table width="100%" cellspacing="1" cellpadding="3" border="0">
        <tr>
            <td align="center"><b>Site</b></td>
            <td align="center"><b>Interval</b></td>
            <td align="center"><b>Items</b></td>
        </tr>
        {section name=i loop=$grabbers}
        <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
            <td align="center"><b>{$grabbers[i].grab_id}</b></td>
            <td align="center">
            <select name="interval_{$grabbers[i].grab_id}">
                <option value=""{if $grabbers[i].grab_interval == '0'} selected="selected"{/if}>disabled</option>
                <option value="hourly"{if $grabbers[i].grab_interval == 'hourly'} selected="selected"{/if}>hourly</option>
                <option value="daily"{if $grabbers[i].grab_interval == 'daily'} selected="selected"{/if}>daily</option>
            </select>
            </td>
            <td align="center">
                <input name="items_{$grabbers[i].grab_id}" type="text" value="{$grabbers[i].grab_number}" class="medium">
            </td>
        </tr>
        {/section}
        </table>
        </fieldset>
        <div style="text-align: center;">
            <input name="update_grabbers" type="submit" value="-- Update Grabbers --" class="button">
        </div>        
        </form>
        </div>
        </div>
        </div>
     </div>