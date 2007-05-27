{if $property.type == 'select'}
    {if $property.value != 0 && $property.args[$property.value] != ''}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{elseif $property.type == 'datetime'}
    <strong>{$property.title}:</strong> {$property.value|date_format:$property.args}<br/>
{elseif $property.type == 'dynamicselect'}
    {if $property.value != 0}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{else}<strong>{$property.title}:</strong> {$property.value}<br/>{/if}