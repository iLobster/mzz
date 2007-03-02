<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.name.label}</strong></td>
            <td>{$form.name.html}</td>
        </tr>
        <tr>
            <td><strong>{$form.title.label}</strong></td>
            <td>{$form.title.html}</td>
        </tr>
{foreach from=$form.properties item="prop"}
        <tr>
            <td>{$prop.html}</td>
        </tr>
{/foreach}
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>