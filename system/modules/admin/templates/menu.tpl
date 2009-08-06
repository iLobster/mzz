{if not empty($menu)}
    <div class="title">Меню</div>
    <ul id="mzz-adm-menu" class="mzz-adm-menu">
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}" class="{if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}mzz-menu-has-sub{/if} {if $moduleName eq $current_module}active{/if}">
                <div class="mzz-menu-item">
                    <div class="mzz-menu-title">
                        {if isset($module.actions.admin)}<a href="{if $moduleName == 'admin'}{url route=adminSimpleActions action='admin'}{else}{url route=withAnyParam module='admin' name=$moduleName action='admin'}{/if}">{/if}<span class="{if !empty($module.icon)}{$module.icon}{else}mzz-icon mzz-icon-block{/if}"></span>{$module.title}{if isset($module.actions.admin)}</a>{/if}
                    </div>
                    <div class="mzz-menu-toggle"></div>
                </div>
                {if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}
                    <div class="mzz-menu-sub"><ul>
                    {foreach from=$module.actions item="options" name="moduleActions" key="action"}
                        {if $action != 'admin'}
                                <li{if $action eq $current_action} class="active"{/if}>{if !empty($options.icon)}{icon sprite=$options.icon active=true}{/if}<a href="{if $moduleName == 'admin'}{url route=adminSimpleActions action=$action}{else}{url route=withAnyParam module='admin' name=$moduleName action=$action}{/if}">{if isset($options.title)}{$options.title|i18n:$moduleName}{else}{$module.title}{/if}</a></li>
                        {/if}
                    {/foreach}
                    </ul></div>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}