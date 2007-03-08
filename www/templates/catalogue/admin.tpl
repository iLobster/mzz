<strong>Типы:</strong> <a href="{url route="default2" section="catalogue" action="addType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить тип" title="Добавить тип" align="texttop" /></a>
<table>
    {foreach from=$types item="type"}
        <tr>
            <td>{$type.title}</td>
            <td>
                <a href="{url route="withId" section="catalogue" id=$type.id action="editType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать тип" title="Редактировать тип" align="texttop" /></a>
                <a href="{url route="withId" section="catalogue" id=$type.id action="deleteType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить тип" title="Удалить тип" align="texttop" /></a>
            </td>
        </tr>
    {/foreach}
</table>
<br/>
<strong>Свойства:</strong> <a href="{url route="default2" section="catalogue" action="addProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить свойство" title="Добавить свойство" align="texttop" /></a>
<table>
    {foreach from=$properties item="property"}
        <tr>
            <td>{$property.title}</td>
            <td>
                <a href="{url route="withId" section="catalogue" id=$property.id action="editProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать тип" title="Редактировать тип" align="texttop" /></a>
                <a href="{url route="withId" section="catalogue" id=$property.id action="deleteProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить тип" title="Удалить тип" align="texttop" /></a>
            </td>
        </tr>
    {/foreach}
</table>