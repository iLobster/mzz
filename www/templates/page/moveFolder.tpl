{assign var="path" value=$folder->getPath()}
{include file='jipTitle.tpl' title="Перемещение каталога `$path`"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="Каталог назначения"}</td>
            <td style='width: 80%;'>{form->select name="dest" options=$dests size=5 value=$folder->getTreeParent()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>