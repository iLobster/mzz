<table border="0" cellpadding="0" cellspacing="1" width="50%">
    <tr>
        <td>{$page->getId()}</td>
        <td>{$page->getName()}</td>
        <td>{$page->getTitle()}</td>
        <td>{$page->getJip()}</td>
    </tr>
    <tr>
        <td colspan="4">{$page->getContent()}</td>
    </tr>
    {*
    <tr>
        <td colspan="4"><a href="{url section=page action=list}"><img src="/templates/images/back.gif" width="16" height="16" /></a></td>
    </tr>
    *}
</table>
