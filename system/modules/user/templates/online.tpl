{if not empty($guests)}Гостей он-лайн: <b>{$guests}</b><br />{/if}
{if sizeof($users)}
    Зарегистрированные пользователи (<b>{$total}</b>):

    {if sizeof($users)}
        <table border="1" width="100%">
            <tr>
                <td>логин</td>
                <td>урл</td>
                <td>время</td>
                <td>ip</td>
            </tr>
            {foreach from=$users item=user name="online"}
                <tr>
                    <td>{$user->getUser()->getLogin()}{if $user->fakeField('cnt') > 1} ({$user->fakeField('cnt')}){/if}</td>
                    <td><a href="{$user->getUrl()}">{$user->getUrl()}</a></td>
                    <td>{$user->getLastActivity()}</td>
                    <td>{$user->getIp()}</td>
                </tr>
            {/foreach}
        </table>
    {/if}
{/if}