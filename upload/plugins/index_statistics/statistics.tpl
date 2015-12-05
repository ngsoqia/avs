<div class="box">
	<div class="btitle"><h2>{t c='global.STATISTICS'}</h2></div>
	<div class="bcontent">
		{t c='stats.public_videos'}: &nbsp;<a href="{$relative}/videos?type=public">{$total_public_videos}</a><br />
		{t c='stats.private_videos'}: &nbsp;<a href="{$relative}/videos?type=private">{$total_private_videos}</a><br />
		{if $photo_module == '1'}
		{t c='stats.public_albums'}: &nbsp;<a href="{$relative}/albums?type=public">{$total_public_albums}</a><br />
		{t c='stats.private_albums'}: &nbsp;<a href="{$relative}/albums?type=private">{$total_private_albums}</a><br />
		{/if}
		{if $game_module == '1'}
		{t c='stats.public_games'}: &nbsp;<a href="{$relative}/games?type=public">{$total_public_games}</a><br />
		{t c='stats.private_games'}: &nbsp;<a href="{$relative}/games?type=private">{$total_private_games}</a><br />
		{/if}
		{if $blog_module == '1'}
		{t c='menu.blogs'}: &nbsp;<a href="{$relative}/blogs">{$total_blogs}</a><br />
		{/if}
		{t c='global.users'}: &nbsp;<a href="{$relative}/community">{$total_users}</a>
	</div>
</div>
