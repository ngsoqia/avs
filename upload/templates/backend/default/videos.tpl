     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="videos.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td align="right">Description:</td><td><input type="text" name="description" value="{$option.description}"></td>
            </tr>
            <tr>
                <td align="right">Keyword:</td><td><input type="text" name="keyword" value="{$option.keyword}"></td>
                <td align="right">Channel:</td>
                <td>
                    <select name="channel">
                    <option value="">Select Channel</option>
                    {section name=i loop=$channels}
                    <option value="{$channels[i].CHID}"{if $channels[i].CHID == $option.channel } selected="selected"{/if}>{$channels[i].name}</option>
                    {/section}
                    </select>                                                                                            
                </td>
                <td align="right">Status:</td>
                <td>
                    <select name="active">
                    <option value="">---</option>
                    <option value="1"{if $option.active == '1'} selected="selected"{/if}>Active</option>
                    <option value="0"{if $option.active == '0'} selected="selected"{/if}>Suspended</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="v.VID"{if $option.sort == 'v.VID'} selected="selected"{/if}>VID</option>
                    <option value="v.title"{if $option.sort == 'v.title'} selected="selected"{/if}>Title</option>
                    <option value="v.type"{if $option.sort == 'v.type'} selected="selected"{/if}>Type</option>
                    <option value="v.duration"{if $option.sort == 'v.duration'} selected="selected"{/if}>Duration</option>
                    <option value="v.addate"{if $option.sort == 'v.addate'} selected="selected"{/if}>Date</option>
                    <option value="v.viewnumber"{if $option.sort == 'v.viewnumber'} selected="selected"{/if}>Views</option>
                    <option value="v.fav_num"{if $option.sort == 'v.fav_num'} selected="selected"{/if}>Favorites</option>
                    <option value="v.com_num"{if $option.sort == 'v.com_num'} selected="selected"{/if}>Comments</option>
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
                    <input type="submit" name="search_videos" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_videos >= 1}
        <form name="video_select" method="post" id="video_select" action="">
        <div id="actions">
            <input type="submit" name="delete_selected_videos" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected videos?');">
            <input type="submit" name="suspend_selected_videos" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected videos?');">
            <input type="submit" name="approve_selected_videos" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected videos?');">
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_videos" type="checkbox" id="video_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Active</b></td>
                <td align="center"><b>Type</b></td>
                <td align="center"><b>Duration</b></td>
                <td align="center"><b>Featured</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $videos}
            {section name=i loop=$videos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="video_id_checkbox_{$videos[i].VID}" id="video_checkbox_{$videos[i].VID}" type="checkbox"></td>
                <td align="center">{$videos[i].VID}</td>
                <td align="center"><br>
                    <a href="videos.php?m=view&VID={$videos[i].VID}">{$videos[i].title|escape:'html'}<br><br>
                    <img src="{insert name=tmb_path vid=$videos[i].VID}/{$videos[i].thumb}.jpg" width="200"></a><br><br>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$videos[i].UID}">{$videos[i].username}</a>
                </td>
                <td align="center">
                    <b>{if $videos[i].active == 1}yes{else}no{/if}</b><br>
                    Views: {$videos[i].viewnumber}<br>
                    Favorites: {$videos[i].fav_num}<br>
                    Comments: <a href="videos.php?m=comments&VID={$videos[i].VID}">{$videos[i].com_num}</a><br><br>
                    HD: {if $videos[i].hd==1}<font color=#009900>Yes</font>{else}<font color="#DB0000">No</font>{/if}<br>
                    Mobile: {if $videos[i].iphone==1}<font color=#009900>Yes</font>{else}<font color="#DB0000">No</font>{/if}<br>
                </td>
                <td align="center">{$videos[i].type}</td>
                <td align="center">{$videos[i].duration|string_format:"%.2f"}</td>
                <td align="center"><b>{$videos[i].featured}</b></td>
                <td align="center">{$videos[i].adddate|date_format}</td>
                <td align="center">
                    <a href="videos.php?m=view&VID={$videos[i].VID}">View</a><br>
                    <a href="videos.php?m=edit&VID={$videos[i].VID}">Edit</a><br>
                    <a href="videos.php?m={$module}{if $page !=''}&page={$page}{/if}&a=delete&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to delete this video?');">Delete</a><br>
                    {if $approve == '1'}
                    {if $videos[i].active == '1'}
                    <a href="videos.php?m={$module}{if $page !=''}&page={$page}{/if}&a=suspend&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to suspend this video?');">Suspend</a>
                    {else}
                    <a href="videos.php?m={$module}{if $page !=''}&page={$page}{/if}&a=activate&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to approve this video?');">Activate</a>
                    {/if}
                    <br>
                    {/if}
                    {if $videos[i].embed_code == ''}
                    <a href="videos.php?m={$module}{if $page !=''}&page={$page}{/if}&a=regenthumbs&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to regenerate thumbs for this video?');">Thumbs</a><br />
                    <a href="videos.php?m={$module}{if $page !=''}&page={$page}{/if}&a=duration&VID={$videos[i].VID}" onClick="javascript:return confirm('Are you sure you want to regenerate duration for this video?');">Duration</a>
                    {/if}
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
        {if $total_videos >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>
