<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td><a href="/news/{$current_news->get(id)}">{$current_news->get(id)}</a></td>
			<td>{$current_news->get(title)}</td>
			<td>{$current_news->get(text)}</td>
		</tr>
	{/foreach}
</table>

<a href="/news/list"> ����� 1 </a> / <a href="/news/folder2/list"> ����� 2</a>