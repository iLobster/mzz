{add file="toolbar.css"}
<!-- ������ � ������ -->
<div class="pageContent">
<div class="toolbarLayerTopLeft">
    <span class="toolbarSectionName"><strong>������</strong> � ������</span> <a href="{url route="default2" section="admin" action="addModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� ������" title="�������� ������" align="absmiddle" /></a>
    <table class="toolbarActions" cellpadding="1" cellspacing="0">
        {foreach from=$modules item=module key=id }
            {assign var="count" value=$module.classes|@sizeof}
            <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FAFAFA'">
                <td class="toolbarBorder"><strong>{$module.name}</strong></td>
                <td class="toolbarActions" align="right">
                    <a href="{url route="withId" section="admin" id=$id action="editModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ������" title="������������� ������" align="texttop" /></a>
                    <a href="{url route="withId" section="admin" id=$id action="listCfg"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/config.gif" alt="��������� ������������" title="��������� ������������" align="texttop" /></a>
                    {if $count eq 0}
                        <a href="{url route="withId" section="admin" id=$id action="deleteModule"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ������" title="������� ������" align="texttop" /></a>
                    {/if}
                    <a href="{url route="withId" section="admin" id=$id action="addClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� �����" title="�������� �����" align="texttop" /></a>
                </td>
            </tr>
            {foreach from=$module.classes item=class key=id}
                <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
                    <td class="toolbarElementName">
                        {if $class.name eq $module.main_class_name}<u>{/if}
                        {$class.name}
                        {if $class.name eq $module.main_class_name}</u>{/if}
                    </td>
                    <td align=right>
                        <a href="{url route="withAnyParam" section="admin" name=$class.name action="readmap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/admin/model.gif" alt="����� �������" title="����� �������" align="texttop" /></a>
                        <a href="{url route="withId" section="admin" id=$id action="editClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� �����" title="������������� �����" align="texttop" /></a>
                        <a href="{url route="withId" section="admin" id=$id action="deleteClass"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� �����" title="������� �����" align="texttop" /></a>
                        <a href="{url route="withId" section="admin" id=$id action="listActions"}" class="jipLink"><img src='{$SITE_PATH}/templates/images/actions.gif' title="�������� ������" alt="�������� ������"  align="texttop"/></a>
                    </td>
                </tr>
            {/foreach}
            {if $count eq 0}
                <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
                    <td colspan="2" class="toolbarEmpty">--- ������� ��� ---</td>
                </tr>
            {/if}
        {/foreach}
    </table>
</div>
<!-- ������ � ������ -->
<div class="toolbarLayerTopRight">
    <span class="toolbarSectionName"><strong>������</strong> � ������</span> <a href="{url route="default2" section="admin" action="addSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="������� ������" title="������� ������" align="absmiddle" /></a>
    <table class="toolbarActions" cellpadding="1" cellspacing="0">
        {foreach from=$sections item=section key=id}
            {assign var="count" value=$section.classes|@sizeof}
            <tr class="toolbarTitle" onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FAFAFA'">
                <td class="toolbarBorder"><strong>{$section.name}</strong></td>
                <td class="toolbarActions" align="right">
                    <a href="{url route="withId" section="admin" id=$id action="editSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ������" title="������������� ������" align="texttop" /></a>
                    {if $count eq 0}
                        <a href="{url route="withId" section="admin" id=$id action="deleteSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ������" title="������� ������" align="texttop" /></a>
                    {/if}
                    <a href="{url route="withId" section="admin" id=$id action="addModuleToSection"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/classes.gif" alt="������������� ������ �������" title="������������� ������ �������" align="texttop" /></a>
                </td>
            </tr>
            {foreach from=$section.classes item=class key=id}
                <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
                    <td class="toolbarElementName">{$class}</td>
                    <td align=right>
                        {assign var="name" value="`$section.name`_`$class`"}
                        {if not empty($access.$name.editDefault)}<a href="{url route=withAnyParam section="access" name="`$section.name`/`$class`" action="editDefault"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/aclDefault.gif"></a>{/if}
                        {if not empty($access.$name.editACL)}<a href="{url route=withId section="access" id="`$access.$name.obj_id`" action="editACL"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/acl.gif"></a>{/if}
                    </td>
                </tr>
            {/foreach}
            {if $count eq 0}
                <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
                    <td colspan="2" class="toolbarEmpty">--- ������� ��� ---</td>
                </tr>
            {/if}
        {/foreach}
    </table>
</div>

<div class="toolbarLayerBottomLeft">
    <span class="toolbarSectionName">������������������ �������</span> <a href="{url route="default2" section="admin" action="addObjToRegistry"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/DB.png" alt="�������������" title="��������� � ����������� ������ �������������� �������" align="absmiddle" /></a>
    <table class="toolbarObjects" cellpadding="2" cellspacing="0">
        <tr class="toolbarObjectsTitle">
            <td style="width: 45px;" class="toolbarBorder">obj_id</td>
            <td class="toolbarBorder">������</td>
            <td class="toolbarBorder">�����</td>
        </tr>
            {foreach from=$latestObjects item=latestObject}
                <tr onmouseover="this.style.backgroundColor = '#FFFDE1'" onmouseout="this.style.backgroundColor = '#FFFFFF'">
                    <td><a href="{url route="withId" section="access" id=$latestObject.obj_id action="editACL"}" class="jipLink">{$latestObject.obj_id}</a></td>
                    <td>{$latestObject.section_name}</td>
                    <td>{$latestObject.class_name}</td>
                </tr>
            {/foreach}
    </table>
</div>
</div>