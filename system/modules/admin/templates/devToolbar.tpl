{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="jquery-ui/ui.draggable.js"}
{add file="jquery-ui/ui.resizable.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}
{add file="jip.css"}
{add file="jip/fileLoader.js"}
{add file="jip/window.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{add file="admin/toolbar.css"}
{add file="admin/devToolbar.js"}
<div class="title">devToolBar</div>

<!-- модули и классы -->
<div id="modulesAndClasses" class="toolbarBlock">
    <span class="toolbarSectionName"><strong>Модули</strong> и классы <span class="mzz-icon mzz-icon-block"><span class="mzz-overlay mzz-overlay-add"><a href="{url route="default2" section="admin" action="addModule"}" class="mzz-jip-link"></a></span></span></span>
    {foreach from=$modules item=module key=name}
        {assign var="count" value=$module.classes|@sizeof}
        <table id="module-{$name}" class="toolbar admin" cellspacing="0">
            <thead>
                <tr class="first">
                    <th class="first name"><img src="{$SITE_PATH}/templates/images/exp_{if isset($hiddenClasses.$name)}plus{else}minus{/if}.png" onclick="devToolbar.toggleModule('{$name}', this);" width="16" height="16" alt="expand/close classes list" title="expand/collapse classes" style="cursor: pointer">{$name}</th>
                    <th class="last actions">
                        {if not empty($module.editACL)}
                            <span class="mzz-icon mzz-icon-key"><a href="{url route=withId section="access" id="`$module.obj_id`" action="editACL"}" class="mzz-jip-link" title="Редактировать права доступа"></a></span>
                        {/if}
                        <span class="mzz-icon mzz-icon-block"><span class="mzz-overlay mzz-overlay-edit"><a href="{url route="withId" section="admin" id=$module.id action="editModule"}" class="mzz-jip-link" title="Редактировать модуль"></a></span></span>
                        <span class="mzz-icon mzz-icon-block"><span class="mzz-overlay mzz-overlay-del"><a href="{url route="withId" section="admin" id=$module.id action="deleteModule"}" class="mzz-jip-link" title="Удалить модуль"></a></span></span>
                        <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-add"><a href="{url route="withId" section="admin" id=$module.id action="addClass"}" class="mzz-jip-link" title="Добавить класс"></a></span></span>
                        <span class="mzz-icon mzz-icon-wrench"><a href="{url route="withId" section="config" id=$name action="list"}" class="mzz-jip-link" title="Редактировать опции модуля"></a></span>
                    </th>
                </tr>
            </thead>
            <tbody id="module-{$name}-classes" {if isset($hiddenClasses.$name)}style="display: none"{/if}>
            {foreach from=$module.classes item=class key=id name=classes}
                <tr id="class-{$class}" class="{if $smarty.foreach.classes.last}last{/if}">
                    <td class="first name">{$class}</td>
                    <td class="last actions">
                        {if not empty($module.editDefault)}
                        <span class="mzz-icon mzz-icon-key"><span class="mzz-overlay mzz-overlay-default"><a href="{url route=withAnyParam section="access" name=$class action="editDefault"}" class="mzz-jip-link" title="Редактировать права 'по умолчанию'"></a></span></span>
                        {/if}
                        <span class="mzz-icon mzz-icon-cog"><span class="mzz-overlay mzz-overlay-edit"><a href="{url route="withId" section="admin" id=$id action="listActions"}" class="mzz-jip-link" title="Редактировать действия класса"></a></span></span>
                        <span class="mzz-icon mzz-icon-db-table"><a href="{url route="withId" section="admin" id=$id action="map"}" class="mzz-jip-link" title="Map"></a></span>
                        <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-edit"><a href="{url route="withId" section="admin" id=$id action="editClass"}" class="mzz-jip-link" title="Редактировать класс"></a></span></span>
                        <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-del"><a href="{url route="withId" section="admin" id=$id action="deleteClass"}" class="mzz-jip-link" title="Удалить класс"></a></span></span>
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

<div class="toolbarBlock">
    <span class="toolbarSectionName"><strong>Разделы</strong> и модули <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-edit"><a href="{url route="default2" section="admin" action="editSections"}" class="mzz-jip-link"></a></span></span></span>
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

<div class="toolbarBlock">
    <span class="toolbarSectionName">Зарегистрированные объекты <span class="mzz-icon mzz-icon-db"><span class="mzz-overlay mzz-overlay-add"><a href="{url route="default2" section="admin" action="addObjToRegistry"}" class="mzz-jip-link"></a></span></span></span>
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
                <td class="first center"><a href="{url route="withId" section="access" id=$latestObject.obj_id action="editACL"}" class="jipLink">{$latestObject.obj_id}</a></td>
                <td class="last">{$latestObject.class_name}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    {*
    @todo: will be reimplemented later
    <br />
    <span class="toolbarSectionName">Переводы</span>
    <a href="{url route=default2 section=admin action=translate}" class="jipLink">Перевод модулей</a>
    *}
</div>