{foreach from=$items item="item"}
    {foreach from=$item->exportOldProperties() key="property" item="value"}
    {$item->getTitle($property)}: {$value}<br/>
    {/foreach}
    {$item->getJip()}
    <br/><br/>
{/foreach}