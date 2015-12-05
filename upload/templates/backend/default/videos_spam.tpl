     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $total_spam >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Comment</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Reporter</b></td>
                <td align="center"><b>Report Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $comments}
            {section name=i loop=$comments}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$comments[i].CID}</td>
                <td align="center" width="50%">
                    {$comments[i].comment|escape:'html'|nl2br}
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$comments[i].UID}">{$comments[i].username}</a>
                </td>
                <td align="center">
                    {insert name=uid_to_name assign=uname uid=$comments[i].RID}
                    <a href="users.php?m=view&UID={$comments[i].RID}">{$uname}</a>
                </td>
                <td align="center">{$comments[i].add_time|date_format}</td>
                <td align="center">
                    <a href="videos.php?m=commentedit&VID={$VID}&COMID={$comments[i].CID}">Edit</a><br>
                    <a href="videos.php?m=spam{if $page !=''}&page={$page}{/if}&a=delete&CID={$comments[i].CID}" onClick="javascript:return confirm('Are you sure you want to delete this comment?');">Delete</a><br>
                    <a href="videos.php?m=spam{if $page !=''}&page={$page}{/if}&a=unspam&SID={$comments[i].spam_id}" onClick="javascript:return confirm('Are you sure you want to unspam this comment?');">Unspam</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOU ARE LUCKY! THERE IS NO SPAM :-)</div></td>
            </tr>
            {/if}
            </table>
        </div>
        {if $total_spam >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>