Изменение прав на объект типа <b>{$class}</b> раздела <b>{$section}</b> для владельца объекта
<form action="{url}" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}checked="checked"{/if} /><input type="checkbox" name="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}checked="checked"{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="Установить права"></td>
            <td><input type="reset" value="Сброс"></td>
        </tr>
</table>
</form>