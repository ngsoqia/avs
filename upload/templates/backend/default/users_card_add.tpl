     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_card_form" method="POST" enctype="multipart/form-data" action="users.php?m=card_add">
        <fieldset>
        <legend>点卡信息</legend>
            <label for="vip_level">VIP级别: </label>
            <select name="vip_level">
	            <option value="3" {if $card.vip_level == '3'} selected="selected"{/if}>3</option>
	            <option value="4" {if $card.vip_level == '4'} selected="selected"{/if}>4</option>
	            <option value="5" {if $card.vip_level == '5'} selected="selected"{/if}>5</option>
	            <option value="6" {if $card.vip_level == '6'} selected="selected"{/if}>6</option>
	            <option value="7" {if $card.vip_level == '7'} selected="selected"{/if}>7</option>
            </select><br>
            <label for="card_type">卡类型: </label>
            <select name="card_type">
	            <option value="1" {if $card.card_type == '1'} selected="selected"{/if}>月卡</option>
	            <option value="2" {if $card.card_type == '2'} selected="selected"{/if}>年卡</option>
            </select><br>
            <label for="money">每张点卡价格: </label>
            <input type="text" name="money" value=""><br>
            <label for="card_count">生成点卡数量: </label>
            <input type="text" name="card_count" value="{$card.card_count}"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_card" value="添加点卡" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>