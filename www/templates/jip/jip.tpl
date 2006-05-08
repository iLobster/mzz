{add file="popup.js"}
{add file="confirm.js"}
<table border="0" cellpadding="0" cellspacing="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href='{$item.url}' onclick="javascript: return {if not empty($item.confirm)}mzz_confirm('{$item.confirm}') &amp;&amp; {/if}openWin('{$item.url}', '{$item.id}', 500, 400);">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>