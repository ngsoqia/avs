     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_blogs" method="POST" action="blogs.php?m=all">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Title:</td><td><input type="text" name="title" value="{$option.title}"></td>
                <td align="right">Content:</td><td><input type="text" name="content" value="{$option.content}"></td>
            </tr>
            <tr>
                <td align="right">Category:</td>
                <td>
                    <select name="category">
                    <option value="">Select Category</option>
                    {section name=i loop=$categories}
                    <option value="{$categories[i].CHID}"{if $categories[i].CHID == $option.category } selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
                    {/section}
                    </select>                                                                                            
                </td>
                <td align="right">Status:</td>
                <td>
                    <select name="status">
                    <option value="">---</option>
                    <option value="1"{if $option.status == '1'} selected="selected"{/if}>Active</option>
                    <option value="0"{if $option.status == '0'} selected="selected"{/if}>Suspended</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="b.BID"{if $option.sort == 'b.BID'} selected="selected"{/if}>BID</option>
                    <option value="b.title"{if $option.sort == 'b.title'} selected="selected"{/if}>Title</option>
                    <option value="b.content"{if $option.sort == 'b.content'} selected="selected"{/if}>Content</option>
                    <option value="b.addtime"{if $option.sort == 'b.addtime'} selected="selected"{/if}>Date</option>
                    <option value="b.total_views"{if $option.sort == 'b.total_views'} selected="selected"{/if}>Views</option>
                    <option value="b.total_comments"{if $option.sort == 'b.total_comments'} selected="selected"{/if}>Comments</option>
                    <option value="b.total_links"{if $option.sort == 'b.total_links'} selected="selected"{/if}>Links</option>
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
                    <input type="submit" name="search_blogs" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_blogs >= 1}
        <form name="blog_select" method="post" id="blog_select" action="">
        <div id="actions">
            <input type="submit" name="delete_selected_blogs" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected blogs?');">
            <input type="submit" name="suspend_selected_blogs" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected blogs?');">
            <input type="submit" name="approve_selected_blogs" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected blogs?');">
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><input name="check_all_blogs" type="checkbox" id="blog_check_all"></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Title</b></td>
                <td align="center"><b>User</b></td>
                <td align="center"><b>Active</b></td>
                <td align="center"><b>Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $blogs}
            {section name=i loop=$blogs}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="blog_id_checkbox_{$blogs[i].BID}" id="blog_checkbox_{$blogs[i].BID}" type="checkbox"></td>
                <td align="center">{$blogs[i].BID}</td>
                <td align="center">
                    <a href="blogs.php?m=view&BID={$blogs[i].BID}">{$blogs[i].title|escape:'html'}</a>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$blogs[i].UID}">{$blogs[i].username}</a>
                </td>
                <td align="center">
                    <b>{if $blogs[i].status == '1'}active{else}suspended{/if}</b><br>
                    Views: {$blogs[i].total_views}<br>
                    Comments: {if $blogs[i].total_comments == '0'}0{else}<a href="blogs.php?m=comments&BID={$blogs[i].BID}">{$blogs[i].total_comments}</a>{/if}<br>
                    Links: {$blogs[i].total_links}<br>
                </td>
                <td align="center">{$blogs[i].addtime|date_format}</td>
                <td align="center">
                    <a href="blogs.php?m=view&BID={$blogs[i].BID}">View</a><br>
                    <a href="blogs.php?m=edit&BID={$blogs[i].BID}">Edit</a><br>
                    <a href="blogs.php?m=all{if $page !=''}&page={$page}{/if}&a=delete&BID={$blogs[i].BID}" onClick="javascript:return confirm('Are you sure you want to delete this blog?');">Delete</a><br>
                    {if $blogs[i].status == '1'}
                    <a href="blogs.php?m=all{if $page !=''}&page={$page}{/if}&a=suspend&BID={$blogs[i].BID}" onClick="javascript:return confirm('Are you sure you want to suspend this blog?');">Suspend</a>
                    {else}
                    <a href="blogs.php?m=all{if $page !=''}&page={$page}{/if}&a=activate&BID={$blogs[i].BID}" onClick="javascript:return confirm('Are you sure you want to approve this blog?');">Activate</a>
                    {/if}
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
        {if $total_blogs >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>