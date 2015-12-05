     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_channel" method="POST" enctype="multipart/form-data" action="channels.php?m=add">
        <fieldset>
        <legend>Add Video / Album Category</legend>
            <label for="name">Category Name: </label>
            <input type="text" name="name" value="{$channel.name}" class="large"><br>
            <label for="picture">Category Image: </label>
            <input name="picture" type="file"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_channel" value="Add Category" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>