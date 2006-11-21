{include file="news/news.tree.tpl" source=$news->getFolder()}

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
</table>
{load module="comments" section="comments" action="list" parent_id=$news->getObjId() owner=$news->getEditor()->getId()}