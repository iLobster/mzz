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
<!-- модули и классы -->
<div class="pageContent">
<div class="toolbarLayerTopLeft">
    <span class="toolbarSectionName"><strong>Модули</strong> и классы</span> <a href="{url route="default2" section="admin" action="addModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить модуль" title="Добавить модуль" style="position: absolute; margin: 4px;" /></a>
        <table id="modulesAndClasses" class="toolbarActions" cellspacing="0">
            {foreach from=$modules item=module key=name}
                {assign var="count" value=$module.classes|@sizeof}
                <tbody id="module-{$name}" class="toolbarModules">
                    <tr>
                        <th class="name">{$name}</th>
                        <th class="actions">

                            {if $count eq 0}
                                <a href="{url route="withId" section="admin" id=$module.id action="deleteModule"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить модуль" title="Удалить модуль" /></a>
                            {/if}
                            {if not empty($module.editACL)}
                                <a href="{url route=withId section="access" id="`$module.obj_id`" action="editACL"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/acl.gif" alt="ACL" /></a>
                            {/if}
                            <a href="{url route="withId" section="admin" id=$module.id action="editModule"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать модуль" title="Редактировать модуль" /></a>
                            <a href="{url route="withId" section="admin" id=$module.id action="addClass"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить класс" title="Добавить класс" /></a>
                            <a href="{url route="withId" section="config" id=$name action="list"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/config.gif" alt="Параметры конфигурации" title="Параметры конфигурации" /></a>
                        </th>
                    </tr>
                </tbody>
                <tbody id="module-{$name}-classes" class="toolbarClasses">
                    {foreach from=$module.classes item=class key=id}
                        <tr id="class-{$class}">
                            <td class="name">{$class}</td>
                            <td class="actions">
                                {if not empty($module.editDefault)}
                                    <a href="{url route=withAnyParam section="access" name=$class action="editDefault"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/aclDefault.gif" alt="Default ACL" /></a>
                                {/if}

                                <a href="{url route="withId" section="admin" id=$id action="listActions"}" class="jipLink"><img src='{$SITE_PATH}/templates/images/actions.gif' title="Действия класса" alt="Действия класса" /></a>
                                <a href="{url route="withId" section="admin" id=$id action="editClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать класс" title="Редактировать класс" /></a>
                                <a href="{url route="withId" section="admin" id=$id action="deleteClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить класс" title="Удалить класс" /></a>

                            </td>
                        </tr>
                    {foreachelse}
                        <tr class="toolbarEmpty">
                            <td colspan="2">--- классов нет ---</td>
                        </tr>
                    {/foreach}
                </tbody>
            {/foreach}
        </table>
</div>

<div class="toolbarLayerTopLeft">
    <span class="toolbarSectionName"><strong>Разделы</strong> и модули</span> <a href="{url route="default2" section="admin" action="editSections"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать секции" title="Редактировать секции" style="position: absolute; margin: 4px;" /></a>
    <ul>
        {foreach from=$sections item=module key=section}
            <li>{$section} -&gt; {$module}</li>
        {/foreach}
    </ul>
</div>

<div class="toolbarLayerBottomLeft">
    <span class="toolbarSectionName">Зарегистрированные объекты</span> <a href="{url route="default2" section="admin" action="addObjToRegistry"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/DB.png" alt="Сгенерировать" title="Генерация и регистрация нового идентификатора объекта" style="position: absolute; margin: 4px;" /></a>
    <table class="toolbarObjects highlightCols" cellpadding="2" cellspacing="0">
        <tr class="toolbarObjectsTitle toolbarTitleBg" onmouseover="Event.stop(event);">
            <td style="width: 45px;" class="toolbarBorder">obj_id</td>
            <td class="toolbarBorder">класс</td>
        </tr>
            {foreach from=$latestObjects item=latestObject}
                <tr>
                    <td><a href="{url route="withId" section="access" id=$latestObject.obj_id action="editACL"}" class="jipLink">{$latestObject.obj_id}</a></td>
                    <td>{$latestObject.class_name}</td>
                </tr>
            {/foreach}
    </table>

    <br />

    <span class="toolbarSectionName">Переводы</span>
    <br />
    <a href="{url route=default2 section=admin action=translate}" class="jipLink">Перевод модулей</a>
</div>
</div>
