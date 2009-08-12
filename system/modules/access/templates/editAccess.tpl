{assign var=title value="Права доступа на модуль '`$module.title`'"}
{include file='jipTitle.tpl' title=$title}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=aclAccessDefaults module_name=$module.name action=addAccessUser}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url route=aclAccessDefaultsEdit action=editAccessUser module_name=$module.name user_id=$user->getId()}" class="mzz-jip-link">{$user->getLogin()}</a></td>
            <td style="text-align: right;"><a href="{url route=aclAccessDefaultsEdit action=deleteAccessUser module_name=$module.name user_id=$user->getId()}" class="mzz-jip-link" title="Удалить пользователя"><span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
        </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=aclAccessDefaults action=addAccessGroup module_name=$module.name}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=aclAccessDefaultsEdit action=editAccessGroup module_name=$module.name user_id=$group->getId()}" class="mzz-jip-link">{$group->getName()}</a></td>
            <td style="text-align: right;"><a href="{url route=aclAccessDefaultsEdit action=deleteAccessGroup module_name=$module.name user_id=$group->getId()}" class="mzz-jip-link" title="Удалить группу"><span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
        </tr>
    {/foreach}
</table>
