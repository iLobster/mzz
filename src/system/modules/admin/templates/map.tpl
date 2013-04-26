{if sizeof($added)}
    {_ map.added}:
    {foreach from=$added item=options key=field name=added}
        {$field} ({$options.type}){if !$smarty.foreach.added.last}, {/if}
    {/foreach}
    <br />
{/if}
{if sizeof($deleted)}
    {_ map.deleted}:
    {foreach from=$deleted item=field name=deleted}
        {$field}{if !$smarty.foreach.deleted.last}, {/if}
    {/foreach}
{/if}
{if sizeof($deleted) + sizeof($added) == 0}
{_ map.nothing_changed}
{/if}