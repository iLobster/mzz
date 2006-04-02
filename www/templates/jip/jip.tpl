{add file="popup.js"}
<table border="0" cellpadding="0" cellspacing="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href='{$item.url}' target="{$item.id}" onclick="javascript:openWin('{$item.id}', 500, 400);">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>