<div class="jipTitle">Список действий класса <i>{$class_name|h}</i> модуля <i>{$module->getTitle()|h}</i></div>

<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td colspan="3"><a href="{url route="adminModuleEntity" module_name=$module->getName() class_name=$class_name action="addAction"}" class="mzz-jip-link">Создать действие</a></td>
    </tr>
    {foreach from=$actions key="name" item="action"}
        <tr>
            <td>{if $action->getIcon()}{icon sprite=$action->getIcon() active=true}{/if}</td>
            <td width="25%">{$name|h}</td>
            <td width="60%">{if $action->getTitle()}{$action->getTitle()|h}{else}<span style="color: #999;">названия нет</span>{/if}</td>
            <td style="width: 15%; text-align: right;">
                <a href="{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="editAction"}" class="mzz-jip-link" title="Редактировать действие"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-edit"></span></span></a>
                <a href="{url route="adminModuleEntity" module="admin" module_name=$module->getName() class_name=$name action="deleteAction"}" class="mzz-jip-link" title="Удалить действие"><span class="mzz-icon mzz-icon-script"><span class="mzz-bullet mzz-bullet-del"></span></span></a>
            </td>
        </tr>
    {/foreach}
</table>