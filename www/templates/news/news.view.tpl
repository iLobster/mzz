<table border="0" cellpadding="0" cellspacing="1" width="65%">
    <tr>
        <td>{$news->getId()}</td>
        <td>{$news->getTitle()}</td>
        <td><b>�������</b>: {$news->getCreated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        <td><b>��������</b>: {$news->getUpdated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        <td>{$news->getJip()}</td>
    </tr>
    <tr>
        <td colspan="5">{$news->getText()}</td>
    </tr>
    <tr>
        <td colspan="5"><a href="{url section=news action=list}">�����</a></td>
    </tr>
</table>
