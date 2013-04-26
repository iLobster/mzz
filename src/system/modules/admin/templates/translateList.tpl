<table border="1">
    {foreach from=$modules item=module}
        <tr>
            <td>
                {$module}
            </td>
            {foreach from=$langs item=lang}
                <td>
                    <a href="{url route=adminTranslate module_name=$module language=$lang->getName()}">{$lang->getName()}</a>
                </td>
            {/foreach}
        </tr>
    {/foreach}
</table>