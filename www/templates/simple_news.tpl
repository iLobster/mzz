<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td>{$current_news.title}</td>
			<td>{$current_news.text}</td>
		</tr>
	{/foreach}
</table>