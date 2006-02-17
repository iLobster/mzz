<table border="0" cellpadding="0" cellspacing="1" width="60%">
    <tr>
        <td>{$news->getId()}</td>
        <td>{$news->getTitle()}</td>
        <td><b>Создано</b>: {$news->getCreated()}</td>
        <td><b>Изменено</b>: {$news->getUpdated()}</td>
    </tr>
    <tr>
        <td colspan="4">{$news->getText()}</td>
    </tr>
    <tr>
        <td colspan="4"><a href="{url section=news action=list}">назад</a> /
        <a href="{url section=news action=edit params=$news->getId()}">редактировать</a></td>
    </tr>
</table>
