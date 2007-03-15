{foreach from=$item->exportOldProperties() key="property" item="value"}
            {$item->getPropertyTitle($property)}: {$value}<br/>
        {/foreach}
        {$item->getJip()}