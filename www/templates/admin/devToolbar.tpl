<a href="">Экшны</a><br />
<a href="">Класс-секция</a><br />
<a href="">Модули, классы, секции</a><br />
<a href="">obj_id</a><br />
<a href="">Регистрация в ACL</a><br />
<a href="">sys_access</a><br />

<table border="1">
    <tr valign="top">
        <td>
            {foreach from=$modules item=module key=name name=mcycle}
                {assign var="count" value=$module.classes|@sizeof}
                {$name} <a href="{url section="admin" id=$module.id action="addClass"}">+</a>
                {if $count eq 0}
                    <a>удалить</a>
                {/if}
                <br />
                {foreach from=$module.classes item=class key=id}
                    &nbsp;&nbsp;&nbsp;{$class.name}
                    {if not $class.exists}
                        <a href="{url section="admin" id=$id action="editClass"}">редактировать</a>
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