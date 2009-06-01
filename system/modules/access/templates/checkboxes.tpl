    {literal}<script type="text/javascript">
    /**
     * @param name access name
     * @param access 1 - allow checkbox, 0 - deny checkbox
     */
(function ($) {
    checkPermissionsForm = function(name, access) {
        if ($('#access_' + name + '_' + (access ? 'allow' : 'deny')).attr('checked')) {
            $('#access_' + name + '_' + (access ? 'deny' : 'allow')).attr('checked', false);
        }
    }

    /**
     * @param access 1 - allow checkboxes, 0 - deny checkboxes
     */
    setPermissionForAllActions = function(access, link) {
        var checks = $(link).parents('table:last').find('input:checkbox').each(function(){
            var elmInfo = $(this).attr('id').match(new RegExp('access_.*?_(allow|deny)', 'im'));
                if(elmInfo) {
                    if ((access && elmInfo[1] == 'deny') || (!access && elmInfo[1] == 'allow')) {
                        $('#' + elmInfo[0]).attr('checked',false);
                    } else {
                        $('#' + elmInfo[0]).attr('checked','checked');
                    }
                }});
        return false;
    }
})(jQuery);
    </script>{/literal}

    <tr>
        <td><a class="jsLink" href="#" onclick="return setPermissionForAllActions(1, this);">Разрешить</a></td>
        <td><a class="jsLink" href="#" onclick="return setPermissionForAllActions(0, this);">Запретить</a></td>
        <td style="width: 100%;"><strong>Действие</strong></td>
    </tr>
{foreach from=$actions item=action key=key}
    <tr>
        <td style='text-align: center;'><input type="checkbox" name="access[{$key}][allow]" id="access_{$key}_allow" onclick="checkPermissionsForm('{$key}', 1)" value="1" {if not empty($acl.$key.allow)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style='text-align: center;'><input type="checkbox" name="access[{$key}][deny]" id="access_{$key}_deny" onclick="checkPermissionsForm('{$key}', 0)" value="1" {if not empty($acl.$key.deny)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style="width: 100%;{if $adding === false}{if not empty($acl.$key.allow)}color: #00AA00;{elseif not empty($acl.$key.deny)}color: #BF0000;{/if}{/if}"><label for="access[{$key}]">{if not empty($action.title)}{$action.title|i18n:"jip"}{else}{$key|i18n:"jip"}{/if}</label></td>
    </tr>
{/foreach}
<tr>
    <td colspan="3"><input type="submit" value="Сохранить"> <input type="reset" value="Сбросить"> <input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
</tr>