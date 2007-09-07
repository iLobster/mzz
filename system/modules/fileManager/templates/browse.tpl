{foreach from=$files item="file"}
    {if $file->extra() instanceof fmImageFile}
        {assign var="fileName" value=$file->extra()->getThumbnail()->getName()}
        <img src="{url route="fmFolder" name="root/extras/thumbnails/$fileName"}" />
    {/if}
{/foreach}