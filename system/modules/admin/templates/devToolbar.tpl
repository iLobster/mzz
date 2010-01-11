{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="jquery-ui/ui.draggable.js"}
{add file="jquery-ui/ui.resizable.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}
{add file="jip.css"}
{add file="jip/jipCore.css"}
{add file="fileLoader.js"}
{add file="jip/jipCore.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{add file="admin/toolbar.css"}
{add file="admin/devToolbar.js"}

<div class="title">devToolBar</div>

<!-- модули и классы -->
<div id="modulesAndClasses" class="toolbarBlock">
    <span class="toolbarSectionName"><strong>Модули</strong> и классы <a href="{url route="default2" module="admin" action="addModule"}" class="mzz-jip-link"><span class="mzz-icon mzz-icon-block"><span class="mzz-bullet mzz-bullet-add"></span></span></a></span>
    {foreach from=$modules item=module}
        {assign var=name value=$module->getName()}
        {assign var="count" value=$module->getActions()|@sizeof}
        <table id="module-{$name}" class="toolbar admin" cellspacing="0">
            <thead>
                <tr class="first">
                    <th class="first name"><img src="{$SITE_PATH}/images/exp_{if isset($hiddenClasses.$name)}plus{else}minus{/if}.png" onclick="devToolbar.toggleModule('{$name}', this);" width="16" height="16" alt="expand/close classes list" title="expand/collapse classes" style="cursor: pointer" />{$name}</th>
                    <th class="last actions">
                        {*
                        {if not empty($module.editACL)}
                            <a href="{url route=withId module="access" id="`$module.obj_id`" action="editACL"}" class="mzz-jip-link" title="Редактировать права"><span class="mzz-icon mzz-icon-key"></span></a>
                        {/if}
                        *}
                        <a href="{url route="accessEditRoles" module_name=$name action="list"}" class="mzz-jip-link" title="Редактировать права доступа"><span class="mzz-icon mzz-icon-key"><span class="mzz-bullet mzz-bullet-edit"></span></span></a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="editModule"}" class="mzz-jip-link" title="Редактировать модуль"><span class="mzz-icon mzz-icon-block"><span class="mzz-bullet mzz-bullet-edit"></span></span></a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="deleteModule"}" class="mzz-jip-link" title="Удалить модуль"><span class="mzz-icon mzz-icon-block"><span class="mzz-bullet mzz-bullet-del"></span></span></a>
                        <a href="{url route="withAnyParam" module="admin" name=$name action="addClass"}" class="mzz-jip-link" title="Добавить класс"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-add"></span></span></a>
                    </th>
                </tr>
            </thead>
            <tbody id="module-{$name}-classes" {if isset($hiddenClasses.$name)}style="display: none"{/if}>
            {foreach from=$module->getClasses() item=class name=classes}
                <tr id="class-{$class}" class="{if $smarty.foreach.classes.last}last{/if}">
                    <td class="first name">{$class}</td>
                    <td class="last actions">
                        {*
                        {if not empty($module.editDefault)}
                        <a href="{url route=withAnyParam module="access" name=$class action="editDefault"}" class="mzz-jip-link" title="Редактировать права 'по умолчанию'"><span class="mzz-icon mzz-icon-key"><span class="mzz-bullet mzz-bullet-default"></span></span></a>
                        {/if}
                        *}
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="listActions"}" class="mzz-jip-link" title="Редактировать действия класса"><span class="mzz-icon mzz-icon-cog"><span class="mzz-bullet mzz-bullet-edit"></span></span></a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="map"}" class="mzz-jip-link" title="Map"><span class="mzz-icon mzz-icon-db-table"></span></a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="editClass"}" class="mzz-jip-link" title="Редактировать класс"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-edit"></span></span></a>
                        <a href="{url route="adminModuleEntity" module="admin" module_name=$name class_name=$class action="deleteClass"}" class="mzz-jip-link" title="Удалить класс"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-del"></span></span></a>
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