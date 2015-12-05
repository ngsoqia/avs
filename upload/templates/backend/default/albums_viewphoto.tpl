     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $photo}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="70%" valign="top">
                <h2>Photo Information</h2>
                <table style="margin-left: 20px;" width="90%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Photo ID</b></td>
                    <td>{$photo.PID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Status</b></td>
                    <td><b>{if $photo.status == 1}active{else}suspended{/if}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Caption</b></td>
                    <td>{$photo.caption|escape:'html'}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Rate</b></td>
                    <td>{$photo.rate}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Views</b></td>
                    <td>{$photo.total_views}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Comments</b></td>
                    <td>{$photo.total_comments}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Favorites</b></td>
                    <td>{$photo.total_favorites}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="30%" valign="top" align="center">
                <h2>Photo Thumb</h2>
                <img src="{$relative}/media/photos/tmb/{$photo.PID}.jpg" /><br />
                <a href="albums.php?m=editphoto&AID={$photo.AID}&PID={$photo.PID}" class="view">Edit</a><br>
                <a href="albums.php?m=viewphoto&a=delete&AID={$photo.AID}&PID={$photo.PID}" class="view" onClick="javascript:return confirm('Are you sure you want to delete this photo?');">Delete</a><br>
                {if $photo.status == 0}
                <a href="albums.php?m=viewphoto&a=approve&AID={$photo.AID}&PID={$photo.PID}" onClick="javascript:return confirm('Are you sure you want to activate this photo?');" class="view">Approve</a><br>
                {else}
                <a href="albums.php?m=viewphoto&a=suspend&AID={$photo.AID}&PID={$photo.PID}" onClick="javascript:return confirm('Are you sure you want to suspend this photo?');" class="view">Suspend</a><br>
                {/if}
            </td>
        </tr>
        </table>
        </div>
        <br>
        <div id="right">
        <table width="100%" cellspacing="1" cellpadding="3" border="0">
        <tr>
            <td align="center"><img src="{$relative}/media/photos/{$photo.PID}.jpg" alt="{$photo.caption|escape:'html'}" title="{$photo.caption|escape:'html'}"></td>
        </tr>
        </table>        
        </div>
        {/if}
     </div> 
