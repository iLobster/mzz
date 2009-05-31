<table border="1">
    {{foreach from=$map item=property key=field}}
        <tr>
            <td>{{$field}}</td>
            <td>{{$controller_data.class|crud_property:$property}}</td>
        </tr>
    {{/foreach}}
</table>