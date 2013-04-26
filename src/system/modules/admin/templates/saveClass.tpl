<div class="jipTitle">{if $isEdit}{_ class.editing}{else}{_ class.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form clearfix"}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="_ class.name"}
    </div>
    <div class="text">
        {if $isEdit}{$data.tableName}{else}{form->text name="name" value=$data.className}{/if}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('table', ' required')}{$validator->isFieldError('table', ' error')}">
    <div class="label">
{form->caption name="table" value="_ class.table_name"}
    </div>
    <div class="text">
        {if $isEdit}{$data.tableName}{else}{form->text name="table" value=$data.tableName}{/if}
        <span class="caption error">{$validator->getFieldError('table')}</span>
    </div>
</div>
<div class="field">
    <div class="label{$validator->isFieldRequired('dest', ' required')}{$validator->isFieldError('dest', ' error')}">
        {form->caption name="dest" value="_ dest"}
    </div>
    <div class="text">
        {form->select name="dest" options=$dests one_item_freeze=1 value=app}
        <span class="caption error">{$validator->getFieldError('dest')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>