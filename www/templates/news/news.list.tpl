<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td><a href="/news/{$current_news->getId()}">{$current_news->getId()}</a></td>
			<td>{$current_news->getTitle()}</td>
			<td>{$current_news->getText()}</td>
		</tr>
	{/foreach}
</table>

<a href="/news/list"> ����� 1 </a> / <a href="/news/folder2/list"> ����� 2</a>