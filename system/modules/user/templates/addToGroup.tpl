{if !isset($filter)}
    <div class="jipTitle">���������� ������������� � ������ <b>{$group->getName()}</b></div>
    <div style="padding: 15px;">
        <form action="{url}" id='filterForm' method="get" onsubmit="new Ajax.Updater('users', this.action, {literal}{'method': 'get', 'parameters': this.serialize(true)}{/literal}); return false;">
            ��� ������������: <input type="text" value="" name="filter"> <input type="image" src="{$SITE_PATH}/templates/images/search.gif">
        </form>
    </div>
    <div id='users' style='padding: 15px;'>
    </div>
{else}
    {if not empty($too_much)}
        ������� ������� ����� ����������. �������� ������.
    {else}
        <span style="font-size: 110%;">��������� ������ (�������: {$users|@count})</span>
        <div style="border-top: 2px solid #BABABA; padding: 10px;">
            <form method="post" action="{url}" onsubmit="return jipWindow.sendForm(this);">
                <table border="0" width="100%" cellpadding="2" cellspacing="0" class="systemTable">
                    {foreach from=$users item=user}
                        <tr>
                            <td align="center" width="10px">{$user->getId()}</td>
                            <td width="20px" align="center"><input type="checkbox" name="users[{$user->getId()}]" value="1" /></td>
                            <td>{$user->getLogin()}</td>
                        </tr>
                    {/foreach}
                    <tr>
                        <td colspan="3"><input type="submit" value="��������"{if $users|@count eq 0} disabled="disabled"{/if}> <input type="reset" value="������" onclick="javascript: jipWindow.close();"></td>
                    </tr>
                </table>
            </form>
        </div>
    {/if}
{/if}