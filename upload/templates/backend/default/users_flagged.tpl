     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="users.php?m=flagged">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Email:</td><td><input type="text" name="email" value="{$option.email}"></td>
                <td align="right">Country:</td><td><input type="text" name="country" value="{$option.country}"></td>
            </tr>
            <tr>
                <td align="right">Full Name:</td><td><input type="text" name="name" value="{$option.name}"></td>
                <td align="right">Gender:</td>
                <td>
                    <select name="gender">
                    <option value=""{if $option.gender == ''} selected="selected"{/if}>------</option>
                    <option value="male"{if $option.gender == 'male'} selected="selected"{/if}>Male</option>
                    <option value="female"{if $option.gender == 'female'} selected="selected"{/if}>Female</option>
                    </select>
                </td>
                <td align="right">Relation:</td>
                <td>
                    <select name="relation">
                    <option value=""{if $option.relation == ''} selected="selected"{/if}>--------</option>
                    <option value="Single"{if $option.relation == 'Single'} selected="selected"{/if}>Single</option>
                    <option value="Taken"{if $option.relation == 'Taken'} selected="selected"{/if}>Taken</option>
                    <option value="Open"{if $option.relation == 'Open'} selected="selected"{/if}>Open</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="u.UID"{if $option.sort == 'u.UID'} selected="selected"{/if}>UID</option>
                    <option value="u.username"{if $option.sort == 'u.username'} selected="selected"{/if}>Username</option>
                    <option value="u.email"{if $option.sort == 'u.email'} selected="selected"{/if}>Email</option>
                    <option value="u.addtime"{if $option.sort == 'u.addtime'} selected="selected"{/if}>Joined</option>
                    <option value="u.logintime"{if $option.sort == 'u.logintime'} selected="selected"{/if}>Last Login</option>
                    <option value="u.country"{if $option.sort == 'u.country'} selected="selected"{/if}>Country</option>
                    <option value="u.gender"{if $option.sort == 'u.gender'} selected="selected"{/if}>Gender</option>
                    <option value="u.video_viewed"{if $option.sort == 'u.video_viewed'} selected="selected"{/if}>Videos Viewed</option>
                    <option value="u.profile_viewed"{if $option.sort == 'u.profile_viewed'} selected="selected"{/if}>Profile Viewed</option>
                    <option value="u.watched_video"{if $option.sort == 'u.watched_video'} selected="selected"{/if}>Watched Videos</option>
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
                    <input type="submit" name="search_videos" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_users >= 1}
        <form name="user_select" method="post" id="user_select" action="">
        <div id="actions">
            <input type="submit" name="delete_selected_users" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
            <input type="submit" name="suspend_selected_users" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
            <input type="submit" name="approve_selected_users" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">
            <input type="submit" name="unflag_selected_users" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to unflag all selected users?');">
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_users" type="checkbox" id="user_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Username</b></td>
                <td align="center"><b>Reporter</b></td>
                <td align="center"><b>Reason</b></td>
                <td align="center"><b>Flag Date</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $users}
            {section name=i loop=$users}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="user_id_checkbox_{$users[i].UID}" id="user_checkbox_{$users[i].UID}" type="checkbox"></td>
                <td align="center">{$users[i].UID}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">{$users[i].username}<br><br>
					<img src="../media/users/{if $users[i].photo == ''}nopic-{$users[i].gender}.gif{else}{$users[i].photo}{/if}" width="70"></a>
                </td>
                <td align="center">
                    {insert name=uid_to_name assign=uname uid=$users[i].RID}
                    <a href="users.php?m=view&UID={$users[i].RID}">{$uname}<br><br>
                </td>
                <td align="center">
                    <b>{$users[i].reason}</b><br />
                    {if $users[i].message}<br />{$users[i].message|escape:'html'|nl2br}{/if}
                </td>
                <td align="center">
                    {$users[i].addtime|date_format}
                </td>
                <td align="center">{$users[i].account_status}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">View</a><br>
                    <a href="users.php?m=edit&UID={$users[i].UID}">Edit</a><br>
                    <a href="users.php?m=flagged{if $page !=''}&page={$page}{/if}&a=delete&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to delete this user?');">Delete</a><br>
                    {if $users[i].account_status == 'Active'}
                    <a href="users.php?m=flagged{if $page !=''}&page={$page}{/if}&a=suspend&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to suspend this user?');">Suspend</a>
                    {else}
                    <a href="users.php?m=flagged{if $page !=''}&page={$page}{/if}&a=activate&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to activate this user?');">Activate</a>
                    {/if}
                    <br>
                    <a href="users.php?m=mail&email={$users[i].email}&username={$users[i].username}">Email</a><br />
                    <a href="users.php?m=flagged{if $page !=''}&page={$page}{/if}&a=unflag&FID={$users[i].flag_id}" onClick="javascript:return confirm('Are you sure you want to unflag this user?');">Unflag</a>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOU ARE LUCKY. THERE ARE NO REPORTED USERS!</div></td>
            </tr>
            {/if}
            </table>
            </form>
        </div>
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>