{assign var="path" value=$page->getFolder()->getPath()}
{assign var="name" value=$page->getTitle()}
{include file='jipTitle.tpl' title="����������� �������� '$name' �� �������� '$path'"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="dest" value="������� ����������"}</td>
            <td>{form->select name="dest" options=$dests size=5 value=$page->getFolder()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>