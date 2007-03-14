<div class="jipTitle">Редактирование</div>
<form onsubmit="return mzzAjax.sendForm(this);" {$form.attributes}>
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>{$form.name.label}</td> 
            <td>{$form.name.html}</td>
        <tr>
{foreach from=$fields item="element"}
        <tr>
            <td>{$form.$element.label}</td> 
            <td>{$form.$element.html}</td>
        <tr>
{/foreach}
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>