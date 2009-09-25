{if not empty($menu)}
    <div class="title">Меню</div>
    <ul id="mzz-adm-menu" class="mzz-adm-menu">
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}" class="{if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}mzz-menu-has-sub{/if} {if $moduleName eq $current_module}active{/if}">
                <div class="mzz-menu-item">
                    <div class="mzz-menu-title">
                        {if isset($module.actions.admin)}<a href="{if $moduleName == 'admin'}{url route=adminSimpleActions action='admin'}{else}{url route=withAnyParam module='admin' name=$moduleName action='admin'}{/if}">{/if}<span class="{if !empty($module.icon)}{$module.icon}{else}mzz-icon mzz-icon-block{/if}"></span>{$module.info->getTitle()}{if isset($module.actions.admin)}</a>{/if}
                    </div>
                    <div class="mzz-menu-toggle"></div>
                </div>

                {if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}
                    <div class="mzz-menu-sub"><ul>
                    {foreach from=$module.actions item="action"}
                        {if $action->getName() != 'admin'}
                                <li{if $action->getName() eq $current_action} class="active"{/if}>{if $action->getIcon()}{icon sprite=$action->getIcon() active=true}{/if}<a href="{if $moduleName == 'admin'}{url route=adminSimpleActions action=$action->getName()}{else}{url route=withAnyParam module='admin' name=$moduleName action=$action->getName()}{/if}">{if $action->getTitle()}{$action->getTitle()|i18n:$moduleName}{else}{$module.info->getName()}{/if}</a></li>
                        {/if}
                    {/foreach}
                    </ul></div>
                {/if}

            </li>
        {/foreach}
    </ul>
{/if}