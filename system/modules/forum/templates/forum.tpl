<table border="1" width="100%">
    {foreach from=$categories item=category name=cat}
        <tr>
            <td>Категория: {$category->getTitle()}</td>
        </tr>
        {foreach from=$category->getForums() item=forum}
            <tr>
                <td>Форум: <a href="{url route=withId action=list id=$forum->getId()}">{$forum->getTitle()}</a></td>
            </tr>
        {/foreach}
        {if not $smarty.foreach.cat.last}
            <tr>
                <td>&nbsp;</td>
            <tr>
        {/if}
    {/foreach}
</table>