{if not empty($menu)}
    <ul id="mzz-adm-menu" class="mzz-adm-menu">
        <li{if $current_module == 'admin' && $current_action == 'admin'} class="active"{/if}>
            <div class="mzz-menu-item">
                <div class="mzz-menu-title"><a href="{url route=default2 module='admin' action='admin'}"><span class="mzz-icon mzz-icon-wrench-cross"></span> Главная</a></div><div class="mzz-menu-toggle"></div>
            </div>
        </li>
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}" class="{if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}mzz-menu-has-sub{/if} {if $moduleName eq $current_module}active{/if}">
                <div class="mzz-menu-item">
                    <div class="mzz-menu-title">
                        {if isset($module.actions.admin)}<a href="{url route=withAnyParam section='admin' name=$moduleName action='admin'}">{/if}<span class="mzz-icon mzz-icon-block"></span>{$module.title}{if isset($module.actions.admin)}</a>{/if}
                    </div>
                    <div class="mzz-menu-toggle"></div>
                </div>
                {if count($module.actions) > 1 || (count($module.actions) === 1 && !isset($module.actions.admin))}
                    <div class="mzz-menu-sub"><ul>
                    {foreach from=$module.actions item="options" name="moduleActions" key="action"}
                        {if $action != 'admin'}
                                <li{if $action eq $current_action} class="active"{/if}><a href="{url route=withAnyParam section='admin' name=$moduleName action=$action}">{if isset($options.title)}{$options.title|i18n:$moduleName}{else}{$module.title}{/if}</a></li>
                        {/if}
                    {/foreach}
                    </ul></div>
                {/if}
            </li>
        {/foreach}
        <li id="mzz-adm-menu-devtoolbar"{if $current_module == 'admin' && $current_action == 'devToolbar'} class="active"{/if}>
            <div class="mzz-menu-item">
                <div class="mzz-menu-title"><a href="{url route=default2 module='admin' action='devToolbar'}"><span class="mzz-icon mzz-icon-wrench-cross"></span> devToolbar</a></div><div class="mzz-menu-toggle"></div>
            </div>
        </li>
    </ul>
{/if}