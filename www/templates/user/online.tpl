{if not empty($guests)}Гостей он-лайн: <b>{$guests}</b><br />{/if}
{if sizeof($users)}
    Зарегистрированные пользователи (<b>{$users|@sizeof}</b>):

    {foreach from=$users item=user name="online"}
        <b>{$user->getUser()->getLogin()}</b>{if $user->fakeField('cnt') > 1} (<b>{$user->fakeField('cnt')}</b>){/if}{if not $smarty.foreach.online.last}, {/if}
    {/foreach}
{/if}