<p class="pageTitle">
    <a href="{url route="admin" section_name=$current_section module_name="catalogue" params="" action="admin"}">Список элементов</a> /
    <a href="{url route="default2" action="adminTypes"}">Типы</a> /
    <strong>Свойства</strong>
</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Свойство</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
    {foreach from=$properties item="property"}
        <tr>
            <td>&nbsp;</td>
            <td>{$property.title}</td>
            <td>{$property.name}</td>
            <td>{$property.type}</td>
            <td align="center">
                {assign var="propId" value=$property.id}
                {include file="jip.tpl" jipMenuId="jip_properties_$propId" jip=$jipProperties[$property.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>

<br /><br />
 <a href="{url route="default2" section=$current_section action="addProperty"}" class="jipLink">Новое свойство</a>