<table border="1">
        <tr>
                {foreach from=$jip item=item}
                        <td><a href="{$item.url}">{$item.title}</a></td>
                {/foreach}
        </tr>
</table>