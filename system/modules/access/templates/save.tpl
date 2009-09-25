{include file='jipTitle.tpl' title='Редактирование ролей'}

{form action=$form_action method="post" jip=true}
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
        {if not empty($groups)}
            <tr>
                <td colspan="2">
                    Выберите группу: {form->select name=group_id options=$groups valueMethod=getName keyMethod=getId emptyFirst=""}
                </td>
            </tr>
        {/if}
        {include file="access/checkboxes.tpl" roles=$roles current_roles=$current_roles}
    </table>
<form>