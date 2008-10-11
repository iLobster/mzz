<div class="jipTitle">Перемещение {if $isMass}элементов{else}элемента <em>{$item->getName()}</em>{/if} из каталога {$folder->getTitle()} ({$folder->getPath()})</div>
{form action=$form_action method="post" jip=true}
{if $isMass}
{foreach from=$items item="item"}
    {assign var="item_id" value=$item->getId()}
    {form->hidden name="items[$item_id]" value=""}
{/foreach}
{/if}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 20%; vertical-align: top;">Перемещение {if $isMass}элементов{else}элемента <em>{$item->getName()}</em>{/if} из каталога {$folder->getTitle()} ({$folder->getPath()})</td>
        </tr>
        <tr>
            <td style="width: 20%; vertical-align: top;">{form->caption name="dest" value="В каталог:"}</td>
        </tr>
        <tr>
            <td style="width: 80%;">{form->select name="dest" options=$dests styles=$styles size=10 style="width: 80%;" value=$folder->getId()}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>