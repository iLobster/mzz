{foreach from=$mods item=module}
            {assign var=name value=$module->getName()}
            {assign var="count" value=$module->getActions()|@sizeof}
            <table id="module-{$name}" class="toolbar admin" cellspacing="0">
                <thead>
                    <tr class="first">
                        <th class="first name"><img src="{$SITE_PATH}/images/exp_{if isset($hiddenClasses.$name)}plus{else}minus{/if}.png" class="expandClose" onclick="devToolbar.toggleModule('{$name}', this);" width="16" height="16" alt="expand/close classes list" title="expand/collapse classes" />{$name}{if !$module->isEnabled()} <sup style="color: #CCCCCC">disabled</sup>{/if}</th>
                        <th class="last right">
                            <a href="{url route="withAnyParam" module="admin" name=$name action="config"}" class="mzz-jip-link" title="Редактировать конфигурацию">{icon sprite="sprite:admin/action/admin"}</a>
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
                        <td class="first name" colspan="2">--- классов нет ---</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        {/foreach}