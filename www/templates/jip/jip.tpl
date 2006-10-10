{add file="popup.js"}
{add file="confirm.js"}
<table border="0" cellpadding="0" cellspacing="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href='{$item.url}' onclick="javascript: {if not empty($item.confirm)}mzz_confirm('{$item.confirm}') &amp;&amp; {/if}openWin('{$item.url}', '{$item.id|replace:"/":"_"}', 500, 400); return false;">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>