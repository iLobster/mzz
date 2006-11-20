{*
{add file="popup.js"}
{add file="confirm.js"}
*}
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
                    {$section_name} <a href="{url section="config" params="`$section_name`/`$module_name`" action="editCfg"}"><img src="{url section="" params="templates/images/config.gif"}"></a>
                </td>
            </tr>
            {foreach from=$section item=class}
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        {$class.class} <a href="{url section="access" params="`$section_name`/`$class.class`" action="editDefault"}"><img src="{url section="" params="templates/images/aclDefault.gif"}"></a><a href="{url section="access" params="`$class.obj_id`" action="editACL"}"><img src="{url section="" params="templates/images/acl.gif"}"></a>
                    </td>
                </tr>
            {/foreach}
        {/foreach}
    {/foreach}
</table>