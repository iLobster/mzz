{if $isEdit}
    {include file='jipTitle.tpl' title='admin/action.editing'|i18n}
{else}
    {include file='jipTitle.tpl' title='admin/action.adding'|i18n}
{/if}

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('dest', 'required')} {$validator->isFieldError('dest', 'error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{form->select name="dest" options=$dests one_item_freeze=1 value=app}</span>
            {if $validator->isFieldError('dest')}<div class="error">{$validator->getFieldError('dest')}</div>{/if}
        </li>
        {if $isEdit}
        <li>
            {form->caption name="action[name]" value="_ action.name"}
            <span class="input">{$actionData.name|h}</span>
        </li>
        <li>
            {form->caption name="action[controller]" value="_ action.controller"}
            <span class="input">{$actionData.controllerName|h}</span>
        </li>
        {else}
        <li class="{$validator->isFieldRequired('action[name]', 'required')} {$validator->isFieldError('action[name]', 'error')}">
            {form->caption name="action[name]" value="_ action.name"}
            <span class="input">{form->text name="action[name]" size="30" value=$actionData.name}</span>
            {if $validator->isFieldError('action[name]')}<div class="error">{$validator->getFieldError('action[name]')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('action[controller]', 'required')} {$validator->isFieldError('action[controller]', 'error')}">
            {form->caption name="action[controller]" value="_ action.controller"}
            <span class="input">{form->text name="action[controller]" size="30" value=$actionData.controllerName}</span>
            {if $validator->isFieldError('action[controller]')}<div class="error">{$validator->getFieldError('action[controller]')}</div>{/if}
        </li>
        {/if}
        <li class="{$validator->isFieldRequired('action[title]', 'required')} {$validator->isFieldError('action[title]', 'error')}">
            {form->caption name="action[title]" value="Заголовок"}
            <span class="input">{form->text name="action[title]" size="30" value=$actionData.title}</span>
            {if $validator->isFieldError('action[title]')}<div class="error">{$validator->getFieldError('action[title]')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('action[confirm]', 'required')} {$validator->isFieldError('action[confirm]', 'error')}">
            {form->caption name="action[confirm]" value="_ action.confirm"}
            <span class="input">{form->text name="action[confirm]" size="30" value=$actionData.confirm}</span>
            {if $validator->isFieldError('action[confirm]')}<div class="error">{$validator->getFieldError('action[confirm]')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('action[main]', 'required')} {$validator->isFieldError('action[main]', 'error')}">
            {form->caption name="action[main]" value="_ action.main"}
            <span class="input">{form->text name="action[main]" size="30" value=$actionData.activeTemplate}</span>
            {if $validator->isFieldError('action[main]')}<div class="error">{$validator->getFieldError('action[main]')}</div>{/if}
        </li>

        {if $moduleClassMapper->isAttached('jip')}
        <li class="{$validator->isFieldRequired('action[jip]', 'required')} {$validator->isFieldError('action[jip]', 'error')}">
            {form->caption name="action[jip]" value="Добавить в JIP"}
            <span class="input">{form->checkbox name="action[jip]" value=$actionData.jip}</span>
            {if $validator->isFieldError('action[jip]')}<div class="error">{$validator->getFieldError('action[jip]')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('action[icon]', 'required')} {$validator->isFieldError('action[icon]', 'error')}">
            {form->caption name="action[icon]" value="Иконка для JIP"}
            <span class="input">{form->text name="action[icon]" size="30" value=$actionData.icon}</span>
            {if $validator->isFieldError('action[icon]')}<div class="error">{$validator->getFieldError('action[icon]')}</div>{/if}
        </li>
        {/if}

        {if !$isEdit}
        <li class="{$validator->isFieldRequired('action[crud]', 'required')} {$validator->isFieldError('action[crud]', 'error')}">
            {form->caption name="action[crud]" value="CRUD"}
            <span class="input">{form->select name="action[crud]" onchange="if(jQuery(this).val() == 'save') { jQuery('#crud_class_box').show(); } else { jQuery('#crud_class_box').hide(); }" options=$crudList emptyFirst="none"}
            {if $validator->isFieldError('action[crud]')}<div class="error">{$validator->getFieldError('action[crud]')}</div>{/if}
        </li>
        <li style="display: none;" id="crud_class_box" class="{$validator->isFieldRequired('action[crud_class]', 'required')} {$validator->isFieldError('action[crud_class]', 'error')}">
            {form->caption name="action[crud_class]" value="CRUD class"}
            <span class="input">{form->select name="action[crud_class]" value=$class_name options=$classes}</span>
            {if $validator->isFieldError('action[crud_class]')}<span class="error">{$validator->getFieldError('action[crud_class]')}</span>{/if}
        </li>
        {/if}
    </ul
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>
<script type="text/javascript">
if(jQuery('#formElm_action_crud').val() == 'save') jQuery('#crud_class_box').show();
</script>