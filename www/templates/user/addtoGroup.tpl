{if empty($filter)}
    <div class="jipTitle">Добавление пользователей в группу <b>{$group->getName()}</b></div>
    <div style="padding: 15px;">
        <form action="{url}" id='filterForm' method="get" onsubmit="return jipWindow.openIn(this.action, 'users', 'GET', this.serialize(true));">
            Имя пользователя: <input type="text" value="{$filter}" name="filter"> <input type="image" src="{$SITE_PATH}/templates/images/search.gif">
        </form>
    </div>
    <div id='users' style='padding: 15px;'>
    </div>
{else}
    <span style="font-size: 110%;">Результат поиска (найдено: {$users|@count})</span>
    <div style="border-top: 2px solid #BABABA; padding: 10px;">
        <form method="post" action="{url}" onsubmit="return mzzAjax.sendForm(this);">
            <table border="0" width="100%" cellpadding="2" cellspacing="0" class="list">
                {foreach from=$users item=user}
                    <tr>
                        <td align="center" width="10px">{$user->getId()}</td>
                        <td width="20px" align="center"><input type="checkbox" name="users[{$user->getId()}]" value="1" /></td>
                        <td>{$user->getLogin()}</td>
                    </tr>
                {/foreach}
                <tr>
                    <td colspan="3"><input type="submit" value="Добавить"{if $users|@count eq 0} disabled="disabled"{/if}> <input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
                </tr>
            </table>
        </form>
    </div>
{/if}