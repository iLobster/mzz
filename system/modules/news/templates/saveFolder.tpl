{if $isEdit}<div class="jipTitle">{_ folder_editing}</div>{else}<div class="jipTitle">{_ folder_creating}</div>{/if}
{form action=$action method="post" jip=true}
    <dl>
        <dt>{form->caption name="name" value="_ identifier"}:</dt>
        <dd>
            {form->text name="name" value=$folder->getName() size="40"}
            {if $errors->exists('name')}<div class="error">{$errors->get('name')}</div>{/if}
        </dd>
    </dl>
    <dl>
        <dt>{form->caption name="title" value="_ title"}:</dt>
        <dd>
            {form->text name="title" value=$folder->getTitle() size="40"}
            {if $errors->exists('title')}<div class="error">{$errors->get('title')}</div>{/if}
        </dd>
    </dl>
    <dl>
        <dt></dt>
        <dd>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</dd>
    </dl>
</form>