<p class="pageTitle">Список типов</p>

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить тип" title="Добавить тип" align="texttop" border="0" /></a></td>
                <td style="text-align: left;">Тип</td>
                <td style="text-align: left;">Название</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$types item="type"}
        <tr>
            <td></td>
            <td>{$type.name}</td>
            <td>{$type.title}</td>
            <td align="center">
                {capture name="menuId"}jip_types_{$type.id}{/capture}
                {include file="jip.tpl" jipMenuId=$smarty.capture.menuId jip=$jipTypes[$type.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>
<br />
<p class="pageTitle">Список Параметров</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить свойство" title="Добавить свойство" border="0" align="texttop" /></a></td>
                <td style="text-align: left;">Свойство</td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$properties item="property"}
        <tr>
            <td></td>
            <td>{$property.name}</td>
            <td>{$property.title}</td>
            <td>{$property.type}</td>
            <td align="center">
                {capture name="menuId"}jip_properties_{$property.id}{/capture}
                {include file="jip.tpl" jipMenuId=$smarty.capture.menuId jip=$jipProperties[$property.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>