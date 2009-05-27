{if not empty($menu)}
    <ul id="mzz-adm-menu" class="mzz-adm-menu">
        {foreach from=$menu item="module" key="moduleName"}
            <li id="mzz-adm-menu-{$moduleName}">
                {foreach from=$module.actions item="options" name="moduleActions" key="action"}
                    {if count($module.actions) === 1 || $smarty.foreach.moduleActions.first}
                    <div class="mzz-menu-item">
                        <div class="mzz-menu-title"><span class="mzz-icon mzz-icon-block"></span><a href="{url route=withAnyParam section='admin' name=$moduleName action=$action}">{if isset($options.title)}{$options.title|i18n:$moduleName}{else}{$module.title}{/if}</a></div><div class="mzz-menu-toggle"></div>
                    </div>
                    {/if}
                    {if count($module.actions) > 1}
                        {if $smarty.foreach.moduleActions.first}
                            <div class="mzz-menu-sub"><ul>
                        {/if}
                            <li><a href="{url route=withAnyParam section='admin' name=$moduleName action=$action}">{if isset($options.title)}{$options.title|i18n:$moduleName}{else}{$module.title}{/if}</a></li>
                        {if $smarty.foreach.moduleActions.last}
                            </ul></div>
                        {/if}
                    {/if}
                {/foreach}
            </li>
        {/foreach}
       <li id="mzz-adm-menu-devtoolbar">
            <div class="mzz-menu-item">
                <div class="mzz-menu-title"><span class="mzz-icon mzz-icon-wrench-cross"></span><a href="{url route=withAnyParam section='admin' action='devToolbar'}">devToolbar</a></div><div class="mzz-menu-toggle"></div>
            </div>
        </li>
    </ul>
{/if}