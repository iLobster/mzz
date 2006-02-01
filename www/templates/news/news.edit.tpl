
<form {$form.attributes}>
{$form.hidden}
<table border="1" width="50%">
		<tr>
			<td>{$news->getId()}</td>
			<td>{$form.title.label} {$form.title.html}</td>
		</tr>
		<tr>
			<td colspan="2">{$form.text.html}</td>
        <tr>
			<td>{$form.submit.html}</td>
		    <td>{$form.reset.html}</td>
		</tr>
		<tr>
			<td colspan=3><a href="/news/list">назад</a></td>
		</tr>
</table>
</form>
