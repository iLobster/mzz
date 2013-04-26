<div class="jipTitle">{if $isEdit}{_ module.editing}{else}{_ module.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="_ module.name"}
    </div>
    <div class="text">
        {if $isEdit}{$module->getName()|h}{else}{form->text name="name" size="30"}{/if}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('dest', ' required')}{$validator->isFieldError('dest', ' error')}">
    <div class="label">
        {form->caption name="dest" value="_ dest"}
    </div>
    <div class="text">
        {if $isEdit}{$currentDestination|h}{else}{form->select name="dest" options=$dests one_item_freeze=1 value=$currentDestination}{/if}
        <span class="caption error">{$validator->getFieldError('dest')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>