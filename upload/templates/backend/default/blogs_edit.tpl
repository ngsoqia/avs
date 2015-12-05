     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_blog" method="POST" action="blogs.php?m=edit&BID={$blog.BID}">
        <fieldset>
        <legend>Blog Information</legend>
            <label for="BID">Blog ID: </label>
            <input type="text" name="BID" value="{$blog.BID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$blog.username}" readonly="readonly" class="large"><br>
            <label for="title">Title: </label>
            <input type="text" name="title" value="{$blog.title|escape:'html'}" class="large"><br>
        </fieldset>
        <fieldset>
        <legend>Blog Content</legend>
            <label for="content">Content: </label>
            <textarea name="content" id="content" cols="30" rows="20">{$blog.content}</textarea><br />
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="total_views">Views: </label>
            <input type="text" name="total_views" value="{$blog.total_views}"><br>
            <label for="total_comments">Comments: </label>
            <input type="text" name="total_comments" value="{$blog.total_comments}"><br>
            <label for="total_links">Links: </label>
            <input type="text" name="total_links" value="{$blog.total_links}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="submit_blog_edit" value="Update Blog" class="button">
            <input type="button" name="edit_blog_advanced" id="edit_video_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>