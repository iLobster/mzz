{if not empty($menu)}
    <ul id="mzz-adm-menu" class="mzz-adm-menu">
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}"{if $moduleName eq $current_module} class="active"{/if}>
                <div class="mzz-menu-item">
                    <div class="mzz-menu-title">
                        <span class="mzz-icon mzz-icon-block"></span>
                        {if isset($module.actions.admin)}<a href="{url route=withAnyParam section='admin' name=$moduleName action='admin'}">{/if}{$module.title}{if isset($module.actions.admin)}</a>{/if}
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
       <li id="mzz-adm-menu-devtoolbar"{if !$current_module} class="active"{/if}>
            <div class="mzz-menu-item">
                <div class="mzz-menu-title"><span class="mzz-icon mzz-icon-wrench-cross"></span><a href="{url route=withAnyParam section='admin' action='devToolbar'}">devToolbar</a></div><div class="mzz-menu-toggle"></div>
            </div>
        </li>
    </ul>
{/if}