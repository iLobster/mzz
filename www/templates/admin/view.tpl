{add file="popup.js"}
<a href="{url section="admin" action="devToolbar"}">developer toolbar</a>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    {foreach from=$info item=module key=module_name}
        <tr>
            <td colspan="3">
                {$module_name}
            </td>
        </tr>
        {foreach from=$module item=section key=section_name}
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    {assign var="name" value="`$section_name`_`$module_name`"}
                    {$section_name} {if not empty($cfgAccess.$name)}<a href="{url section="config" params="`$section_name`/`$module_name`" action="editCfg"}" onclick="javascript: return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/config.gif"></a>{/if}{if not empty($admin.$name)}{if $module_name ne 'admin'} <a href="{url section="admin" params="`$section_name`/`$module_name`" action="admin"}">�������</a>{/if}{/if}
                </td>
            </tr>
            {foreach from=$section item=class}
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        {$class.class} {if not empty($class.editDefault)}<a href="{url section="access" params="`$section_name`/`$class.class`" action="editDefault"}" onclick="javascript: return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/aclDefault.gif"></a>{/if} {if not empty($class.editACL)}<a href="{url section="access" params="`$class.obj_id`" action="editACL"}" onclick="javascript: return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/acl.gif"></a>{/if}
                    </td>
                </tr>
            {/foreach}
        {/foreach}
    {/foreach}
</table>