<div>
<div id="catalogueFolders">
<span class="title">Разделы</span><br />

{foreach from=$source->getTreeForMenu() item="current_folder" name="folders"}
    {'&nbsp;&nbsp;'|str_repeat:$current_folder->getTreeLevel()}
     <a href="{url route="withAnyParam" section=$current_section action="list" name=$current_folder->getPath()}">{$current_folder->getTitle()}</a> {$current_folder->getJip()}
    <br />
{/foreach}
</div>
</div>
