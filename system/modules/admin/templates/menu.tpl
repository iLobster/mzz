{if not empty($menu)}
   <table cellspacing="0" cellpadding="0">
   {foreach from=$menu item="module" key="moduleName"}
       {if count($module.actions) > 1}
           <tr>
               <td><img src="{$SITE_PATH}/templates/images/admin/{if isset($options.icon)}{$options.icon}{else}{$moduleName}.gif{/if}" alt="" /></td>
               <td>{_ module} {$moduleName}</td>
           </tr>
       {/if}
       {foreach from=$module.actions item="options" name="moduleActions" key="action"}
       <tr>
           <td class="menuSectionImg">{if count($module.actions) === 1}<img src="{$SITE_PATH}/templates/images/admin/{if isset($options.icon)}{$options.icon}{else}{$moduleName}.gif{/if}" alt="" />{/if}</td>
           <td class="menuSection">
               {if count($module.actions) > 1}&nbsp;- {/if}
               <a href="{url route=withAnyParam section='admin' name=$moduleName action=$action}">
               {if $moduleName eq $requested_module && $action eq $requested_action}<strong>{/if}
               {if isset($options.title)}{$options.title|i18n:$moduleName}{else}{$module.title}{/if}
               {if $moduleName eq $requested_module && $action eq $requested_action}</strong>{/if}
            </a></td>
        </tr>
        {/foreach}
    {/foreach}
   </table>
{/if}