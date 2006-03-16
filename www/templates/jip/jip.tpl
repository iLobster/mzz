<table border="0" cellpadding="0" cellspacing="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href='{$item.url}' onclick="javascript:window.open('{$item.url}', '', 'left=300, top=300, height=400, width=500, status=no, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no'); return false;">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>