{if $errors}
<div id="errorbox">
{section name=i loop=$errors}
{$errors[i]}<br />
{/section}
</div>
{/if}
{if $messages}
<div id="messagebox">
{section name=i loop=$messages}
{$messages[i]}<br />
{/section}
</div>
{/if}
