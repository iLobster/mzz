{include file='jipTitle.tpl' title='Создание ДО'}
{foreach from=$log item=item key=id}
    Создан файл <strong>{$item}</strong><br />
{/foreach}
<br />
<div class="generatorSuccessResult">
Класс "{$name}" успешно добавлен в модуль {$module}.
</div>