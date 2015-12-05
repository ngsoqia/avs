     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $notice}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="70%">
                <h2>Notice Information</h2>
                <table style="margin-left: 20px;" width="100%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td>{$notice[0].content}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="30%" valign="top" align="center">
                <br /><br /><br /><br /><br />
                <a href="notices.php?m=edit&NID={$notice[0].NID}" class="view">Edit</a><br>
                <a href="notices.php?m=list&a=delete&NID={$notice[0].NID}" class="view" onClick="javascript:return confirm('Are you sure you want to delete this notice?');">Delete</a><br>
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>