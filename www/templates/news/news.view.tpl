<table border="1" width="50%">
		<tr>
			<td>{$news->getId()}</td>
			<td>{$news->getTitle()}</td>
			<td>{$news->getText()}</td>
		</tr>
		<tr>
			<td colspan=3><a href="{url section=news action=list}">�����</a> /
			<a href="{url section=news action=edit params=$news->getId()}">�������������</a></td>
	    </tr>
</table>
