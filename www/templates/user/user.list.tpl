{add file="popup.js"}
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="3">Страницы ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            <td>{$user->getLogin()}</td>
            <td>{$user->getJip()}</td>
        </tr>
    {/foreach}
</table>