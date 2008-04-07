<form>
    <table border="1">
        <tr>
            <td rowspan="2">Имя переменной</td>
            <td colspan="{$plurals|@count}" align="center">Формы</td>
            {if not empty($not_default)}
                <td align="center">Язык по умолчанию</td>
            {/if}
        </tr>
        <tr>
            {foreach from=$plurals item=plural}
                <td align="center">
                    {$plural}
                </td>
            {/foreach}
            {if not empty($not_default)}
                <td align="center">
                    {$locale_default->getTranslatedName()} (0)
                </td>
            {/if}
        </tr>
        
        {foreach from=$variables item=variable key=name}
            <tr>
                <td>{$name}</td>
                {foreach from=$plurals item=plural}
                    <td>
                        {if isset($variable.$plural)}
                            {assign var=value value=$variable.$plural}
                        {else}
                            {assign var=value value=""}
                        {/if}
                        {form->text name="variable[`$name`]" value=$value}
                    </td>
                {/foreach}
                {if not empty($not_default)}
                    <td>
                        {$variables_default.$name.0}
                    </td>
                {/if}
            </tr>
        {/foreach}
    </table>
</form>