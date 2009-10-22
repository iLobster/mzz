<div class="jipTitle">{if $isEdit}{_ class.editing}{else}{_ class.adding}{/if}</div>

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{if $validator->isFieldRequired('name')}required{/if} {if $validator->isFieldError('name')}error{/if}">
            {form->caption name="name" value="_ class.name"}
            <span class="input">
                {if $isEdit}
                    {$data.tableName}
                {else}
                    {form->text name="name" value=$data.className size="60"}
                    {if $validator->isFieldError('name')}<div class="error">{$validator->getFieldError('name')}</div>{/if}
                {/if}
            </span>
        </li>
        <li class="{if $validator->isFieldRequired('table')}required{/if} {if $validator->isFieldError('table')}error{/if}">
            {form->caption name="table" value="_ class.table_name"}
            <span class="input">
                {if $isEdit}
                    {$data.tableName}
                {else}
                    {form->text name="table" value=$data.tableName size="60"}
                    {if $validator->isFieldError('table')}<div class="error">{$validator->getFieldError('table')}</div>{/if}
                {/if}
            </span>
        </li>
        <li class="{if $validator->isFieldRequired('dest')}required{/if} {if $validator->isFieldError('dest')}error{/if}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{form->select name="dest" options=$dests one_item_freeze=1 value=app}</span>
            {if $validator->isFieldError('dest')}<div class="error">{$validator->getFieldError('dest')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>