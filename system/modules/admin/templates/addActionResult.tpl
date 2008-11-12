{if not empty($isEdit)}
    {include file='jipTitle.tpl' title='Редактирование экшна'}
{else}
    {include file='jipTitle.tpl' title='Создание экшна'}
{/if}
{foreach from=$log item=item key=id}
    Создание <strong>{$item}</strong><br />
{/foreach}
<br />
<div class="generatorSuccessResult">
{if not empty($isEdit)}Изменения для действия "{$name}" сохранены{else}Действие "{$name}" успешно создано{/if}.
</div>