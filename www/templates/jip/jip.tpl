<table border="0" cellpadding="0" cellspacing="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href="{$item.url}">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>