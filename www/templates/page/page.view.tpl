<table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <td>{$page->getId()}</td>
        <td>{$page->getName()}</td>
        <td>{$page->getTitle()}</td>
        <td>{$page->getJip()}</td>
    </tr>
    <tr>
        <td colspan="4">{$page->getContent()}</td>
    </tr>
    <tr>
        <td colspan="4"><a href="{url section=news action=list}">назад</a></td>
    </tr>
</table>
