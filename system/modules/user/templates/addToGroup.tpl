{if !isset($filter)}
    <div class="jipTitle">{_ add_user_to_group} <b>{$group->getName()}</b></div>
    <div style="padding: 15px;">
        <form action="{url}" id='filterForm' method="get" onsubmit="new Ajax.Updater('users', this.action, {literal}{'method': 'get', 'parameters': this.serialize(true)}{/literal}); return false;">
            {_ username}: <input type="text" value="" name="filter"> <input type="image" src="{$SITE_PATH}/templates/images/search.gif">
        </form>
    </div>
    <div id='users' style='padding: 15px;'>
    </div>
{else}
    {if not empty($too_much)}
        {_ refine_search}
    {else}
        <span style="font-size: 110%;">{_ search_result} ({$users|@count} {_ found})</span>
        <div style="border-top: 2px solid #BABABA; padding: 10px;">
            {set name="form_action"}{url}{/set}
            {form action=$form_action method="post" jip=true}
                <table border="0" width="100%" cellpadding="2" cellspacing="0" class="systemTable">
                    {foreach from=$users item=user}
                        <tr>
                            <td align="center" width="10px">{$user->getId()}</td>
                            <td width="20px" align="center"><input type="checkbox" name="users[{$user->getId()}]" id="users_{$user->getId()}" value="1" /></td>
                            <td><label for="users_{$user->getId()}">{$user->getLogin()}</label></td>
                        </tr>
                    {/foreach}
                    <tr>
                        <td colspan="3"><input type="submit" value="{_ simple/add}"{if $users|@count eq 0} disabled="disabled"{/if}> <input type="reset" value="{_ simple/cancel}" onclick="javascript: jipWindow.close();"></td>
                    </tr>
                </table>
            </form>
        </div>
    {/if}
{/if}