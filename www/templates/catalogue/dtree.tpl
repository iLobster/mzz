<div>
<div id="catalogueFolders">
<script type="text/javascript">
var catalogueFolders = new dTree('catalogueFolders');
catalogueFolders.add(0,-1,'mzzCatalogue (<a style="text-decoration:underline; color:blue;" href="{url route="admin" module_name="catalogue" section_name="catalogue" params="admin"}">Настройка</a>)');

{foreach from=$folders item="folder"}
{assign var="parentFolder" value=$folder->getTreeParent()}
catalogueFolders.add({$folder->getId()},{if is_object($parentFolder)}{$parentFolder->getId()}{else}0{/if},'{$folder->getTitle()}</a>{$folder->getJip()|strip|escape:quotes}<a>','{url route="withAnyParam" section=$current_section action="list" name=$folder->getPath()}', '', '', '{$SITE_PATH}/templates/images/tree/folder.gif', '{$SITE_PATH}/templates/images/tree/folderopen.gif');
{/foreach}
document.write(catalogueFolders);
</script>
</div>
</div>