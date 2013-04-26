<table border="1">
    <tr>
{{foreach from=$map item=property key=field}}
        <td>{{$field}}</td>
{{/foreach}}
    </tr>

    {foreach from=$all item="{{$name}}"}
    <tr>
        {{foreach from=$map item=property key=field}}
            <td>
                {{$name|crud_property:$property}}
            </td>
        {{/foreach}}
    </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}