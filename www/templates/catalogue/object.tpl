<div class="jipTitle">��������������</div>
<form action="{$action}" method="post" onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>���:</td> 
            <td>{form->text name="name" size="60" value=$catalogue->getName()}{$errors->get('name')}</td>
        <tr>
        {include file="catalogue/properties.tpl" data=$catalogue->exportOldProperties()}
        <tr>
            <td>{form->submit name="submit" value="���������"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="������"}</td>
        </tr>
    </table>
</form>