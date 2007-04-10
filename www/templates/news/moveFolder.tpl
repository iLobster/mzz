{assign var="path" value=$folder->getPath()|htmlspecialchars}
{include file='jipTitle.tpl' title="Перемещение каталога `$path`"}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.dest.label}</td>
            <td>{$form.dest.html}{$form.dest.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>
<div id="folderTree" class="dtree"></div>

<script type="text/javascript">
var d = new dTree('d');
d.add(0,-1,'Дерево папок');

{foreach from=$folders item=current_folder}
{assign var="parentFolder" value=$current_folder->getTreeParent()|htmlspecialchars}
d.add({$current_folder->getId()},{if is_object($parentFolder)}{$parentFolder->getId()}{else}0{/if},'{$current_folder->getName()}','');
{/foreach}
document.getElementById('folderTree').innerHTML = d;
</script>