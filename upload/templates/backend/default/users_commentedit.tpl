     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_comment" method="POST" action="users.php?m=commentedit&WID={$WID}">
        <fieldset>
        <legend>Comment Text</legend>
            <textarea name="comment" rows="10" class="adv">{$comment}</textarea><br>    
        </fieldset>
        <div align="center">
            <input type="submit" name="edit_comment" value="Update Comment" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>