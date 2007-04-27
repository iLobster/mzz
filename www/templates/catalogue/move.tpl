{assign var="path" value=''}
{*$news->getFolder()->getPath()*}
<div class="jipTitle">Перемещение элемента из каталога '{$path}'</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
{foreach from=$items item="item"}<input type="hidden" name="items[{$item}]">{/foreach}
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="dest" value="Каталог назначения:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</td>
            <td>{form->select name="dest" options=$select size="5"}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit name="submit" value="Сохранить"}{form->reset onclick="javascript: jipWindow.close();" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>