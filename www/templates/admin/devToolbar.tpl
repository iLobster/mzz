{add file="confirm.js"}
<table width="99%" border="1">
    <tr>
        <td>
            <a href="{url section="admin" action="addModule"}" onClick="showJip('{url section="admin" action="addModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� ������" /></a><br /><br />
            {foreach from=$modules item=module key=id name=mcycle}
                {assign var="count" value=$module.classes|@sizeof}
                {$module.name} <a href="{url section="admin" id=$id action="addClass"}" onClick="showJip('{url section="admin" id=$id action="addClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� �����" /></a>
                {if $count eq 0}
                    <a href="{url section="admin" id=$id action="editModule"}" onClick="showJip('{url section="admin" id=$id action="editModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ������" /></a>
                    <a href="{url section="admin" id=$id action="deleteModule"}" onClick="mzz_confirm('�� ������ ������� ���� ������?') &amp;&amp; showJip('{url section="admin" id=$id action="deleteModule"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ������" /></a>
                {/if}
                <br />
                {foreach from=$module.classes item=class key=id}
                    &nbsp;&nbsp;&nbsp;{$class.name}
                    {if not $class.exists}
                        <a href="{url section="admin" id=$id action="editClass"}" onClick="showJip('{url section="admin" id=$id action="editClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� �����" /></a>
                        <a href="{url section="admin" id=$id action="deleteClass"}" onClick="mzz_confirm('�� ������ ������� ���� �����?') &amp;&amp; showJip('{url section="admin" id=$id action="deleteClass"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� �����" /></a>
                    {/if}
                    <br />
                {/foreach}
                {if not $smarty.foreach.mcycle.last}
                    <br />
                {/if}
            {/foreach}
        </td>
        <td>
            <a href="{url section="admin" action="addSection"}" onClick="showJip('{url section="admin" action="addSection"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� ������" /></a><br /><br />
            {foreach from=$sections item=section key=id name=scycle}
                {assign var="count" value=$section.classes|@sizeof}
                {$section.name} <a href="{url section="admin" id=$id action="addClassToSection"}"  onClick="showJip('{url section="admin" id=$id action="addClassToSection"}'); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="������������� ������ �������" /></a>
                {if $count eq 0}
                    <a href="{url section="admin" id=$id action="editSection"}" onClick="showJip('{url section="admin" id=$id action="editSection"}'); return false;"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ������" /></a>
                    <a href="{url section="admin" id=$id action="deleteSection"}" onClick="mzz_confirm('�� ������ ������� ���� ������?') &amp;&amp; showJip('{url section="admin" id=$id action="deleteSection"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ������" /></a>
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
            <a href="{url section="admin" action="generateObjId"}" onclick="showJip(this.href); return false;"><img src="{$SITE_PATH}/templates/images/generate.png" alt="������������� ����� ������������� �������" /></a>
            <a href="{url section="admin" action="addObjToRegistry"}" onclick="showJip(this.href); return false;"><img src="{$SITE_PATH}/templates/images/add.gif" alt="���������������� ����� ������" /></a><br />
        </td>
    </tr>
    <tr>
        <td colspan="2">ACL</td>
    </tr>
</table>