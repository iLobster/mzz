{if $isEdit}
{include file='jipTitle.tpl' title='admin/module.editing'|i18n}
{else}
{include file='jipTitle.tpl' title='admin/module.adding'|i18n}
{/if}
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name','required')} {$form->error('name','error')}">
            {form->caption name="name" value="_ module.name"}
            <span class="input">{if $nameRO}
                    {$data.name}
                {else}
                    {form->text name="name" size="30" value=$data.name}
                {/if}
            </span>
            {if $errors->exists('name')}<div class="error">{$errors->get('name')}</div>{/if}
        </li>
        <li class="{$form->required('dest','required')} {$form->error('dest','error')}">
            {form->caption name="dest" value="_ dest"}
            <span class="input">
                {if $isEdit}
                    {$data.dest}
                {else}
                    {form->select name="dest" options=$dests one_item_freeze=1 value=app}
                {/if}
            </span>
            {if $errors->exists('dest')}<div class="error">{$errors->get('dest')}</div>{/if}
        </li>
        <li class="{$form->required('title','required')} {$form->error('title','error')}">
            {form->caption name="title" value="_ module.title"}
            <span class="input">{form->text name="title" size="30" value=$data.title}</span>
            {if $errors->exists('title')}<div class="error">{$errors->get('title')}</div>{/if}
        </li>
        <li class="{$form->required('icon','required')} {$form->error('icon','error')}">
            {form->caption name="icon" value="_ module.icon"}
            <span class="input">{form->text name="icon" size="30" value=$data.icon}</span>
            {if $errors->exists('icon')}<div class="error">{$errors->get('title')}</div>{/if}
        </li>
        <li class="{$form->required('order','required')} {$form->error('order','error')}">
            {form->caption name="order" value="_ module.order"}
            <span class="input">{form->text name="order" size="30" value=$data.order|default:"0"}</span>
            {if $errors->exists('order')}<div class="error">{$errors->get('order')}</div>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>