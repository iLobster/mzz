<div>
<div id="newsFolders">
<span class="title">Разделы</span><br />

{foreach from=$source->getFolders() item=current_folder name=folders}
    {'&nbsp;&nbsp;'|str_repeat:$current_folder->getLevel()}
     <a href="{url section=news action=list params=$current_folder->getPath()}">{$current_folder->getName()}</a> {$current_folder->getJip()}
    <br />
{/foreach}

</div>
</div>