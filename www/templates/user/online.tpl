{if not empty($guests)}������ ��-����: <b>{$guests}</b><br />{/if}
{if sizeof($users)}
    ������������������ ������������ (<b>{$users|@sizeof}</b>):

    {foreach from=$users item=user name="online"}
        <b>{$user->getUser()->getLogin()}</b>{if not $smarty.foreach.online.last}, {/if}
    {/foreach}
{/if}