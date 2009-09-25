<div class="title">Управление сайтом</div>
{foreach from=$dashboard item="action"}
    {$action->run()}
{/foreach}