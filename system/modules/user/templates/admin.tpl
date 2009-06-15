<div class="title">Пользователи {$userFolder->getJip()}</div>
<table class="admin">
        <thead>
            <tr class="first center">
                <th class="first" style="width: 30px;">ID:</th>
                <th class="left">Login:</th>
                <th style="width: 120px;">Active</th>
                <th style="width: 120px;">IP</th>
                <th style="width: 120px;">Создан:</th>
                <th style="width: 120px;">Last login</th>
                <th class="last" style="width: 30px;">JIP</th>
            </tr>
        </thead>
    {foreach from=$users item="user"}
        <tr class="center">
            <td class="first">{$user->getId()}</td>
            <td class="left">{$user->getLogin()|h}</td>
            <td>{if $user->isActive()}Да{else}Нет{/if}</td>
            <td>{if $user->isActive()}{$user->getOnline()->getIp()}{else}—{/if}</td>
            <td>{$user->getCreated()|date_i18n:relative_hour}</td>
            <td>{$user->getLastLogin()|date_i18n:relative_hour}</td>
            <td class="last">{$user->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="last">
        <td class="first"></td>
        <td colspan="4">{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last" colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>