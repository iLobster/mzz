<table border="1" width="50%">
		<tr>
			<td>{$news.id}</td>
			<td>{$news.title}</td>
			<td>{$news.text}</td>
		</tr>
		<tr>
			<td colspan=3><a href="/news/list">назад</a> / <a href="/news/{$news.id}/edit">редактировать</a></td>
		</tr>
</table>