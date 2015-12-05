<div class="box">
    <div class="btitle"><h2>{t c='global.POPULAR_TAGS'}</h2></div>
	<ul id="cloud">
	{foreach from=$tags key=tag item=count}
	<li><a href="{$relative}/search?search_query={$tag|escape:'html'}&search_type=videos" class="tag{$count}">{$tag|escape:'html'|lower}</a></li>
	{/foreach}
    </ul>
</div>
