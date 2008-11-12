{include file='jipTitle.tpl' title='Создание модуля'}
{foreach from=$log item="item" key="id"}
    {$item}<br />
{/foreach}
<br />
<div class="generatorSuccessResult">
Модуль "{$name}" успешно создан в каталоге {$dest}
</div>