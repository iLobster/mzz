<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td><b>ID</b></td>
        <td><b>Название</b></td>
        <td><b>Заголовок</b></td>
        <td><b>JIP</b></td>
    </tr>
    {foreach from=$pages item=page}
        <tr>
            <td align="center">{$page->getId()}</td>
            <td><a href="{url route=withAnyParams section=page action=view name=$page->getName()}">{$page->getName()}</a></td>
            <td>{$page->getTitle()}</td>
            <td align="center">{$page->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url route=default2 section=page action=create}"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
        <td colspan="6"><a href="{url route=default2 section=page action=create}">Создать страницу</a></td>
    </tr>
</table>