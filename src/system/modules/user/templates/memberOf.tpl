{assign var=name value=$user->getLogin()}
{include file='jipTitle.tpl' title="Список групп, в которые входит пользователь $name"}
{form action=$form_action method="post" jip=true}
    <table border="0" width="50%" cellpadding="4" cellspacing="1" class="systemTable">
        {foreach from=$groups item=group}
            <tr>
                <td align="center" width="10%">{$group->getId()}</td>
                {assign var="group_id" value=$group->getId()}
                <td width="10%" align="center">{form->checkbox name="groups[$group_id]" value=$user->getGroups()->exists($group_id) nodefault=1}</td>
                <td width="80%">{$group->getName()}</td>
            </tr>
        {/foreach}
            <tr>
                <td>{form->submit name="submit" value="_ simple/save"}</td>
                <td colspan="2">{form->reset jip=true name="reset" value="_ simple/cancel"}</td>
            </tr>
    </table>
</form>