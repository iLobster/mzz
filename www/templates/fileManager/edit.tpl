{assign var="path" value=$file->getFolder()->getPath()}
{assign var="name" value=$file->getName()}
{include file='jipTitle.tpl' title="�������������� ����� `$path`/`$name`"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="name" value="����� ���"}</td>
            <td>{form->text name="name" value=$file->getName()}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>