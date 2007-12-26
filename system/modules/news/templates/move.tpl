<div class="jipTitle">Перемещение элемента <em>'{$news->getTitle()}'</em></div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>{_ moving $news->getTitle() $news->getFolder()->getTitle() $news->getFolder()->getPath()}</td>
        </tr>
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="_ to_folder"}</td>
        </tr>
        <tr>
            <td style='width: 80%;'>{form->select name="dest" options=$dests size=10 style="width: 80%;" value=$news->getFolder()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>