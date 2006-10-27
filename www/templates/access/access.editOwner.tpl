Изменение прав на объект типа <b>{$class}</b> раздела <b>{$section}</b> для владельца объекта
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <form action="{url}" method="post">
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}]" value="1" {if not empty($acl.$action)}checked="checked"{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="Установить права"></td>
            <td><input type="reset" value="Сброс"></td>
        </tr>
    </form>
</table>