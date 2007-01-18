{add file="confirm.js"}
<table border="1">
    <tr valign="top">
        <td>
            <a href="{url section="admin" action="addModule"}" onClick="showJip('{url section="admin" action="addModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить модуль" /></a><br /><br />
            {foreach from=$modules item=module key=name name=mcycle}
                {assign var="count" value=$module.classes|@sizeof}
                {$name} <a href="{url section="admin" id=$module.id action="addClass"}" onClick="showJip('{url section="admin" id=$module.id action="addClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить класс" /></a>
                {if $count eq 0}
                    <a href="{url section="admin" id=$module.id action="editModule"}" onClick="showJip('{url section="admin" id=$module.id action="editModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать модуль" /></a>
                    <a href="{url section="admin" id=$module.id action="deleteModule"}" onClick="mzz_confirm('Вы хотите удалить этот модуль?') &amp;&amp; showJip('{url section="admin" id=$module.id action="deleteModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить модуль" /></a>
                {/if}
                <br />
                {foreach from=$module.classes item=class key=id}
                    &nbsp;&nbsp;&nbsp;{$class.name}
                    {if not $class.exists}
                        <a href="{url section="admin" id=$id action="editClass"}" onClick="showJip('{url section="admin" id=$id action="editClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="редактировать класс" /></a>
                        <a href="{url section="admin" id=$id action="deleteClass"}" onClick="mzz_confirm('Вы хотите удалить этот класс?') &amp;&amp; showJip('{url section="admin" id=$id action="deleteClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="удалить класс" /></a>
                    {/if}
                    <br />
                {/foreach}
                {if not $smarty.foreach.mcycle.last}
                    <br />
                {/if}
            {/foreach}
        </td>
        <td>
            {foreach from=$sections item=section key=name name=scycle}
                {assign var="count" value=$section.modules|@sizeof}
                {$name}:
                {if $count eq 0}
                    <a>удалить</a>
                {/if}
                <br />
                {foreach from=$section.modules item=module key=id}
                    &nbsp;&nbsp;&nbsp;{$module}<br />
                {/foreach}
                {if not $smarty.foreach.scycle.last}
                    <br />
                {/if}
            {/foreach}
        </td>
    </tr>
    <tr>
        <td colspan="2">obj_id</td>
    </tr>
    <tr>
        <td colspan="2">ACL</td>
    </tr>
</table>