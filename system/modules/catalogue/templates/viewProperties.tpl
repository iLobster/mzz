{foreach from=$properties key="propertyName" item="property"}
    {if $property.value != '' && (($action == 'list' && $property.isShort == TRUE) || $action == 'view')}
    
{if $property.type == 'select'}
    {if $property.value != 0 && $property.args[$property.value] != ''}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{elseif $property.type == 'datetime'}
    <strong>{$property.title}:</strong> {$property.value|date_format:$property.args}<br/>
{elseif $property.type == 'dynamicselect'}
    {if $property.value != 0}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
{elseif $property.type == 'img'}
    {if $action == 'view'}{assign var="imgAction" value="viewPhoto"}{else}{assign var="imgAction" value="viewThumbnail"}{/if}
    <img src="{url route="galleryPicAction" action=$imgAction id=$property.args[$property.value]->getId() album=$property.args[$property.value]->getAlbum()->getId() name=$property.args[$property.value]->getAlbum()->getGallery()->getOwner()->getLogin()}" />
{else}<strong>{$property.title}:</strong> {$property.value}<br/>{/if}

    {/if}
{/foreach}