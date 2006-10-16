<table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <td>{$news->getId()}</td>
        <td>{$news->getTitle()}</td>
        <td><b>Создано</b>: {$news->getCreated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        <td><b>Изменено</b>: {$news->getUpdated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        <td>{$news->getJip()}</td>
    </tr>
    <tr>
        <td colspan="5">{$news->getText()}</td>
    </tr>
    <tr>
        <td colspan="5"><a href="{url section=news action=list params=$news->getFolder()->getName()}"><img src="/templates/images/back.gif" width="16" height="16" border="0" alt="Вернуться в папку" /></a></td>
    </tr>
</table>