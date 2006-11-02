<form {$form.attributes}>
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        {if $action eq 'groupEdit'}
        <tr>
            <td><b>ID:</b></td><td>{$group->getId()}</td>
        </tr>
        {/if}
        <tr>
            <td><b>{$form.name.label}</b></td><td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}</td>
            <td>{$form.reset.html}</td>
        </tr>
    </table>
</form>
