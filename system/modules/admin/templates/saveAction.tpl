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
                <span class="input">{$actionObject->getName()|h}</span>
            </li>
            <li>
                {form->caption name="action[controller]" value="_ action.controller"}
                <span class="input">{$actionObject->getControllerName()|h}</span>
            </li>
        {else}
            <li class="{$form->required('action[name]','required')} {$form->error('action[name]','error')}">
                {form->caption name="action[name]" value="_ action.name"}
                <span class="input">{form->text name="action[name]" size="30" value=$actionObject->getName()}{* (<a href="#" onclick="return fillUpEditAclForm();">editAcl</a>)*}</span>
                {if $form->error('action[name]')}<div class="error">{$form->message('action[name]')}</div>{/if}
            </li>
            <li class="{$form->required('action[controller]','required')} {$form->error('action[controller]','error')}">
                {form->caption name="action[controller]" value="_ action.controller"}
                <span class="input">{form->text name="action[controller]" size="30" value=$actionObject->getControllerName()}</span>
                {if $form->error('action[controller]')}<div class="error">{$form->message('action[controller]')}</div>{/if}
            </li>
        {/if}

        <li class="{$form->required('action[title]','required')} {$form->error('action[title]','error')}">
            {form->caption name="action[title]" value="Заголовок"}
            <span class="input">{form->text name="action[title]" size="30" value=$actionObject->getTitle()}</span>
            {if $form->error('action[title]')}<div class="error">{$form->message('action[title]')}</div>{/if}
        </li>
        <li class="{$form->required('action[confirm]','required')} {$form->error('action[confirm]','error')}">
            {form->caption name="action[confirm]" value="_ action.confirm"}
            <span class="input">{form->text name="action[confirm]" size="30" value=$actionObject->getConfirm()}</span>
            {if $form->error('action[confirm]')}<div class="error">{$form->message('action[confirm]')}</div>{/if}
        </li>
        <li class="{$form->required('action[main]','required')} {$form->error('action[main]','error')}">
            {form->caption name="action[main]" value="_ action.main"}
            <span class="input">{form->text name="action[main]" size="30" value=$actionObject->getActiveTemplate()}</span>
            {if $form->error('action[main]')}<div class="error">{$form->message('action[main]')}</div>{/if}
        </li>
        {if in_array('jip', $plugins)}
            <li class="{$form->required('action[jip]','required')} {$form->error('action[jip]','error')}">
                {form->caption name="action[jip]" value="Добавить в JIP"}
                <span class="input">{form->checkbox name="action[jip]" value=$actionObject->isJip()}</span>
            </li>
            <li class="{$form->required('action[icon]','required')} {$form->error('action[icon]','error')}">
                {form->caption name="action[icon]" value="Путь от корня сайта до иконки для меню JIP"}
                <span class="input">{form->text name="action[icon]" size="30" value=$actionObject->getIcon()}</span>
            </li>
        {/if}
        <li class="{$form->required('action[403handle]','required')} {$form->error('action[403handle]','error')}">
            {form->caption name="action[403handle]" value="_ action.acl_type"}
            <span class="input">{form->select name="action[403handle]" size="30" options=$aclMethods value=$actionObject->getData('403handle') one_item_freeze=true}</span>
        </li>
        {if in_array('acl', $plugins) && count($aliases)}
            <li class="{$form->required('action[alias]','required')} {$form->error('action[alias]','error')}">
                {form->caption name="action[alias]" value="Алиас для ACL"}
                <span class="input">{form->select name="action[alias]" emptyFirst=true options=$aliases value=$data.alias}</span>
            </li>
        {/if}
        {if !$isEdit}
        <li class="{$form->required('action[crud]','required')} {$form->error('action[crud]','error')}">
            {form->caption name="action[crud]" value="CRUD"}
            <span class="input">{form->select name="action[crud]" options=$crudList value=none}</span>
        </li>
        {/if}
    </ul
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>