<div class="jipTitle">{if $isEdit}�������������� ��������� {$category->getTitle()}{else}�������� ���������{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="name" value="���:"}</td>
            <td>{form->text name="name" size="60" value=$category->getName()}{$errors->get('name')}</td>
        <tr>
        <tr>
            <td>{form->caption name="title" value="���������:"}</td>
            <td>{form->text name="title" size="60" value=$category->getTitle()}{$errors->get('title')}</td>
        <tr>
        <tr>
            <td style="text-align:left;">{form->submit name="submit" value="���������"} {form->reset jip="true" name="reset" value="������"}</td>
        </tr>
    </table>
</form>