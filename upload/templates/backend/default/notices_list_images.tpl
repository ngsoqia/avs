     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Images</b></td>
                <td align="center"><b>Addtime</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $images}
            {section name=i loop=$images}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" valign="top">{$images[i].image_id}</td>
                <td align="center" valign="top">
                    <a href="{$baseurl}/images/notice_images/{$images[i].image_id}.{$images[i].extension}" target="_blank"><img src="{$baseurl}/images/notice_images/thumbs/{$images[i].image_id}.jpg" alt=""></a>
                </td>
                <td align="center" valign="top">{$images[i].addtime|date_format}</td>
                <td align="center" valign="top">
                    <a href="notices.php?m=list_images&a=delete&CID={$images[i].image_id}" onClick="javascript:return confirm('Are you sure you want to delete this image?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO NOTICE IMAGES FOUND! CLICK <a href="notices.php?m=add_image">here</a> TO ADD IMAGE!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>