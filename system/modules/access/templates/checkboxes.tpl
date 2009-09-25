{literal}<script type="text/javascript">
(function ($) {
    selectAll = function(link) {
        $(link).parents('table:last').find('input:checkbox').each(function(){
            $(this).attr('checked','checked');
        });
        return false;
    }
})(jQuery);
</script>{/literal}

    <tr>
        <td><a class="jsLink" href="#" onclick="return selectAll(this);">Все</a></td>
        <td style="width: 100%;"><strong>Действие</strong></td>
    </tr>
{foreach from=$roles item=role}
    <tr>
        <td style='text-align: center;'>
            {if isset($current_roles[$role])}
                {form->checkbox name="access[$role]" value=1}
            {else}
                {form->checkbox name="access[$role]" value=0}
            {/if}
        </td>
        <td style="width: 100%;">{$role}</td>
    </tr>
{/foreach}
<tr>
    <td colspan="2">{form->submit name=submit value="_ simple/save"} <input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
</tr>