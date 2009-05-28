{set name="title"}{_ users_in_group $group->getName()}{/set}
{include file='jipTitle.tpl' title=$title}
{set name="form_action"}{url}{/set}
{form action=$form_action method="post" jip=true}
    <table border="0" width="50%" cellpadding="4" cellspacing="1" class="systemTable">
        <tr>
            <td align="center"><strong>ID</strong></td>
            <td width="100%"><strong>{_ username}</strong></td>
        </tr>
        {foreach from=$users item="user" key=user_id}
            <tr>
                <td align="center">{$user->getId()}</td>
                <td width="100%">{form->checkbox name="users[$user_id]" label=$user->getLogin() nodefault=1}</td>
            </tr>
        {/foreach}
        {if sizeof($users)}
            <tr>
                <td>{form->submit name="submit" value="_ simple/delete"}</td>
                <td>{form->reset value="_ simple/reset" jip=true}</td>
            </tr>
        {else}
            {_ no_users_in_group}
        {/if}
        <tr>
            <td colspan="2"><a href="{url route=withAnyParam section=user action=addToGroup name=$group->getId()}" class="jipLink" title="{_ add_user_to_group}"><span class="mzz-icon mzz-icon-user-add"></span> {_ add_user_to_group}</a></td>
        </tr>
    </table>
</form>