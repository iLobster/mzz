{assign var="path" value=$folder->getPath()}
{include file='jipTitle.tpl' title="����������� �������� `$path`"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="������� ����������"}</td>
            <td style='width: 80%;'>{form->select name="dest" options=$dests size=5 value=$folder->getTreeParent()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>