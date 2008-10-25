<p class="pageTitle">
    <a href="{url route="admin" section_name=$current_section module_name="catalogue" params="" action="admin"}">Список элементов</a> /
    <strong>Типы</strong> /
    <a href="{url route="default2" action="adminProperties"}">Свойства</a>
</p>

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
    {foreach from=$types item="type"}
        <tr>
            <td>&nbsp;</td>
            <td>{$type.title}</td>
            <td>{$type.name}</td>
            <td align="center">
                {assign var="typeId" value=$type.id}
                {include file="jip.tpl" jipMenuId="jip_types_$typeId" jip=$jipTypes[$type.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>
<br /><br />
 <a href="{url route="default2" section=$current_section action="addType"}" class="jipLink">Новый тип</a>