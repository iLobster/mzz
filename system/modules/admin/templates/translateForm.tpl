<form>
    <table border="1">
        <tr>
            <td rowspan="2">Имя переменной</td>
            <td colspan="{$plurals|@count}" align="center">Формы</td>
        </tr>
        <tr>
            {foreach from=$plurals item=plural}
                <td align="center">
                    {$plural}
                </td>
            {/foreach}
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
            </tr>
        {/foreach}
    </table>
</form>