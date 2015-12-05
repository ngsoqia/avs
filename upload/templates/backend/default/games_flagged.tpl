     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_games" method="POST" action="games.php?m=flagged">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Flagger:</td><td><input type="text" name="flagger" value="{$option.flagger}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="g.GID"{if $option.sort == 'g.GID'} selected="selected"{/if}>GID</option>
                    <option value="g.title"{if $option.sort == 'g.title'} selected="selected"{/if}>Title</option>
                    <option value="g.type"{if $option.sort == 'g.type'} selected="selected"{/if}>Type</option>
                    <option value="g.addate"{if $option.sort == 'g.addate'} selected="selected"{/if}>Date</option>
                    <option value="g.total_plays"{if $option.sort == 'g.total_plays'} selected="selected"{/if}>Views</option>
                    <option value="g.total_favorites"{if $option.sort == 'g.total_favorites'} selected="selected"{/if}>Favorites</option>
                    <option value="g.total_comments"{if $option.sort == 'g.total_comments'} selected="selected"{/if}>Comments</option>
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
                    <input type="submit" name="search_games" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $games_total >= 1}
        <form name="game_select" method="post" id="game_select" action="">
        <div id="actions">
            <input type="submit" name="unflag_selected_games" value="Unflag" class="action_button" onClick="javascript:return confirm('Are you sure you want to unflag all selected games?');">
            <input type="submit" name="suspend_selected_games" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected games?');">
            <input type="submit" name="approve_selected_games" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected games?');">
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_games" type="checkbox" id="game_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Flagger</b></td>
                <td align="center"><b>Reason</b></td>
                <td align="center"><b>Type</b></td>
                <td align="center"><b>Flag Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $games}
            {section name=i loop=$games}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="game_id_checkbox_{$games[i].GID}" id="game_checkbox_{$games[i].GID}" type="checkbox"></td>
                <td align="center">{$games[i].GID}</td>
                <td align="center">
                    <a href="games.php?m=view&GID={$games[i].GID}">{$games[i].title|escape:'html'}<br><br>
                    <img src="{$baseurl}/media/games/tmb/{$games[i].GID}.jpg"></a>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$games[i].UID}">{$games[i].username}</a>
                </td>
                <td align="center">
                    {insert name=uid_to_name assign=uname uid=$games[i].SUID}
                    <a href="users.php?m=view&UID={$games[i].SUID}">{$uname}</a>
                </td>
                <td align="center">
                    <b>{$games[i].reason}</b><br />
                    {if $games[i].message}<br />{$games[i].message|escape:'html'|nl2br}{/if}
                </td>
                <td align="center">{$games[i].type}</td>
                <td align="center">{$games[i].add_date|date_format}</td>
                <td align="center">
                    <a href="games.php?m=view&GID={$games[i].GID}">View</a><br>
                    <a href="games.php?m=edit&GID={$games[i].GID}">Edit</a><br>
                    {if $games[i].status == '1'}
                    <a href="games.php?m=flagged{if $page !=''}&page={$page}{/if}&a=suspend&GID={$games[i].GID}" onClick="javascript:return confirm('Are you sure you want to suspend this game?');">Suspend</a>
                    {else}
                    <a href="games.php?m=flagged{if $page !=''}&page={$page}{/if}&a=activate&GID={$games[i].GID}" onClick="javascript:return confirm('Are you sure you want to approve this game?');">Activate</a>
                    {/if}
                    <br>
                    <a href="games.php?m=flagged{if $page !=''}&page={$page}{/if}&a=unflag&FID={$games[i].FID}" onClick="javascript:return confirm('Are you sure you want to unflag this game?');">Unflag</a>
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
        </form>
        {if $videos_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>