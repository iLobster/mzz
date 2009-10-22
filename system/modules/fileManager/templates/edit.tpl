{assign var="path" value=$file->getFolder()->getTreePath()}
{assign var="name" value=$file->getName()}
{include file='jipTitle.tpl' title="Редактирование файла `$path`/`$name`"}
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('name', 'required')} {$validator->isFieldError('name', 'error')}">
            {form->caption name="name" value="Новое имя"}
            <span class="input">{form->text name="name" value=$file->getName() style="width: 100%"}</span>
            {if $validator->isFieldError('name')}<span class="error">{$validator->getFieldError('name')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('about', 'required')} {$validator->isFieldError('about', 'error')}">
            {form->caption name="about" value="Описание"}
            <span class="input">{form->textarea name="about" value=$file->getAbout() rows="7" style="width: 100%"}</span>
            {if $validator->isFieldError('about')}<span class="error">{$validator->getFieldError('about')}</span>{/if}
        </li>
        <li>
            {form->caption name="header" value="Отдавать с нужными заголовками"}
            <span class="input">{form->checkbox name="header" value=$file->getRightHeader()}</span>
        </li>
        <li>
            {form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}
            <span class="input">{form->checkbox name="direct_link" value=$file->getDirectLink()}</span>
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>