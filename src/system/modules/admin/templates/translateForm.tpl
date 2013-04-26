{form action=$form_action method="post"}
    <table border="1">
        {foreach from=$variables item=variable key=name}
            <tr>
                <td>
                    Имя: {$name} Комментарий:
                    {if not empty($not_default)}
                        {$storage_default->getComment($name)}
                    {else}
                        {form->text name="comment[`$name`]" value=$storage_default->getComment($name)}
                    {/if}
                </td>
            </tr>
            {if not empty($not_default)}
                <tr>
                    <td>{$locale_default->getTranslatedName()} (0): {$variables_default.$name.0}</td>
                </tr>
            {/if}
            {foreach from=$plurals item=plural}
                <tr>
                    <td>
                        {$plural}:
                        {if isset($variable.$plural)}
                            {assign var=value value=$variable.$plural}
                        {else}
                            {assign var=value value=""}
                        {/if}
                        {form->text name="variable[`$name`][`$plural`]" value=$value}
                    </td>
                </tr>
            {/foreach}
            <tr><td>&nbsp;</td></tr>
        {/foreach}
    </table>
    {form->submit name="apply" value="_ simple/apply" nodefault=1} {form->submit name="submit" value="_ simple/save"} {form->reset name="reset" value="_ simple/cancel"}
</form>