<table border="1" width="50%">
		<tr>
			<td>{$news->get(id)}</td>
			<td>{$news->get(title)}</td>
			<td>{$news->get(text)}</td>
		</tr>
		<tr>
			<td colspan=3><a href="/news/list">�����</a> / <a href="/news/{$news->get(id)}/edit">�������������</a></td>
		</tr>
</table>