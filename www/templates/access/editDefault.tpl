{add file="popup.js"}
{add file="confirm.js"}
{include file='jipTitle.tpl' title="����� �� ���������. ������: <b>$section</b>, �����: <b>$class</b>."}

<p>������������</p>
<table border="0" width="99%" cellpadding="5" cellspacing="1" class="list">
    <tr>
        <td align="center">0</td>
        <td><a href="{url section=access action=editOwner params="$section/$class"}" onClick="return showJip(this.href);">�������� �������</a></td>
        <td>&nbsp;</td>
    </tr>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUserDefault params="$section/$class/$user_id"}" onClick="return showJip(this.href);">{$user->getLogin()}</a></td>
            <td><a href="{url section=access action=deleteUserDefault params="$section/$class/$user_id"}" onClick="return mzz_confirm('�� ������ ������� ����� ������������?') && showJip(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="return showJip(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="return showJip(this.href);">�������� ������������</a></td>
        </tr>
    {/if}
</table>
<p>������</p>
<table border="0" width="99%" cellpadding="0" cellspacing="1" class="list">
     {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroupDefault params="$section/$class/$group_id"}" onClick="return showJip(this.href);">{$group->getName()}</a></td>
            <td><a href="{url section=access action=deleteGroupDefault params="$section/$class/$group_id"}" onClick="mzz_confirm('�� ������ ������� ��� ������?') && showJip(this.href); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="return showJip(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="return showJip(this.href);">�������� ������</a></td>
        </tr>
    {/if}
</table>