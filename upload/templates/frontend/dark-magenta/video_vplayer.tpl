{if $video.embed_code != ''}
	<div class="video-embedded">
		{$video.embed_code}
	</div>
{else}
<script type="text/javascript" src="{$baseurl}/media/player/js/swfobject.js"></script>
<div id="flash" class="video-container">
	{if $video.iphone == 1}
		<video controls poster="{insert name=thumb_path vid=$video.VID}/default.jpg" width="100%" height="100%">
		  <source src="{$baseurl}/mobile_src.php?id={$video.VID}" type="video/mp4">
		</video>
	{else}
		<center>
			<div class="text-danger">{t c='video.not_available'}</div>
		</center>
	{/if}
</div>
{if !$canSee}
	{include file='video_limit.tpl'}
{/if} 
<script type="text/javascript">
// <![CDATA[
var so = new SWFObject("{$baseurl}/media/player/player.swf?f={$baseurl}/media/player/config.php?vkey={$video.VID}-{$new_permisions.watch_hd_videos}-{$new_permisions.in_player_ads}", "main", "100%", "100%", "9", "#000000");
so.addParam('allowfullscreen','true');
so.addParam('allowscriptaccess','always');
so.addParam('quality','high');
so.addParam('wmode','opaque');
so.write("flash");
// ]]>
</script>
{/if}

