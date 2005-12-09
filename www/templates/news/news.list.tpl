<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td><a href="/news/{$current_news.id}">{$current_news.id}</a></td>
			<td>{$current_news.title}</td>
			<td>{$current_news.text}</td>
		</tr>
	{/foreach}
</table>