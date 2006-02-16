<table border="1" width="50%">
		<tr>
			<td>{$news->getId()}</td>
			<td>{$news->getTitle()}</td>
                        <td>{$news->getCreated()}</td>
			<td>{$news->getUpdated()}</td>
		</tr>
                <tr>
                        <td colspan="4">{$news->getText()}</td>
                </tr>
		<tr>
			<td colspan="4"><a href="{url section=news action=list}">назад</a> /
			<a href="{url section=news action=edit params=$news->getId()}">редактировать</a></td>
	    </tr>
</table>
