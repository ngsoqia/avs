     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="albums.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Name:</td><td><input type="text" name="name" value="{$option.name}"></td>
                <td align="right">Tags:</td><td><input type="text" name="tags" value="{$option.tags}"></td>
            </tr>
            <tr>
                <td align="right">Category:</td>
                <td>
                    <select name="category">
                    <option value="">Select Category</option>
                    {section name=i loop=$categories}
                    <option value="{$categories[i].CHID}"{if $categories[i].CHID == $option.category } selected="selected"{/if}>{$categories[i].name}</option>
                    {/section}
                    </select>                                                                                            
                </td>
                <td align="right">Status:</td>
                <td>
                    <select name="status">
                    <option value="">---</option>
                    <option value="1"{if $option.status == '1'} selected="selected"{/if}>Active</option>
                    <option value="0"{if $option.status == '0'} selected="selected"{/if}>Suspended</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="a.AID"{if $option.sort == 'a.AID'} selected="selected"{/if}>AID</option>
                    <option value="a.name"{if $option.sort == 'a.name'} selected="selected"{/if}>Name</option>
                    <option value="a.type"{if $option.sort == 'a.type'} selected="selected"{/if}>Type</option>
                    <option value="a.total_photos"{if $option.sort == 'a.total_photos'} selected="selected"{/if}>Photos</option>
                    <option value="a.total_views"{if $option.sort == 'a.total_views'} selected="selected"{/if}>Views</option>
                    <option value="a.total_comments"{if $option.sort == 'a.total_comments'} selected="selected"{/if}>Comments</option>
                    <option value="a.total_favorites"{if $option.sort == 'a.total_favorites'} selected="selected"{/if}>Favorites</option>
                    <option value="a.adddate"{if $option.sort == 'a.adddate'} selected="selected"{/if}>Date</option>
                    </select>
                </td>
                <td align="right">Order</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td align="right">Display</td>
                <td>
                    <select name="display">
                    <option value="10"{if $option.display == '10'} selected="selected"{/if}>10</option>
                    <option value="20"{if $option.display == '20'} selected="selected"{/if}>20</option>
                    <option value="30"{if $option.display == '30'} selected="selected"{/if}>30</option>
                    <option value="40"{if $option.display == '40'} selected="selected"{/if}>40</option>
                    <option value="50"{if $option.display == '50'} selected="selected"{/if}>50</option>
                    <option value="100"{if $option.display == '100'} selected="selected"{/if}>100</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_albums" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_albums >= 1}
        <form name="album_select" method="post" id="album_select" action="">
        <div id="actions">
            <input type="submit" name="delete_selected_albums" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected albums?');">
            <input type="submit" name="suspend_selected_albums" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected albums?');">
            <input type="submit" name="approve_selected_albums" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected albums?');">
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_albums" type="checkbox" id="album_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Type</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $albums}
            {section name=i loop=$albums}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="album_id_checkbox_{$albums[i].AID}" id="album_checkbox_{$albums[i].AID}" type="checkbox"></td>
                <td align="center">{$albums[i].AID}</td>
                <td align="center">
                    <a href="albums.php?m=view&AID={$albums[i].AID}">{$albums[i].name|escape:'html'}<br><br>
                    <img src="{$baseurl}/media/albums/{$albums[i].AID}.jpg?{0|rand:100}" width="200" height="200"></a>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$albums[i].UID}">{$albums[i].username}</a>
                </td>
                <td align="center">
                    <b>{if $albums[i].status == 1}Active{else}Suspended{/if}</b><br>
                    Photos: {$albums[i].total_photos}<br>
                    Views: {$albums[i].total_views}<br>
                    Comments: {$albums[i].total_comments}<br>
                    Favorites: {$albums[i].total_favorites}<br>
                </td>
                <td align="center">{$albums[i].type}</td>
                <td align="center">{$albums[i].adddate|date_format}</td>
                <td align="center">
                    <a href="albums.php?m=view&AID={$albums[i].AID}">View</a><br>
                    <a href="albums.php?m=edit&AID={$albums[i].AID}">Edit</a><br>
                    <a href="albums.php?m={$module}{if $page !=''}&page={$page}{/if}&a=delete&AID={$albums[i].AID}" onClick="javascript:return confirm('Are you sure you want to delete this album?');">Delete</a><br>
                    {if $albums[i].status == '1'}
                    <a href="albums.php?m={$module}{if $page !=''}&page={$page}{/if}&a=suspend&AID={$albums[i].AID}" onClick="javascript:return confirm('Are you sure you want to suspend this album?');">Suspend</a>
                    {else}
                    <a href="albums.php?m={$module}{if $page !=''}&page={$page}{/if}&a=activate&AID={$albums[i].AID}" onClick="javascript:return confirm('Are you sure you want to approve this album?');">Activate</a>
                    {/if}
                    <br />
                    <a href="albums.php?m=addphoto&AID={$albums[i].AID}">Add Photos</a>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
            </form>
        </div>
        {if $total_albums >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>