{if $isEdit}
    {include file='jipTitle.tpl' title='admin/class.editing'|i18n}
{else}
    {include file='jipTitle.tpl' title='admin/class.adding'|i18n}
{/if}

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name','required')} {$form->error('name','error')}">
            {form->caption name="name" value="_ class.name"}
            <span class="input">{form->text name="name" value=$data.name size="60"}</span>
            {if $errors->exists('name')}<div class="error">{$errors->get('name')}</div>{/if}
        </li>
        <li class="{$form->required('table','required')} {$form->error('table','error')}">
            {form->caption name="table" value="_ class.table_name"}
            <span class="input">
                {if $isEdit}
                    {$data.table}
                {else}
                    {form->text name="table" value=$data.table size="60"}
                    {if $errors->exists('table')}<div class="error">{$errors->get('table')}</div>{/if}
                {/if}
            </span>
        </li>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{form->select name="dest" options=$dests one_item_freeze=1 value=app}</span>
            {if $errors->exists('dest')}<div class="error">{$errors->get('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</form>