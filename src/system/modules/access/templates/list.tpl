{include file='jipTitle.tpl' title='Роли'}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Группы{if $groups_left->count()} (<a href="{url route=accessEditRoles module_name=$module_name action=add}" class="mzz-jip-link">добавить {icon sprite="sprite:sys/group-add"}</a>){/if}</th>
    </tr>
        
    {foreach from=$roles item=role}
        <tr>
            <td><a href="{url route=accessEditModuleRoles module_name=$module_name group_id=$role->getGroup()->getId() action=edit}" class="mzz-jip-link">{$role->getGroup()->getName()}</a></td>
            <td style="text-align: right;"><a href="{url route=accessEditModuleRoles module_name=$module_name group_id=$role->getGroup()->getId() action=delete}" class="mzz-jip-link" title="Удалить группу">{icon sprite="sprite:sys/group-del"}</a></td>
        </tr>
    {/foreach}
</table>