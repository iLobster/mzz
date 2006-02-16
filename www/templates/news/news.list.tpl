<table border="1" width="50%">
	{foreach from=$news item=current_news}
		<tr>
			<td><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getId()}</a></td>
			<td>{$current_news->getTitle()}</td>
			<td>{$current_news->getText()}</td>
                        <td>{$current_news->getCreated()}</td>
			<td>{$current_news->getJip()}</td>
		</tr>
	{/foreach}		
		<tr>
			<td colspan="5"><a href="{url section=news action=create}">Добавить новость</a></td>
		</tr>
</table>

{load module="news" action="folders"}