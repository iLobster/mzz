<script language="JavaScript">
var massActionDelete = "{url route="default2" section="catalogue" action="delete"}";
var massActionMove = "{url route="default2" section="catalogue" action="move"}";
{literal}function selectAllItems(access) {
    $A(document.getElementsByTagName('input')).each(function(elm) {
        if (elm.type == 'checkbox' && elm.id.match(new RegExp('^catalogueitem_\\d+$', 'im'))) {
            elm.checked = access;
        }});
}
</script>{/literal}
<p class="pageTitle">Список элементов</p>
<div class="pageContent">
{include file="breadcrumbs.tpl" breadCrumbs=$chains section=$current_section module="catalogue"}
<form onsubmit="jipWindow.open((($('massAction').value == 'delete') ? massActionDelete : massActionMove), false, 'POST', $(this).serialize(true)); return false;">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="width: 1px;">{if $pager->getPagesTotal() > 0}<input type="checkbox" onclick="javascript:selectAllItems(this.checked);"/>{/if}</td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: center;">Тип</td>
                <td style="width: 120px;">Дата создания</td>
                <td style="width: 120px;">Автор</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        {if $catalogueFolder->getLevel() ne 1}
            <tr>
                <td style="text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: left;"><a href="{url route="admin" params=$catalogueFolder->getTreeParent()->getPath() section_name="catalogue" module_name="catalogue"}">..</a></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">{*$catalogueFolder->getTreeParent()->getJip()*}-</td>
            </tr>
        {/if}
        </thead>
        {foreach from=$catalogueFolder->getFolders() item="folder" name="folderIterator"}
            {if $folder->getLevel() eq $catalogueFolder->getLevel()+1}
            <tr>
                <td style="text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: left;"><a href="{url route='admin' params=$folder->getPath() section_name="catalogue" module_name="catalogue"}">{$folder->getTitle()}</a></td>
                <td style="text-align: center;">{if in_array($folder->getDefType(), array_keys($types))}{assign var="foldertype" value=$folder->getDefType()}{$types.$foldertype.title}{else}-{/if}</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">{$folder->getJip()}</td>
            </tr>
            {/if}
        {/foreach}
        {foreach from=$items item="item"}
            <tr>
                <td style="width: 30px; text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/news.gif" /></td>
                <td style="text-align: center;"><input type="checkbox" id="catalogueitem_{$item->getId()}" name="items[{$item->getId()}]" /></td>
                <td style="text-align: left;">{$item->getName()}</td>
                <td style="text-align: center;">{$item->getTypeTitle()}</td>
                <td style="text-align: center;">{$item->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
                <td style="text-align: center;">{$item->getEditor()->getLogin()}</td>
                <td style="text-align: center;">{$item->getJip()}</td>
            </tr>
        {/foreach}
        <tr class="tableListFoot">
            <td>&nbsp;</td>
            <td colspan="2">{if $pager->getPagesTotal() > 1}{$pager->toString('adminPager.tpl')}{/if}</td>
            <td colspan="3" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
        </tr>
    </table>
    {if $pager->getPagesTotal() > 0}<select id="massAction">
        <option value="move">Переместить</option>
        <option value="delete">Удалить</option>
    </select>
    <input type="submit" value="ok">{/if}
</form>
</div>
<br /><br /><br />
<p class="pageTitle">Список типов</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить тип" title="Добавить тип" align="texttop" border="0" /></a></td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$types item="type"}
        <tr>
            <td>&nbsp;</td>
            <td>{$type.title}</td>
            <td>{$type.name}</td>
            <td align="center">
                {assign var="typeId" value=$type.id}
                {include file="jip.tpl" jipMenuId="jip_types_$typeId" jip=$jipTypes[$type.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>
<br /><br />
<p class="pageTitle">Список параметров</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить свойство" title="Добавить свойство" border="0" align="texttop" /></a></td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Свойство</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$properties item="property"}
        <tr>
            <td>&nbsp;</td>
            <td>{$property.title}</td>
            <td>{$property.name}</td>
            <td>{$property.type}</td>
            <td align="center">
                {assign var="propId" value=$property.id}
                {include file="jip.tpl" jipMenuId="jip_properties_$propId" jip=$jipProperties[$property.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>