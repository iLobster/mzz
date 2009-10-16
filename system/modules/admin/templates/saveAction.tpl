{if $isEdit}
    {include file='jipTitle.tpl' title='admin/action.editing'|i18n}
{else}
    {include file='jipTitle.tpl' title='admin/action.adding'|i18n}
{/if}

{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">{form->select name="dest" options=$dests one_item_freeze=1 value=app}</span>
            {if $form->error('dest')}<div class="error">{$form->message('dest')}</div>{/if}
        </li>
        {if $isEdit}
            <li>
                {form->caption name="action[name]" value="_ action.name"}
                <span class="input">{$actionData.name|h}</span>
            </li>
            <li>
                {form->caption name="action[controller]" value="_ action.controller"}
                <span class="input">{$actionData.controllerName|h}</span>
            </li>
        {else}
            <li class="{$form->required('action[name]','required')} {$form->error('action[name]','error')}">
                {form->caption name="action[name]" value="_ action.name"}
                <span class="input">{form->text name="action[name]" size="30" value=$actionData.name}{* (<a href="#" onclick="return fillUpEditAclForm();">editAcl</a>)*}</span>
                {if $form->error('action[name]')}<div class="error">{$form->message('action[name]')}</div>{/if}
            </li>
            <li class="{$form->required('action[controller]','required')} {$form->error('action[controller]','error')}">
                {form->caption name="action[controller]" value="_ action.controller"}
                <span class="input">{form->text name="action[controller]" size="30" value=$actionData.controllerName}</span>
                {if $form->error('action[controller]')}<div class="error">{$form->message('action[controller]')}</div>{/if}
            </li>
        {/if}

        <li class="{$form->required('action[title]','required')} {$form->error('action[title]','error')}">
            {form->caption name="action[title]" value="Заголовок"}
            <span class="input">{form->text name="action[title]" size="30" value=$actionData.title}</span>
            {if $form->error('action[title]')}<div class="error">{$form->message('action[title]')}</div>{/if}
        </li>
        <li class="{$form->required('action[confirm]','required')} {$form->error('action[confirm]','error')}">
            {form->caption name="action[confirm]" value="_ action.confirm"}
            <span class="input">{form->text name="action[confirm]" size="30" value=$actionData.confirm}</span>
            {if $form->error('action[confirm]')}<div class="error">{$form->message('action[confirm]')}</div>{/if}
        </li>
        <li class="{$form->required('action[main]','required')} {$form->error('action[main]','error')}">
            {form->caption name="action[main]" value="_ action.main"}
            <span class="input">{form->text name="action[main]" size="30" value=$actionData.activeTemplate}</span>
            {if $form->error('action[main]')}<div class="error">{$form->message('action[main]')}</div>{/if}
        </li>
        {if $moduleClassMapper->isAttached('jip')}
            <li class="{$form->required('action[jip]','required')} {$form->error('action[jip]','error')}">
                {form->caption name="action[jip]" value="Добавить в JIP"}
                <span class="input">{form->checkbox name="action[jip]" value=$actionData.jip}</span>
            </li>
            <li class="{$form->required('action[icon]','required')} {$form->error('action[icon]','error')}">
                {form->caption name="action[icon]" value="Иконка для JIP"}
                <span class="input">{form->text name="action[icon]" size="30" value=$actionData.icon}</span>
            </li>
        {/if}

        {if !$isEdit}
        <li class="{$form->required('action[crud]','required')} {$form->error('action[crud]','error')}">
            {form->caption name="action[crud]" value="CRUD"}
            <span class="input">{form->select name="action[crud]" options=$crudList emptyFirst="none"}</span>
        </li>
        {/if}
    </ul
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>