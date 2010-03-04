{add file="jquery.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}
{add file="jip.css"}
{add file="jip/jipMenu.css"}
{add file="jip/jipWindow.css"}
{add file="fileLoader.js"}
{add file="jip/jipCore.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{add file="admin/toolbar.css"}
{add file="admin/devToolbar.js"}

{include file="admin/title.tpl" title="devToolBar"}
<!-- модули и классы -->
<div id="modulesAndClasses" class="toolbarBlock">
    <span class="toolbarSectionName"><strong>Модули</strong> и классы <a href="{url route="default2" module="admin" action="addModule"}" class="mzz-jip-link">{icon sprite="sprite:admin/module-add/admin"}</a></span>
    {foreach from=$modules item=module}
        {assign var=name value=$module->getName()}
        {assign var="count" value=$module->getActions()|@sizeof}
        <table id="module-{$name}" class="toolbar admin" cellspacing="0">
            <thead>
                <tr class="first">
                    <th class="first name"><img src="{$SITE_PATH}/images/exp_{if isset($hiddenClasses.$name)}plus{else}minus{/if}.png" onclick="devToolbar.toggleModule('{$name}', this);" width="16" height="16" alt="expand/close classes list" title="expand/collapse classes" style="cursor: pointer" />{$name}</th>
                    <th class="last right">
                        <a href="{url route="accessEditRoles" module_name=$name action="list"}" class="mzz-jip-link" title="Редактировать права доступа">{icon sprite="sprite:admin/module-acl/admin"}</a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="editModule"}" class="mzz-jip-link" title="Редактировать модуль">{icon sprite="sprite:admin/module-edit/admin"}</a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="deleteModule"}" class="mzz-jip-link" title="Удалить модуль">{icon sprite="sprite:admin/module-del/admin"}</a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="addClass"}" class="mzz-jip-link" title="Добавить класс">{icon sprite="sprite:admin/class-add/admin"}</a>
                    </th>
                </tr>
            </thead>
            <tbody id="module-{$name}-classes" {if isset($hiddenClasses.$name)}style="display: none"{/if}>
            {foreach from=$module->getClasses() item=class name=classes}
                <tr id="class-{$class}" class="{if $smarty.foreach.classes.last}last{/if}">
                    <td class="first name">{$class}</td>
                    <td class="last right">
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="listActions"}" class="mzz-jip-link" title="Редактировать действия класса">{icon sprite="sprite:admin/action-edit/admin"}</a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="map"}" class="mzz-jip-link" title="Map">{icon sprite="sprite:admin/db-table/admin"}</a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="editClass"}" class="mzz-jip-link" title="Редактировать класс">{icon sprite="sprite:admin/class-edit/admin"}</a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="deleteClass"}" class="mzz-jip-link" title="Удалить класс">{icon sprite="sprite:admin/class-del/admin"}</a>
                    </td>
                </tr>
            {foreachelse}
                <tr class="last empty">
                    <td class="first name">--- классов нет ---</td>
                    <td class="last actions">&nbsp;</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/foreach}
</div>
{*
<div class="toolbarBlock">
    <span class="toolbarSectionName"><strong>Разделы</strong> и модули <a href="{url route="default2" module="admin" action="editSections"}" class="mzz-jip-link"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-edit"></span></span></a></span>
    <table class="toolbar admin" cellspacing="0">
        <thead class="toolbarModules">
            <tr class="first">
                <th class="first">секция</th>
                <th class="last">модуль</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$sections item=module key=section name=sections}
                <tr class="{if $smarty.foreach.sections.last}last{/if}">
                    <td class="first">{$section}</td>
                    <td class="last">{$module}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>
*}
{*
<div class="toolbarBlock">
    <span class="toolbarSectionName">Зарегистрированные объекты <a href="{url route="default2" module="admin" action="addObjToRegistry"}" class="mzz-jip-link"><span class="mzz-icon mzz-icon-db"><span class="mzz-bullet mzz-bullet-add"></span></span></a></span>
    <table class="toolbar admin" id="aclObjects" cellspacing="0">
        <thead>
            <tr class="first">
                <th class="first">obj_id</th>
                <th class="last">Имя класса</th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$latestObjects item=latestObject name=latestObjects}
            <tr class="{if $smarty.foreach.latestObjects.last}last{/if}">
                <td class="first center"><a href="{url route="withId" module="access" id=$latestObject.obj_id action="editACL"}" class="mzz-jip-link">{$latestObject.obj_id}</a></td>
                <td class="last">{$latestObject.class_name}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
*}