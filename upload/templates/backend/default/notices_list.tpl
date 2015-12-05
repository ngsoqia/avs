     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_notices" method="POST" action="notices.php?m=list">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td align="right">Content:</td><td><input type="text" name="content" value="{$option.content}"></td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="NID"{if $option.sort == 'NID'} selected="selected"{/if}>NID</option>
                    <option value="UID"{if $option.sort == 'UID'} selected="selected"{/if}>UID</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>Title</option>
                    <option value="total_comments"{if $option.sort == 'total_comments'} selected="selected"{/if}>Comments</option>
                    <option value="total_views"{if $option.sort == 'total_views'} selected="selected"{/if}>Views</option>
                    <option value="addtime"{if $option.sort == 'addtime'} selected="selected"{/if}>Date</option>
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
                    <input type="submit" name="search_notices" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $notices_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>Username</b></td>
                <td align="center"><b>Info</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $notices}
            {section name=i loop=$notices}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$notices[i].NID}</td>
                <td align="center">{$notices[i].title}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$notices[i].UID}">{$notices[i].username}</a>
                </td>
                <td align="center">
                    Comments: {$notices[i].total_comments}<br>
                    View: {$notices[i].total_views}<br>
                </td>
                <td align="center">
                    {$notices[i].addtime|date_format}<br>
                </td>
                <td align="center"><b>{if $notices[i].status == '1'}Active{else}Suspended{/if}</b></td>
                <td align="center">
                    <a href="notices.php?m=view&NID={$notices[i].NID}">View</a><br>
                    <a href="notices.php?m=edit&NID={$notices[i].NID}">Edit</a><br>
                    {if $notices[i].status == '1'}
                    <a href="notices.php?m=list{if $page !=''}&page={$page}{/if}&a=suspend&NID={$notices[i].NID}" onClick="javascript:return confirm('Are you sure you want to suspend this notice?');">Suspend</a>
                    {else}
                    <a href="notices.php?m=list{if $page !=''}&page={$page}{/if}&a=activate&NID={$notices[i].NID}" onClick="javascript:return confirm('Are you sure you want to activate this notice?');">Activate</a>
                    {/if}
                    <br>
                    <a href="notices.php?m=list{if $page !=''}&page={$page}{/if}&a=delete&NID={$notices[i].NID}" onClick="javascript:return confirm('Are you sure you want to delete this notice?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
        </div>
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>