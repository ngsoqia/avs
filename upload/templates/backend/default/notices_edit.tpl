     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Creating New Notice Entry</h2>
        <div id="simpleForm">
        <form name="email_user" method="POST" action="notices.php?m=edit&NID={$notice.NID}">
        <fieldset>
        <legend>Notice Information</legend>
            <label for="username" style="width: 20%;">Username: </label>
            <input name="username" type="text" value="{$notice.username}"><br>
            <label for="category" style="width: 20%;">Category: </label>
            <select name="category">
            <option value="">Select Category</option>
            {section name=i loop=$categories}
            <option value="{$categories[i].category_id}"{if $categories[i].category_id == $notice.category} selected="yes"{/if}>{$categories[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="subject" style="width: 20%;">Title: </label>
            <input name="title" type="text" value="{$notice.title}" class="large"><br>
        </fieldset>
        {$editor_wysiswyg}
		<br/>
        <div style="text-align: center;">
            <input type="submit" name="submit_edit_notice" value="Update Notice" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>