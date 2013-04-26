{assign var="path" value=$file->getFolder()->getTreePath()}
{assign var="name" value=$file->getName()}
{include file='jipTitle.tpl' title="Редактирование файла `$path`/`$name`"}
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="Новое имя"}
    </div>
    <div class="text">
        {form->text name="name" value=$file->getName()}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('about', ' required')}{$validator->isFieldError('about', ' error')}">
    <div class="label">
        {form->caption name="about" value="Описание"}
    </div>
    <div class="text">
        {form->textarea name="about" value=$file->getAbout() rows="7"}
        <span class="caption error">{$validator->getFieldError('about')}</span>
    </div>
</div>
<div class="field">
    <div class="text">
        {form->checkbox name="header" value=$file->getRightHeader()} {form->caption name="header" value="Отдавать с нужными заголовками"}
    </div>
</div>
<div class="field">
    <div class="text">
        {form->checkbox name="direct_link" value=$file->getDirectLink()} {form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>