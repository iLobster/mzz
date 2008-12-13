{include file='jipTitle.tpl' title="Структура объекта класса '`$class`'"}
{if $langTableError}
<div style="background-color: #FBC4C4; color: #800909; padding: 4px;">
<strong>Can't load the lang fields</strong>: {$langTableError}
</div>{/if}
<a href="#" onclick="$(this).next().toggle().select();return false;">Код для тестов</a>
{set name=num_fields}{$fields|@count}{/set}
{assign var=height value=$num_fields*17}
<textarea style="width:99%;display:none;height:{$height}px;">{foreach from=$fields item=field key=key}
'{$key}' => array ('name' => '{$key}', 'accessor' => '{$field.accessor}', 'mutator' => '{$field.mutator}'),
{/foreach}</textarea>
<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <td colspan="4"><a href="{url route="withAnyParam" section="admin" name=$class action="addmap"}" class="jipLink">Создать поле</a></td>
    </tr>
    {foreach from=$fields item=field key=key}
        <tr style="background-color: #{if in_array($key, $delete)}FFE8E8{elseif isset($added[$key])}FFFFD7{else}FFFFFF{/if};">
           <td width="{if in_array($key, $delete)}40{else}20{/if}px">
                <a href="{url route="adminMap" section="admin" class=$class field=$key action="editmap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать поле" /></a>
                {if in_array($key, $delete)}<a href="{url route="adminMap" section="admin" class=$class field=$key action="deletemap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить поле" /></a>{/if}
           </td>
           <td style="width: 99%;">{$key}{if isset($langFields[$key])} <span style="color: #999; font-size: 95%;">(lang)</span>{/if}</td>
           <td style="color: #999;">{$field.accessor}()</td>
           <td style="color: #999;">{$field.mutator}($value)</td>
        </tr>
    {/foreach}
</table>