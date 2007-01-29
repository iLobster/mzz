{foreach from=$insert item=item key=id name=insert}
    {if $smarty.foreach.insert.first}
        <font color="green">Были добавлены экшны</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.insert.last}, {else}.<br />{/if}
{foreachelse}
    Новых экшнов добавлено не было.<br />
{/foreach}
{foreach from=$delete item=item key=id name=delete}
    {if $smarty.foreach.delete.first}
        <font color="red">Были удалены экшны</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.delete.last}, {else}.<br />{/if}
{foreachelse}
    Экшнов удалено не было.<br />
{/foreach}
<br />Операция успешно выполнена.