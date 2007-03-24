{assign var="iteration" value="0"}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
{foreach from=$source->getFolders() item="current_folder" name="folders"}
    {if $current_folder->getLevel() eq $source->getLevel()+1}
        {if $iteration%4 eq 0}
            </tr>
            <tr>
        {/if}
                <td>
                    <h3><a href="{url route="withAnyParam" section="catalogue" action="list" name=$current_folder->getPath()}">{$current_folder->getTitle()}</a> {$current_folder->getJip()}</h3>
                </td>
        {assign var="iteration" value=$iteration+1}
    {/if}
{/foreach}
    </tr>
</table>