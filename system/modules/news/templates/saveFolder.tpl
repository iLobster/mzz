<div class="jipTitle">{if $isEdit}{_ folder_editing}{else}{_ folder_creating}{/if}</div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="_ identifier"}
    </div>
    <div class="text">
        {form->text name="name" value=$folder->getName()}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('title', ' required')}{$validator->isFieldError('title', ' error')}">
    <div class="label">
        {form->caption name="title" value="_ title"}
    </div>
    <div class="text">
        {form->text name="title" value=$folder->getTitle() size="40"}
        <span class="caption error">{$validator->getFieldError('title')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>