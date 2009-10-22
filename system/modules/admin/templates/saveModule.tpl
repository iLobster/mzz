<div class="jipTitle">{if $isEdit}{_ module.editing}{else}{_ module.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('name', 'required')} {$validator->isFieldError('name', 'error')}">
            {form->caption name="name" value="_ module.name"}
            <span class="input">{if $isEdit}{$module->getName()|h}{else}{form->text name="name" size="30"}{/if}</span>
            {if $validator->isFieldError('name')}<div class="error">{$validator->getFieldError('name')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('dest', 'required')} {$validator->isFieldError('dest', 'error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{if $isEdit}{$currentDestination|h}{else}{form->select name="dest" options=$dests one_item_freeze=1 value=$currentDestination}{/if}
            </span>
            {if $validator->isFieldError('dest')}<div class="error">{$validator->getFieldError('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>