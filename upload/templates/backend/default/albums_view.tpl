     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $album}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td width="70%" valign="top">
                <h2>Album Information</h2>
                <table style="margin-left: 20px;" width="90%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Album ID</b></td>
                    <td>{$album.AID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Status</b></td>
                    <td><b>{if $album.status == 1}active{else}suspended{/if}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Name</b></td>
                    <td>{$album.name|escape:'html'}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Tags</b></td>
                    <td>{$album.tags}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Category</b></td>
                    <td><a href="channels.php?m=view&CID={$album.CHID}">{$album.name}</a></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Type</b></td>
                    <td>{$album.type}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Date Added</b></td>
                    <td>{$album.adddate|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Rate</b></td>
                    <td>{$album.rate}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Views</b></td>
                    <td>{$album.total_views}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Photos</b></td>
                    <td>{$album.total_photos}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Comments</b></td>
                    <td>{$album.total_comments}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Favorites</b></td>
                    <td>{$album.total_favorites}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="30%" valign="top" align="center">
                <h2>Album Cover</h2>
                <img src="{$baseurl}/media/albums/{$album.AID}.jpg"><br>
                <a href="albums.php?m=edit&AID={$album.AID}" class="view">Edit</a><br>
                <a href="albums.php?m=all&a=delete&AID={$album.AID}" class="view" onClick="javascript:return confirm('Are you sure you want to delete this album?');">Delete</a><br>
                {if $album.status == 0}
                <a href="albums.php?m=view&a=approve&AID={$album.AID}" onClick="javascript:return confirm('Are you sure you want to activate this album?');" class="view">Approve</a>
                {else}
                <a href="albums.php?m=view&a=suspend&AID={$album.AID}" onClick="javascript:return confirm('Are you sure you want to suspend this album?');" class="view">Suspend</a>
                {/if}
                <br />
                <a href="albums.php?m=addphoto&AID={$album.AID}">Add Photos</a><br />
            </td>
        </tr>
        </table>
        </div>
        <br>
        <div id="right">
        <table width="100%" cellspacing="1" cellpadding="3" border="0">
        <tr>
            <td align="center"><b>Id</b></td>
            <td align="center"><b>Name</b></td>
            <td align="center"><b>User</b></td>
            <td align="center"><b>Status</b></td>
            <td align="center"><b>Actions</b></td>
        </tr>
            {if $photos}
            {section name=i loop=$photos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$photos[i].PID}</td>
                <td align="center">
                    <a href="albums.php?m=viewphoto&AID={$album.AID}&PID={$photos[i].PID}">{$photos[i].caption|escape:'html'}<br><br>
                    <img src="{$baseurl}/media/photos/tmb/{$photos[i].PID}.jpg"></a>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$album.UID}">{$album.username}</a>
                </td>
                <td align="center">
                    <b>{if $photos[i].status == 1}Active{else}Suspended{/if}</b><br>
                    Views: {$photos[i].total_views}<br>
                    Comments: {if $photos[i].total_comments > 0}<a href="albums.php?m=comments&PID={$photos[i].PID}">{$photos[i].total_comments}</a>{else}{$photos[i].total_comments}{/if}<br>
                    Favorites: {$photos[i].total_favorites}<br>
                </td>
                <td align="center">
                    <a href="albums.php?m=viewphoto&AID={$album.AID}&PID={$photos[i].PID}">View</a><br>
                    <a href="albums.php?m=editphoto&AID={$album.AID}&PID={$photos[i].PID}">Edit</a><br>
                    <a href="albums.php?m=view&a=delete&AID={$album.AID}&PID={$photos[i].PID}" onClick="javascript:return confirm('Are you sure you want to delete this photo?');">Delete</a><br>
                    {if $photos[i].status == '1'}
                    <a href="albums.php?m=view&a=suspend&AID={$album.AID}&PID={$photos[i].PID}" onClick="javascript:return confirm('Are you sure you want to suspend this photo?');">Suspend</a>
                    {else}
                    <a href="albums.php?m=view&a=activate&AID={$album.AID}&PID={$photos[i].PID}" onClick="javascript:return confirm('Are you sure you want to activate this photo?');">Activate</a>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">THIS ALBUM CONTAINS NO PHOTOS</div></td>
            </tr>
            {/if}
        </table>        
        </div>
        {/if}
     </div> 
