{foreach from=$properties key="propertyName" item="property"}
    {if $property.value != '' && (($action == 'list' && $property.isShort == TRUE) || ($action == 'view' && $property.isFull == TRUE))}

{if $property.type == 'select'}
    {if $property.value != 0 && $property.args[$property.value] != ''}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{elseif $property.type == 'datetime'}
    <strong>{$property.title}:</strong> {$property.value|date_format:$property.args}<br/>
{elseif $property.type == 'dynamicselect'}
    {if $property.value != 0}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{elseif $property.type == 'img'}
    <strong>{$property.title}:</strong><br />
    {foreach from=$property.value item="item"}
        <img src="{if $action == 'view'}{url route="fmFolder" name=$imageFile->getFullPath()}{else}{$item->extra()->getThumbnail()}{/if}" title="{$item->getName()|htmlspecialchars}" alt="{$item->getName()}" /><br />
    {/foreach}
{else}<strong>{$property.title}:</strong> {$property.value}<br/>{/if}

    {/if}
{/foreach}