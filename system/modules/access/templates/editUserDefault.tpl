{if $users === false}
{assign var="userLogin" value=$user->getLogin()}
{include file='jipTitle.tpl' title="Изменение прав на объект типа <b>$class</b> для пользователя <b>$userLogin</b>"}
{else}
{include file='jipTitle.tpl' title="Изменение прав на объект типа <b>$class</b>"}
{/if}
{set name="form_action"}{url}{/set}
{form action=$form_action method="post" jip=true}
<table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
        <tr>
            <td colspan="3">
        {if $users !== false}
            Выберите пользователя
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$users item=user}
                    <option value="{$user->getId()}">{$user->getLogin()}</option>
                {/foreach}
            </select>
        {/if}</td>
        </tr>
        {include file="access/checkboxes.tpl" actions=$actions adding=$users}
</table>
</form>