<div class="jipTitle">Перемещение каталога: <strong>"{$folder->getTitle()}"</strong>({$folder->getTreePath()})</div>
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>Перемещение каталога: <strong>"{$folder->getTitle()}"</strong>({$folder->getTreePath()}) из <em>{$folder->getTreeParent()->getTitle()}</em>({$folder->getTreeParent()->getTreePath()})</td>
        </tr>
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="В каталог:"}</td>
        </tr>
        <tr>
            <td style='width: 80%;'>{form->select name="dest" options=$dests size=10 style="width: 80%;" value=$folder->getTreeParent()->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>