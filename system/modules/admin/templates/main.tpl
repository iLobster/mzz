<div class="title">Управление сайтом</div>
{foreach from=$dashboard_modules item="dashboard_module"}
    {load module=$dashboard_module action="dashboard"}
{/foreach}