<table border="1">
    <tr>
        {{foreach from=$map item=property key=field}}
            <td>{{$field}}</td>
        {{/foreach}}
    </tr>

    {foreach from=$all item={{$controller_data.class}}}
        <tr>
            {{foreach from=$map item=property key=field}}
                <td>
                    {{$controller_data.class|crud_property:$property}}
                </td>
            {{/foreach}}
        </tr>
    {/foreach}
</table>