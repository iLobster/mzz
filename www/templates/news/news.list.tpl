<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td><a href="/news/{$current_news->getId()}">{$current_news->getId()}</a></td>
			<td>{$current_news->getTitle()}</td>
			<td>{$current_news->getText()}</td>
			<td>{$current_news->getJip()}</td>
		</tr>
	{/foreach}
</table>

{load module="news" action="folders"}