{if $isEdit}
    {include file='jipTitle.tpl' title='admin/action.editing'|i18n}
{else}
    {include file='jipTitle.tpl' title='admin/action.adding'|i18n}
{/if}

{form action=$form_action method="post" jip=true class="mzz-jip-form"}

<div class="field{$validator->isFieldRequired('dest', ' required')}{$validator->isFieldError('dest', ' error')}">
    <div class="label">
        {form->caption name="dest" value="_ dest"}
    </div>
    <div class="text">
        {form->select name="dest" options=$dests one_item_freeze=1 value=app}
        <span class="caption error">{$validator->getFieldError('dest')}</span>
    </div>
</div>

{if $isEdit}
<div class="field">
    <div class="label">
        {form->caption name="action[name]" value="_ action.name"}
    </div>
    <div class="text">
        {$actionData.name|h}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="label">
        {form->caption name="action[controller]" value="_ action.controller"}
    </div>
    <div class="text">
        {$actionData.controllerName|h}
        <span class="caption error"></span>
    </div>
</div>
{else}
<div class="field{$validator->isFieldRequired('action[name]', ' required')}{$validator->isFieldError('action[name]', ' error')}">
    <div class="label">
        {form->caption name="action[name]" value="_ action.name"}
    </div>
    <div class="text">
        {form->text name="action[name]" size="30" value=$actionData.name}
        <span class="caption error">{$validator->getFieldError('action[name]')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('action[controller]', ' required')}{$validator->isFieldError('action[controller]', ' error')}">
    <div class="label">
        {form->caption name="action[controller]" value="_ action.controller"}
    </div>
    <div class="text">
        {form->text name="action[controller]" size="30" value=$actionData.controllerName}
        <span class="caption error">{$validator->getFieldError('action[controller]')}</span>
    </div>
</div>
{/if}

<div class="field{$validator->isFieldRequired('action[title]', ' required')}{$validator->isFieldError('action[title]', ' error')}">
    <div class="label">
        {form->caption name="action[title]" value="Заголовок"}
    </div>
    <div class="text">
        {form->text name="action[title]" size="30" value=$actionData.title}
        <span class="caption error">{$validator->getFieldError('action[title]')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('action[confirm]', ' required')}{$validator->isFieldError('action[confirm]', ' error')}">
    <div class="label">
        {form->caption name="action[confirm]" value="_ action.confirm"}
    </div>
    <div class="text">
        {form->text name="action[confirm]" size="30" value=$actionData.confirm}
        <span class="caption error">{$validator->getFieldError('action[confirm]')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('action[main]', ' required')}{$validator->isFieldError('action[main]', ' error')}">
    <div class="label">
        {form->caption name="action[main]" value="_ action.main"}
    </div>
    <div class="text">
        {form->text name="action[main]" size="30" value=$actionData.activeTemplate}
        <span class="caption error">{$validator->getFieldError('action[main]')}</span>
    </div>
</div>

{if $moduleClassMapper->isAttached('jip')}
<div class="field{$validator->isFieldRequired('action[jip]', ' required')}{$validator->isFieldError('action[jip]', ' error')}">
    <div class="label">
        {form->caption name="action[jip]" value="Добавить в JIP"}
    </div>
    <div class="text">
        {form->checkbox name="action[jip]" value=$actionData.jip}
        <span class="caption error">{$validator->getFieldError('action[jip]')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('action[icon]', ' required')}{$validator->isFieldError('action[icon]', ' error')}">
    <div class="label">
        {form->caption name="action[icon]" value="Иконка для JIP"}
    </div>
    <div class="text">
        {form->text name="action[icon]" size="30" value=$actionData.icon}
        <span class="caption">путь до картинки или sprite:&lt;set-name&gt;/&lt;icon-name&gt;[/&lt;module-name&gt;]</span>
        <span class="caption error">{$validator->getFieldError('action[icon]')}</span>
    </div>
</div>
{/if}

{if !$isEdit}
<div class="field{$validator->isFieldRequired('action[crud]', ' required')}{$validator->isFieldError('action[crud]', ' error')}">
    <div class="label">
        {form->caption name="action[crud]" value="CRUD"}
    </div>
    <div class="text">
        {form->select name="action[crud]" onchange="if(jQuery(this).val() == 'save') { jQuery('#crud_class_box').show(); } else { jQuery('#crud_class_box').hide(); }" options=$crudList emptyFirst="none"}
        <span class="caption error">{$validator->getFieldError('action[crud]')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('action[crud_class]', ' required')}{$validator->isFieldError('action[crud_class]', ' error')}" style="display: none;">
    <div class="label">
        {form->caption name="action[crud_class]" value="CRUD class"}
    </div>
    <div class="text">
        {form->select name="action[crud_class]" value=$class_name options=$classes}
        <span class="caption error">{$validator->getFieldError('action[crud_class]')}</span>
    </div>
</div>
{/if}

<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>
<script type="text/javascript">
if(jQuery('#formElm_action_crud').val() == 'save') jQuery('#crud_class_box').show();
</script>