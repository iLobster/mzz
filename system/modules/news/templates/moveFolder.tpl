{include file='jipTitle.tpl' title="Перемещение каталога"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'><strong>{$folder->getTitle()} ({$folder->getPath()})</strong> в:</td>
        </tr>
        <tr>
            <td style='width: 80%;'>{form->select name="dest" options=$dests size=10 style="width: 80%;" value=$folder->getTreeParent()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2">{form->submit name="submit" value="Переместить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>