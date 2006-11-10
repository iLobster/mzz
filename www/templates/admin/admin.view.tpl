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
                    {$section_name} <a href="{url section="config" params="`$section_name`/`$module_name`" action="editCfg"}"><img src="/templates/images/config.gif"></a>
                </td>
            </tr>
            {foreach from=$section item=class}
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        {$class} <a href="{url section="access" params="`$section_name`/`$class`" action="editDefault"}"><img src="/templates/images/acl.gif"></a>
                    </td>
                </tr>
            {/foreach}
        {/foreach}
    {/foreach}
</table>