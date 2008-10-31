{if not empty($isEdit)}
    {include file='jipTitle.tpl' title='Редактирование экшна'}
{else}
    {include file='jipTitle.tpl' title='Создание экшна'}
{/if}
{foreach from=$log item=item key=id}
    {$item}<br />
{/foreach}