<div class="pageTitle">{if $userFolder->getAcl('admin')}<a href="{url route="withAnyParam" section='admin' name="user" action="admin"}">Пользователи</a> / {/if}<strong>Группы</strong>{$groupFolder->getJip()}</div>

<div class="pageContent">
<table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">ID:</td>
                <td style="text-align: left;">Имя:</td>
                <td style="width: 200px;">Пользователей в группе:</td>
                <td style="width: 100px;">is default:</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
    {foreach from=$groups item="group"}
        <tr>
            <td style="text-align: center;">{$group->getId()}</td>
            <td>{$group->getName()}</td>
            <td style="text-align: center;">{$group->getUsersCount()}</td>
            <td style="text-align: center;">{if $group->getIsDefault()}Да{else}Нет{/if}</td>
            <td style="text-align: center;">{$group->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="tableListFoot">
        <td colspan="3">{$pager->toString('adminPager.tpl')}</td>
        <td colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>
</div>