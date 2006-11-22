{add file="popup.js"}
{add file="confirm.js"}
<table cellspacing="0" cellpadding="0" border="0">
    <form method="post">
        {foreach from=$configs item=value key=key}
            <tr><td>
            {$key}
            </td><td>
            <input type="text" name="config[{$key}]" value="{$value.0.value}">
            </td></tr>
        {/foreach}
        <tr><td colspan="2">
            <input type="submit">
        </td></tr>
    </form>
</table>