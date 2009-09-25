<div class="jipTitle">{if $isEdit}{_ module.editing}{else}{_ module.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name','required')} {$form->error('name','error')}">
            {form->caption name="name" value="_ module.name"}
            <span class="input">{if $isEdit}{$module->getName()|h}{else}{form->text name="name" size="30"}{/if}</span>
            {if $errors->exists('name')}<div class="error">{$errors->get('name')}</div>{/if}
        </li>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{if $isEdit}{$currentDestination|h}{else}{form->select name="dest" options=$dests one_item_freeze=1 value=$currentDestination}{/if}
            </span>
            {if $errors->exists('dest')}<div class="error">{$errors->get('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>