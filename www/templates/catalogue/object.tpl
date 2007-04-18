<div class="jipTitle">Редактирование</div>
<form action="{$action}" method="post" onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>Имя:</td> 
            <td>{form->text name="name" size="60" value=$catalogue->getName()}{$errors->get('name')}</td>
        <tr>
        {include file="catalogue/properties.tpl" data=$catalogue->exportOldProperties()}
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>