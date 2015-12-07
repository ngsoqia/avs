     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_cards" method="POST" action="users.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">VIP等级:</td>
                <td>
                    <select name="vip_level">
                    <option value="" {if $option.vip_level == ''} selected="selected"{/if}>------</option>
                    <option value="3" {if $option.vip_level == '3'} selected="selected"{/if}>3级</option>
                    <option value="4" {if $option.vip_level == '4'} selected="selected"{/if}>4级</option>
                    <option value="5" {if $option.vip_level == '5'} selected="selected"{/if}>5级</option>
                    <option value="6" {if $option.vip_level == '6'} selected="selected"{/if}>6级</option>
                    <option value="7" {if $option.vip_level == '7'} selected="selected"{/if}>7级</option>
                    </select>
                </td>
                <td align="right">使用状态:</td>
                <td>
                    <select name="used">
                    <option value="" {if $option.used == ''} selected="selected"{/if}>------</option>
                    <option value="0" {if $option.used == '0'} selected="selected"{/if}>未使用</option>
                    <option value="1" {if $option.used == '1'} selected="selected"{/if}>已使用</option>
                    </select>
                </td>
                <td align="right">使用者ID:</td>
                <td>
                    <input type="text" name="user_id" value="{if $option.user_id}{$option.user_id}{/if}"><br>
                </td>
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_cards" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_cards >= 1}
	        <form name="card_select" method="post" id="card_select" action="">
	        <div id="actions">
	            <input type="submit" name="delete_selected_cards" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected cards?');">
	        </div>
	        <div id="paging">
	            <div class="pagingnav">{$paging}</div>
	        </div>
	        <div class="pagingnav_clear"></div>
        {/if}                                      
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_cards" type="checkbox" id="card_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>卡号</b></td>
                <td align="center"><b>密码</b></td>
                <td align="center"><b>vip等级</b></td>
                <td align="center"><b>价格</b></td>
                <td align="center"><b>卡类型</b></td>
                <td align="center"><b>使用情况</b></td>
                <td align="center"><b>使用者ID</b></td>
                <td align="center"><b>生成时间</b></td>
                <td align="center"><b>使用时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $cards}
            {section name=i loop=$cards}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="card_id_checkbox_{$cards[i].id}" id="card_checkbox_{$cards[i].id}" type="checkbox"></td>
                <td align="center">{$cards[i].id}</td>
                <td align="center">{$cards[i].number}</td>
                <td align="center">{$cards[i].pass}</td>
                <td align="center">{$cards[i].vip_level}级</td>
                <td align="center">{$cards[i].money}</td>
                <td align="center">
                	{if $cards[i].card_type == '1'}
                		月卡
                	{elseif $cards[i].card_type == '2'}
                		年卡
                	{else}
                		无效卡类型
                	{/if}
                </td>
                <td align="center">
                	{if $cards[i].used == '0'}
                		未使用
                	{elseif $cards[i].used == '1'}
                		已使用
                	{else}
                		使用状态错误
                	{/if}
                </td>
                <td align="center">
                	{if $cards[i].user_id}
                		{$cards[i].user_id}
                	{/if}
                </td>
                <td align="center">
                	{$cards[i].addtime|date_format:'%Y-%m-%d %H:%M:%S'}
                </td>
                <td align="center">
                	{$cards[i].usetime|date_format:'%Y-%m-%d %H:%M:%S'}
                </td>
                <td align="center">
                    <a href="users.php?m={$module}{if $page !=''}&page={$page}{/if}&a=delete&id={$cards[i].id}" onClick="javascript:return confirm('Are you sure you want to delete this card?');">Delete</a><br>
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
        {if $total_cards >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>