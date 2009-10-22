{if $isEdit}<div class="jipTitle">{_ folder_editing}</div>{else}<div class="jipTitle">{_ folder_creating}</div>{/if}
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('name', 'required')} {$validator->isFieldError('name', 'error')}">
            {form->caption name="name" value="_ identifier"}
            <span class="input">{form->text name="name" value=$folder->getName() size="40"}</span>
            {if $validator->isFieldError('name')}<div class="error">{$validator->getFieldError('name')}</div>{/if}
        </li>
        <li class="{$validator->isFieldRequired('title', 'required')} {$validator->isFieldError('title', 'error')}">
            {form->caption name="title" value="_ title"}
            <span class="input">{form->text name="title" value=$folder->getTitle() size="40"}</span>
            {if $validator->isFieldError('title')}<div class="error">{$validator->getFieldError('title')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</form>