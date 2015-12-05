     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $blog}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td>
                <h2>Blog Information</h2>
                <table style="margin-left: 20px;" width="90%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Blog ID</b></td>
                    <td>{$blog.BID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>User</b></td>
                    <td><b><a href="users.php?m=view&UID={$blog.UID}">{$blog.username}</a></b></td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Active</b></td>
                    <td><b>{if $blog.status == '1'}active{else}suspended{/if}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Title</b></td>
                    <td>{$blog.title|escape:'html'}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Content</b></td>
                    <td style="border: 1px solid #ccc;">{$blog.content}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Views</b></td>
                    <td>{$blog.total_views}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Comments</b></td>
                    <td>{if $blog.total_comments == '0'}{$blog.total_comments}{else}<a href="blogs.php?m=comments&BID={$blog.BID}">{$blog.total_comments}</a>{/if}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Links</b></td>
                    <td>{$blog.total_links}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Added</b></td>
                    <td>{$blog.addtime|date_format}</td>
                </tr>
                </table>
                <br>
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>