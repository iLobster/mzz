<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
Изменение прав на объект ... {if $users === false}для пользователя <code>{$user->getLogin()}</code>{/if}
</div>

<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="list">
            {if $users !== false}
                Выберите пользователя
                <select name="user_id">
                    <option value="-1" selected="selected"></option>
                    {foreach from=$users item=user}
                        <option value="{$user->getId()}">{$user->getLogin()}</option>
                    {/foreach}
                </select>
            {/if}
            {include file="access/checkboxes.tpl" actions=$actions adding=$users}
    </table>
</form>