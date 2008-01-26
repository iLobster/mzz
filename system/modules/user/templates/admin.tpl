<div class="pageTitle"><strong>Пользователи</strong>{$userFolder->getJip()}{if $groupFolder->getAcl('groupsList')} / <a href="{url route="default2" section=$section_name action="groupsList"}">Группы</a>{/if}</div>

<div class="pageContent">
<table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">ID:</td>
                <td style="text-align: left;">Login:</td>
                <td style="width: 120px;">Active</td>
                <td style="width: 120px;">IP</td>
                <td style="width: 120px;">Создан:</td>
                <td style="width: 120px;">Last login</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
    {foreach from=$users item="user"}
        <tr>
            <td style="text-align: center;">{$user->getId()}</td>
            <td>{$user->getLogin()}</td>
            <td style="text-align: center;">{if $user->isActive()}Да{else}Нет{/if}</td>
            <td style="text-align: center;">{if $user->isActive()}{$user->getOnline()->getIp()}{else}—{/if}</td>
            <td style="text-align: center;">{$user->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td style="text-align: center;">{$user->getLastLogin()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td style="text-align: center;">{$user->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="tableListFoot">
        <td colspan="3">{$pager->toString('adminPager.tpl')}</td>
        <td colspan="3" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>
</div>