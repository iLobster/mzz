<div class="jipTitle">����������� {if $isMass}���������{else}�������� <em>{$item->getName()}</em>{/if} �� �������� {$folder->getTitle()} ({$folder->getPath()})</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
{foreach from=$items item="item_id"}{form->hidden name="items[$item_id]"}{/foreach}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%; vertical-align: top;'>����������� {if $isMass}���������{else}�������� <em>{$item->getName()}</em>{/if} �� �������� {$folder->getTitle()} ({$folder->getPath()})</td>
        </tr>
        <tr>
            <td style='width: 20%; vertical-align: top;'>{form->caption name="dest" value="� �������:"}</td>
        </tr>
        <tr>
            <td style='width: 80%;'>{form->select name="dest" options=$dests styles=$styles size=10 style="width: 80%;" value=$folder->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>