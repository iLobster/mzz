<table border="1" width="50%">
		<tr>
			<td>{$news->getId()}</td>
			<td>{$news->getTitle()}</td>
			<td>{$news->getText()}</td>
		</tr>
		<tr>
			<td colspan=3><a href="/news/list">�����</a> / <a href="/news/{$news->getId()}/edit">�������������</a></td>		</tr>
</table>
