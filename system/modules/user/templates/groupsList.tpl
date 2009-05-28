<div class="title">Группы {$groupFolder->getJip()}</div>
<table class="admin">
        <thead>
            <tr class="first center">
                <th class="first" style="width: 30px;">ID:</th>
                <th class="left">Имя:</th>
                <th style="width: 200px;">Пользователей в группе:</th>
                <th style="width: 100px;">is default:</th>
                <th class="last" style="width: 30px;">JIP</th>
            </tr>
        </thead>
    {foreach from=$groups item="group"}
        <tr class="center">
            <td class="first">{$group->getId()}</td>
            <td class="left">{$group->getName()}</td>
            <td>{$group->getUsers()->count()}</td>
            <td>{if $group->getIsDefault()}Да{else}Нет{/if}</td>
            <td class="last">{$group->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="last">
        <td class="first"></td>
        <td colspan="2">{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last" colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>