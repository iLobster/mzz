{add file="toolbar.css"}

<!-- модули и классы -->
<div class="toolbarLayerTopLeft">
<span class="toolbarSectionName"><strong>Модули</strong> и классы</span> <a href="{url section="admin" action="addModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить модуль" title="Добавить модуль" align="absmiddle" /></a>
<table class="toolbarActions" cellpadding="1" cellspacing="0">
    {foreach from=$modules item=module key=id }
        {assign var="count" value=$module.classes|@sizeof}
        <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FAFAFA'">
            <td class="toolbarBorder"><strong>{$module.name}</strong></td>
            <td class="toolbarActions" align="right">{if $count eq 0}
             <a href="{url section="admin" id=$id action="editModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать модуль" title="Редактировать модуль" align="texttop" /></a>
             <a href="{url section="admin" id=$id action="deleteModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить модуль" title="Удалить модуль" align="texttop" /></a>
            {/if}<a href="{url section="admin" id=$id action="addClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить класс" title="Добавить класс" align="texttop" /></a></td>
        </tr>
        {foreach from=$module.classes item=class key=id}
        <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
            <td class="toolbarElementName">{$class.name}</td>
            <td align=right>{if not $class.exists}
                  <a href="{url section="admin" id=$id action="editClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать класс" title="Редактировать класс" align="texttop" /></a>
                  <a href="{url section="admin" id=$id action="deleteClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить класс" title="Удалить класс" align="texttop" /></a>
                {/if}<a href="{url section="admin" id=$id action="listActions"}" onClick="return jipWindow.open(this.href);"><img src='{$SITE_PATH}/templates/images/actions.gif' title="Действия класса" alt="Действия класса"  align="texttop"/></a></td>
        </tr>
        {/foreach}
        {if $count eq 0}
        <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
            <td colspan="2" class="toolbarEmpty">--- классов нет ---</td>
        </tr>{/if}
    {/foreach}
</table>
</div>
<!-- секции и классы -->
<div class="toolbarLayerTopRight">
<span class="toolbarSectionName"><strong>Секции</strong> и классы</span> <a href="{url section="admin" action="addSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Создать раздел" title="Создать раздел" align="absmiddle" /></a>
<table class="toolbarActions" cellpadding="1" cellspacing="0">
    {foreach from=$sections item=section key=id}
        {assign var="count" value=$section.classes|@sizeof}
        <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FAFAFA'">
            <td class="toolbarBorder"><strong>{$section.name}</strong></td>
            <td class="toolbarActions" align="right">{if $count eq 0}
              <a href="{url section="admin" id=$id action="editSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать раздел" title="Редактировать раздел" align="texttop" /></a>
              <a href="{url section="admin" id=$id action="deleteSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить раздел" title="Удалить раздел" align="texttop" /></a>
            {/if}<a href="{url section="admin" id=$id action="addClassToSection"}"  onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="редактировать список классов" title="Редактировать список классов" align="texttop" /></a></td>
        </tr>
        {foreach from=$section.classes item=class key=id}
        <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
            <td colspan="2" class="toolbarElementName">{$class}</td>
        </tr>
        {/foreach}{if $count eq 0}
        <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
            <td colspan="2" class="toolbarEmpty">--- классов нет ---</td>
        </tr>{/if}
    {/foreach}
</table>
</div>


<div class="toolbarLayerBottomLeft">
<span class="toolbarSectionName">Зарегистрированные объекты</span> <a href="{url section="admin" action="addObjToRegistry"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/DB.png" alt="Сгенерировать" title="Генерация и регистрация нового идентификатора объекта" align="absmiddle" /></a>
<table class="toolbarObjects" cellpadding="2" cellspacing="0">
    <tr class="toolbarObjectsTitle">
        <td style="width: 45px;" class="toolbarBorder">obj_id</td>
        <td class="toolbarBorder">секция</td>
        <td class="toolbarBorder">класс</td>

        {foreach from=$latestObjects item=latestObject}
          <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
            <td><a href="{url section="access" obj_id=$latestObject.obj_id action="editACL"}" onclick="return jipWindow.open(this.href);">{$latestObject.obj_id}</a></td>
            <td>{$latestObject.section_name}</td>
            <td>{$latestObject.class_name}</td>
          </tr>
        {/foreach}
    </tr>
</table>
</div>