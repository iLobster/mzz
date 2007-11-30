{if $isEdit}
{include file='jipTitle.tpl' title='Редактирование раздела'}
{else}
{include file='jipTitle.tpl' title='Добавление раздела'}
{/if}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 30%;">{form->caption name="name" value="Имя"}</td>
        <td style="width: 70%;">{if $nameRO}
            {$data.name}
        {else}
            {form->text name="name" size="30" value=$data.name}{$errors->get('name')}
        {/if}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="title" value="Название"}</td>
            <td style="width: 70%;">{form->text name="title" size="30" value=$data.title}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="order" value="Порядок сортировки"}</td>
            <td style="width: 70%;">{form->text name="order" size="30" value=$data.order}{$errors->get('order')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>