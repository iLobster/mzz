<table width="99%" border="1">
    <tr>
        <td>
            <a href="{url section="admin" action="addModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить модуль" /></a><br /><br />
            {foreach from=$modules item=module key=id name=mcycle}
                {assign var="count" value=$module.classes|@sizeof}
                {$module.name} <a href="{url section="admin" id=$id action="addClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить класс" /></a>
                {if $count eq 0}
                    <a href="{url section="admin" id=$id action="editModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать модуль" /></a>
                    <a href="{url section="admin" id=$id action="deleteModule"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить модуль" /></a>
                {/if}
                <br />
                {foreach from=$module.classes item=class key=id}
                    &nbsp;&nbsp;&nbsp;{$class.name}
                    {if not $class.exists}
                        <a href="{url section="admin" id=$id action="editClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать класс" /></a>
                        <a href="{url section="admin" id=$id action="deleteClass"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить класс" /></a>
                    {/if}
                    <a href="{url section="admin" id=$id action="updateActions"}" onClick="return jipWindow.open(this.href);">обновить экшны</a>
                    <br />
                {/foreach}
                {if not $smarty.foreach.mcycle.last}
                    <br />
                {/if}
            {/foreach}
        </td>
        <td>
            <a href="{url section="admin" action="addSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить раздел" /></a><br /><br />
            {foreach from=$sections item=section key=id name=scycle}
                {assign var="count" value=$section.classes|@sizeof}
                {$section.name} <a href="{url section="admin" id=$id action="addClassToSection"}"  onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="редактировать список классов" /></a>
                {if $count eq 0}
                    <a href="{url section="admin" id=$id action="editSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать раздел" /></a>
                    <a href="{url section="admin" id=$id action="deleteSection"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить раздел" /></a>
                {/if}
                <br />
                {foreach from=$section.classes item=class key=id}
                    &nbsp;&nbsp;&nbsp;{$class}<br />
                {/foreach}
                {if not $smarty.foreach.scycle.last}
                    <br />
                {/if}
            {/foreach}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <a href="{url section="admin" action="addObjToRegistry"}" onclick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Зарегистрировать новый объект" /></a><br />
        </td>
    </tr>
    <tr>
        <td colspan="2">ACL</td>
    </tr>
</table>