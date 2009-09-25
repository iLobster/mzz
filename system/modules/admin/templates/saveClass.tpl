<div class="jipTitle">{if $isEdit}{_ class.editing}{else}{_ class.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name','required')} {$form->error('name','error')}">
            {form->caption name="name" value="_ class.name"}
            <span class="input">
                {if $isEdit}
                    {$data.tableName}
                {else}
                    {form->text name="name" value=$data.className size="60"}
                    {if $form->error('name')}<div class="error">{$form->message('name')}</div>{/if}
                {/if}
            </span>
        </li>
        <li class="{$form->required('table','required')} {$form->error('table','error')}">
            {form->caption name="table" value="_ class.table_name"}
            <span class="input">
                {if $isEdit}
                    {$data.tableName}
                {else}
                    {form->text name="table" value=$data.tableName size="60"}
                    {if $form->error('table')}<div class="error">{$form->message('table')}</div>{/if}
                {/if}
            </span>
        </li>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{form->select name="dest" options=$dests one_item_freeze=1 value=app}</span>
            {if $form->error('dest')}<div class="error">{$form->message('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>