     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" action="index.php?m=advtextadd">
        <fieldset>
        <legend>Add In-Player Text Ad</legend>
            <label for="name">Title: </label>
            <input name="adv_title" type="text" value="{$adv.title}" class="large"><br />
            <label for="desc">Description: </label>
            <input name="adv_desc" type="text" value="{$adv.desc}" class="large"><br />
            <label for="url">URL: </label>
            <input name="adv_url" type="text" value="{$adv.url}" class="large"><br />
            <label for="status">Status: </label>
            <select name="adv_status">
            <option value="1"{if $adv.status == '1'} selected="selected"{/if}>Active</option>
            <option value="0"{if $adv.status == '0'} selected="selected"{/if}>Inactive</optio>
            </select>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_add" value="Add Text Ad" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
