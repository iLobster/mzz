{include file='jipTitle.tpl' title="����������� ��������"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>����������� ��������: <strong>"{$folder->getTitle()}"</strong> �� <em>{$folder->getPath()}</em></td>
        </tr>
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="� �������:"}</td>
        </tr>
        <tr>
            <td style='width: 80%;'>{form->select name="dest" options=$dests styles=$styles size=10 style="width: 80%;" value=$folder->getTreeParent()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>