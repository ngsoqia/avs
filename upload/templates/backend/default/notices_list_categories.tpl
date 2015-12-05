     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_channels" method="POST" action="notices.php?m=list_categories">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right" width="10%">Name: </td>
                <td align="left" width="40%"><input name="category_name" type="text" value="" style="width: 300px;"></td>
                <td align="center" width="40%"><input type="submit" name="add_category" value=" -- Add Category -- " class="button"></td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Notices</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $categories}
            {section name=i loop=$categories}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$categories[i].category_id}</td>
                <td align="center">{$categories[i].name|escape:'html'}</td>
                <td align="center">{$categories[i].total_notices}</td>
                <td align="center">{if $categories[i].status == '1'}Active{else}Suspended{/if}</td>
                <td align="center">
                    <a href="notices.php?m=edit_category">Edit</a><br>
                    {if $categories[i].status == '1'}
                    <a href="notices.php?m=list_categories&a=suspend&CID={$categories[i].category_id}">Suspend</a><br>
                    {else}
                    <a href="notices.php?m=list_categories&a=activate&CID={$categories[i].category_id}">Activate</a><br>
                    {/if}
                    <a href="notices.php?m=list_categories&a=delete&CID={$categories[i].category_id}" onClick="javascript:return confirm('Are you sure you want to delete this category?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO NOTICE CATEGORIES FOUND!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>