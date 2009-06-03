{if $isEdit}<div class="jipTitle">{_ folder_editing}</div>{else}<div class="jipTitle">{_ folder_creating}</div>{/if}
{form action=$action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name','required')} {$form->error('name','error')}">
            {form->caption name="name" value="_ identifier"}
            <span class="input">{form->text name="name" value=$folder->getName() size="40"}</span>
            {if $errors->exists('name')}<div class="error">{$errors->get('name')}</div>{/if}
        </li>
        <li class="{$form->required('title','required')} {$form->error('title','error')}">
            {form->caption name="title" value="_ title"}
            <span class="input">{form->text name="title" value=$folder->getTitle() size="40"}</span>
            {if $errors->exists('title')}<div class="error">{$errors->get('title')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</form>