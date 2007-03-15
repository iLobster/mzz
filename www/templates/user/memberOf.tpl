{assign var=name value=$user->getLogin()}
{include file='jipTitle.tpl' title="Список групп, в которые входит пользователь $name"}
<form method="post" action="{url}" onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" width="50%" cellpadding="4" cellspacing="1" class="list">
        {foreach from=$groups item=group}
            <tr>
                <td align="center" width="10%">{$group->getId()}</td>
                {assign var="group_id" value=$group->getId()}
                <td width="10%" align="center"><input type="checkbox" name="groups[{$group->getId()}]" value="1" {if isset($selected.$group_id)}checked="checked"{/if}></td>
                <td width="80%">{$group->getName()}</td>
                {*<td>{$group->getJip()}</td> *}
            </tr>
        {/foreach}
            <tr>
                <td><input type="submit" value="Сохранить"></td>
                <td colspan="2"><input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
            </tr>
    </table>
</form>