<div class="jipTitle">Конфигурация для модуля "{if $folder->getTitle()}{$folder->getTitle()|h}{else}{$folder->getName()|h}{/if}"</div>
{form action=$form_action method="post" jip=true}
    <table width="99%" cellpadding="4" cellspacing="0">
        {foreach from=$options item="option"}
        {assign var="optionName" value=$option->getName()}
        {if $option->getType() == "configOption::TYPE_BOOL"|@constant}
        <tr>
            <th>{form->caption name=$optionName value=$option->getTitle()}</th>
            <td>{form->checkbox name=$optionName value=$option->getValue()} {$errors->get($optionName)}</th>
        </tr>
        {else}
        <tr>
            <th>{form->caption name=$optionName value=$option->getTitle()}</th>
            <td>{form->text name=$optionName value=$option->getValue()} {$errors->get($optionName)}</th>
        </tr>
        {/if}
        {/foreach}
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>