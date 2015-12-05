     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_channels" method="POST" action="channels.php">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="category_id"{if $option.sort == 'category_id'} selected="selected"{/if}>ID</option>
                    <option value="category_name"{if $option.sort == 'category_name'} selected="selected"{/if}>Name</option>
                    </select>
                </td>
                <td align="right">Order</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td colspan="2" align="center">
                    <input type="submit" name="search_channels" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Games</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $channels}
            {section name=i loop=$channels}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$channels[i].category_id}</td>
                <td align="center">
                    <a href="channels.php?m=view&CID={$channels[i].category_id}">{$channels[i].category_name}<br><br>
                    <img src="{$baseurl}/media/categories/game/{$channels[i].category_id}.jpg" width="200"></a>
                    </td>
                    
                <td align="center">{if $channels[i].total_games == '0'}0{else}<a href="games.php?m=all&CID={$channels[i].category_id}">{$channels[i].total_games}</a>{/if}</td>
                <td align="center">
                    <a href="channels.php?m=editgame&CID={$channels[i].category_id}">Edit</a><br>
                    <a href="channels.php?m=listgame&a=delete&CID={$channels[i].category_id}" onClick="javascript:return confirm('Are you sure you want to delete this channel?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO CATEGORIES FOUND. CLICK <a href="channels.php?m=addgame">HERE</a> TO ADD GAME CATEGORIES!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>