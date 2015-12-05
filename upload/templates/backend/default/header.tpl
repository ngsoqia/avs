<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>AVS Admin Control Panel</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="{$relative_tpl}/css/style_admin.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
    var base_url = '{$baseurl}';
    var media_base_url = '{$mediabaseurl}';
    </script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.corner.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.livequery.pack.js"></script>
    {if isset($crop)}<script type="text/javascript" src="{$relative_tpl}/js/jquery.album-0.1.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.imgareaselect-0.6.1.min.js"></script>
    {/if}
    {if isset($editor)}
    <script type="text/javascript" src="{$baseurl}/addons/markitup/jquery.markitup.js"></script>
    <script type="text/javascript" src="{$baseurl}/addons/markitup/sets/{$editor_set}/set.js"></script>    
    <link rel="stylesheet" type="text/css" href="{$baseurl}/addons/markitup/skins/{$editor_skin}/style.css" />
    <link rel="stylesheet" type="text/css" href="{$baseurl}/addons/markitup/sets/{$editor_set}/style.css" />
    {/if}
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.admin-0.1.js"></script>

</head>
<div id="container">
    <div id="header">
        <div id="menu">
		<img src="{$relative_tpl}/images/logo.png" style="margin-left: 15px;">		
        <ul>
			{if $multi_server == '1'}
            <li>{if $active_menu eq 'servers'}<span>Servers</span>{else}<a href="servers.php">Servers</a>{/if}</li>
			{/if}
            <li>{if $active_menu eq 'notice'}<span>Notices</span>{else}<a href="notices.php?all=1">Notices</a>{/if}</li>
            <li>{if $active_menu eq 'channels'}<span>Categories</span>{else}<a href="channels.php">Categories</a>{/if}</li>
            <li>{if $active_menu eq 'users'}<span>Users</span>{else}<a href="users.php?all=1">Users</a>{/if}</li>
            <li>{if $active_menu eq 'games'}<span>Games</span>{else}<a href="games.php?all=1">Games</a>{/if}</li>
            <li>{if $active_menu eq 'blogs'}<span>Blogs</span>{else}<a href="blogs.php?all=1">Blogs</a>{/if}</li>
            <li>{if $active_menu eq 'albums'}<span>Albums</span>{else}<a href="albums.php?all=1">Albums</a>{/if}</li>
            <li>{if $active_menu eq 'videos'}<span>Videos</span>{else}<a href="videos.php?all=1">Videos</a>{/if}</li>
            <li>{if $active_menu eq 'index'}<span>Settings</span>{else}<a href="index.php">Settings</a>{/if}</li>
        </ul>
        </div>
    </div>
    <div id="content">