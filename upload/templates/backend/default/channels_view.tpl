     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $channel}
        {insert name=channel_count assign=count CHID=$channel[0].CHID}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td valign="top" width="80%">
                <h2>Category Information</h2>
                <table width="100%" style="margin-left: 20px;" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Category ID</b></td>
                    <td>{$channel[0].CHID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Category Name</b></td>
                    <td><b>{$channel[0].name}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Total Videos</b></td>
                    <td>{$count}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="20%" valign="top" align="center">
                <h2>Image</h2>
				<img src="{$baseurl}/media/categories/video/{$channel[0].CHID}.jpg?{0|rand:100}"><br>
                <a href="channels.php?m=edit&CID={$channel[0].CHID}" class="view">Edit</a><br>
                <a href="channels.php?m=list&a=delete&CID={$channel[0].CHID}" onClick="javascript:return confirm('Are you sure you want to delete this channel?');" class="view">Delete</a><br>
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>