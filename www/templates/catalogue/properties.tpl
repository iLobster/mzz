{foreach from=$data item="element"}
{strip}
        <tr>
            <td>{$element.title}:</td>
            <td>
                {if $element.type eq 'text'}
                    {form->textarea name=$element.name value=$element.value style="width:500px;height:300px;"}{$errors->get($element.name)}
                {else}
                    {form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}
                {/if}
            </td>
        <tr>
{/strip}
{/foreach}