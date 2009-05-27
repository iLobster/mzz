Редактирование разделов

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>Раздел{if $errors->exists('section')}<br />{$errors->get('section')}{/if}</td>
            <td>Модуль</td>
            <td>Заголовок</td>
        </tr>

        {foreach from=$modules item=title key=module}
            <tr>
                <td>{form->text name=section[$module] value=$sections.$module|default:""}</td>
                <td>{$module|h}</td>
                <td>{$title|h}</td>
            </tr>
        {/foreach}

        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>