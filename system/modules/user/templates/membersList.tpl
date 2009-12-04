<div class="jipTitle">{_ users_in_group $group->getName()}</div>
{form action={url} method="post" jip=true}
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
            <tr>
                <td colspan="2">{_ no_users_in_group}</td>
            </tr>
        {/if}
        <tr>
            <td colspan="2"><a href="{url route=withAnyParam module=user action=addToGroup name=$group->getId()}" class="mzz-jip-link" title="{_ add_user_to_group}"><span class="mzz-icon mzz-icon-user-add"></span> {_ add_user_to_group}</a></td>
        </tr>
    </table>
</form>