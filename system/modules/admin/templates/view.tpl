<a href="{url route=default2 section="admin" action="devToolbar"}">developer toolbar</a>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
    {foreach from=$info item=module key=module_name}
        {assign var="main_name" value="`$main_class.$module_name`"}
        <tr>
            <td colspan="2">
                {$module_name}
            </td>
            <td>
                {if not empty($cfgAccess.$module_name)}
                        <a href="{url route="withAnyParam" section="admin" name="$module_name" action="editConfig"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/config.gif"></a>
                    {/if}
                {if not empty($admin.$main_name)}{if $module_name ne 'admin'}{if $module_name ne 'access'}
                    <a href="{url route=withAnyParam section="admin" name="$module_name" action="admin"}">админка</a>
                {/if}{/if}{/if}    
            </td>
        </tr>
    {/foreach}
</table>
