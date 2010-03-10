{if not empty($menu)}
    <ul id="adminMenu" class="adminMenu">
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}" class="{if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}expanded{/if} {if $moduleName eq $current_module}active{/if}">
                <span {if !isset($module.actions.admin)}class="noa"{/if}>{if isset($module.actions.admin)}<a href="{if $moduleName == 'admin'}{url route=adminSimpleActions action='admin'}{else}{url route=withAnyParam module='admin' name=$moduleName action='admin'}{/if}">{/if}
{icon sprite=$module.icon|default:"sprite:admin/module/admin"}{$module.info->getTitle()}
                {if isset($module.actions.admin)}</a>{/if}</span>
                {if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}
                    <ol>
                    {foreach from=$module.actions item="action"}
                        {if $action->getName() != 'admin'}
                                <li>
<span><a {if $action->getName() eq $current_action} class="active"{/if} href="{if $moduleName == 'admin'}{url route=adminSimpleActions action=$action->getName()}{else}{url route=withAnyParam module='admin' name=$moduleName action=$action->getName()}{/if}">
{icon sprite=$action->getIcon()}
{if $action->getTitle()}{$action->getTitle()|i18n:$moduleName}{else}{$module.info->getName()}{/if}</a></span></li>
                        {/if}
                    {/foreach}
                    </ol>
                {/if}

            </li>
        {/foreach}
    </ul>
{/if}