     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_user" method="POST" enctype="multipart/form-data" action="users.php?m=add">
        <fieldset>
        <legend>Account Information</legend>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$user.username}" class="large"><br>
            <label for="email">Email Address: </label>
            <input type="text" name="email" value="{$user.email}" class="large"><br>
            <label for="password">Password: </label>
            <input type="password" name="password"><br>
            <label for="password_confirm">Confirm Password: </label>
            <input type="password" name="password_confirm"><br>
            <label for="emailverified">Email Verified: </label>
            <select name="emailverified">
            <option value="yes"{if $user.emailverified == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $user.emailverified == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="account_status">Account Status: </label>
            <select name="account_status">
            <option value="Active"{if $user.account_status == 'Active'} selected="selected"{/if}>Active</option>
            <option value="Inactive"{if $user.account_status == 'Inactive'} selected="selected"{/if}>Inactive</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Personal Information</legend>
            <label for="full_name">Full Name: </label>
            <input type="text" name="fname" value="{$user.fname}" class="medium">
            <input type="text" name="lname" value="{$user.lname}" class="medium"><br>
            <label for="gender">Gender: </label>
            <select name="gender">
            <option value="Male"{if $user.gender == 'Male'} selected="selected"{/if}>Male</option>
            <option value="Female"{if $user.gender == 'Female'} selected="selected"{/if}>Female</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_user" value="Add User" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>