<table border="1">
    {{foreach from=$map item=property key=field}}
        <tr>
            <td>{{$field}}</td>
            {{if $property.type eq 'char'}}
                <td>{${{$controller_data.class}}->{{$property.accessor}}()|h}</td>
            {{else}}
                <td>{${{$controller_data.class}}->{{$property.accessor}}()}</td>
            {{/if}}
        </tr>
    {{/foreach}}
</table>