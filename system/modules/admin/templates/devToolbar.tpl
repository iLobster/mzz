{add file="admin/toolbar.css"}
{add file="admin/devToolbar.js"}
<script type="text/javascript">
var HOVER_BG_COLOR = '#FFFDE1';
var TITLE_BG_COLOR = '#F2F2F2';
var SECOND_BG_COLOR = '#FFFFFF';
</script>
<!-- модули и классы -->
<div class="pageContent">
<div class="toolbarLayerTopLeft">
    <span class="toolbarSectionName"><strong>Модули</strong> и классы</span>  <a href="{url route="default2" section="admin" action="addModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить модуль" title="Добавить модуль" style="position: absolute; margin: 4px;" /></a>
    <table class="toolbarActions" cellspacing="0" id="modulesAndClasses">
        {foreach from=$modules item=module key=id }
            <tbody>
            {assign var="count" value=$module.classes|@sizeof}
            <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = TITLE_BG_COLOR">
                <td class="toolbarBorder"><strong>{$module.name}</strong></td>
                <td class="toolbarActions">
                    {if $count eq 0}
                        <a href="{url route="withId" section="admin" id=$id action="deleteModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить модуль" title="Удалить модуль" /></a>
                    {/if}
                    <a href="{url route="withId" section="admin" id=$id action="addClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить класс" title="Добавить класс" /></a>
                    <a href="{url route="withId" section="admin" id=$id action="listCfg"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/config.gif" alt="Параметры конфигурации" title="Параметры конфигурации" /></a>
                    <a href="{url route="withId" section="admin" id=$id action="editModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать модуль" title="Редактировать модуль" /></a>

                </td>
            </tr>
            </tbody>
            <tbody id="module-{$module.name}-classes">
            {foreach from=$module.classes item=class key=id}
                <tr onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = SECOND_BG_COLOR">
                    <td class="toolbarElementName" colspan="2">
                        <a href="{url route="withId" section="admin" id=$id action="deleteClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить класс" title="Удалить класс" /></a>
                        <a href="{url route="withId" section="admin" id=$id action="editClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать класс" title="Редактировать класс" /></a>
                        <a href="{url route="withId" section="admin" id=$id action="listActions"}" class="jipLink"><img src='{$SITE_PATH}/templates/images/actions.gif' title="Действия класса" alt="Действия класса" /></a>
                        <a href="{url route="withAnyParam" section="admin" name=$class.name action="readmap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/admin/model.gif" alt="Схема объекта" title="Схема объекта" /></a>
                        <span class="className{if $class.name eq $module.main_class_name} mainClass{/if}">{$class.name}</span>
                    </td>
                </tr>
            {/foreach}
            {if $count eq 0}
                <tr onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = SECOND_BG_COLOR">
                    <td colspan="2" class="toolbarElementName toolbarEmpty">--- классов нет ---</td>
                </tr>
            {/if}
            </tbody>
        {/foreach}
    </table>
<br />
<br />
</div>
<!-- секции и классы -->
<div class="toolbarLayerTopRight">
    <span class="toolbarSectionName"><strong>Секции</strong> и классы</span> <a href="{url route="default2" section="admin" action="addSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Создать раздел" title="Создать раздел" style="position: absolute; margin: 4px;" /></a>
    <table class="toolbarActions" cellspacing="0" id="sectionsAndClasses">
        {foreach from=$sections item=section key=id}
            {assign var="count" value=$section.classes|@sizeof}
            <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = TITLE_BG_COLOR">
                <td class="toolbarBorder"><strong>{$section.name}</strong></td>
                <td class="toolbarActions">
                    {if $count eq 0}
                        <a href="{url route="withId" section="admin" id=$id action="deleteSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить раздел" title="Удалить раздел" /></a>
                    {/if}
                    <a href="{url route="withId" section="admin" id=$id action="addModuleToSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/classes.gif" alt="редактировать список модулей" title="Редактировать список модулей" /></a>
                    <a href="{url route="withId" section="admin" id=$id action="editSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать раздел" title="Редактировать раздел" /></a>
                    </td>
            </tr>
            {foreach from=$section.classes item=class key=id}
                <tr onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = SECOND_BG_COLOR">
                    <td class="toolbarElementName" colspan="2">
                        {assign var="name" value="`$section.name`_`$class`"}
                        {if not empty($access.$name.editDefault)}<a href="{url route=withAnyParam section="access" name="`$section.name`/`$class`" action="editDefault"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/aclDefault.gif" alt="Default ACL" /></a>{/if}
                        {if not empty($access.$name.editACL)}
                        <a href="{url route=withId section="access" id="`$access.$name.obj_id`" action="editACL"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/acl.gif" alt="ACL" /></a>{/if}
                        <span style="margin-left: 10px;">
                        {$class}
                        </span>
                    </td>
                </tr>
            {/foreach}
            {if $count eq 0}
                <tr onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = SECOND_BG_COLOR">
                    <td colspan="2" class="toolbarElementName toolbarEmpty">--- классов нет ---</td>
                </tr>
            {/if}
        {/foreach}
    </table>
</div>

<div class="toolbarLayerBottomLeft">
    <span class="toolbarSectionName">Зарегистрированные объекты</span> <a href="{url route="default2" section="admin" action="addObjToRegistry"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/DB.png" alt="Сгенерировать" title="Генерация и регистрация нового идентификатора объекта" style="position: absolute; margin: 4px;" /></a>
    <table class="toolbarObjects" cellpadding="2" cellspacing="0">
        <tr class="toolbarObjectsTitle">
            <td style="width: 45px;" class="toolbarBorder">obj_id</td>
            <td class="toolbarBorder">секция</td>
            <td class="toolbarBorder">класс</td>
        </tr>
            {foreach from=$latestObjects item=latestObject}
                <tr onmouseover="this.style.backgroundColor = HOVER_BG_COLOR" onmouseout="this.style.backgroundColor = SECOND_BG_COLOR">
                    <td><a href="{url route="withId" section="access" id=$latestObject.obj_id action="editACL"}" class="jipLink">{$latestObject.obj_id}</a></td>
                    <td>{$latestObject.section_name}</td>
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
