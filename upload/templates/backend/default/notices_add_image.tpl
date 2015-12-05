     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Add Notice Images</h2>
        <div id="simpleForm">
        <form name="add_notice_images" id="add_notice_images" method="POST" enctype="multipart/form-data" action="notices.php?m=add_image">
        <fieldset>
        <legend>Add Image(s)</legend>
            <label for="image_1" style="width: 20%;">File: </label>
            <input name="image_1" type="file" id="image_1"><div id="error_image_1" class="error" style="display: none"></div>
            <div id="add_image_container" style="display: none;"></div>
        </fieldset>
        <a href="#add_more_images" id="add_new_image" class="add_more_images">Add More</a>
        <br>
        <div style="text-align: center;">
            <input type="submit" name="submit_add_image" value="Add Images" id="submit_add" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>