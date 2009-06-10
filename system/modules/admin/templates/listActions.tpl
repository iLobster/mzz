{include file='jipTitle.tpl' title='Список действий'}

<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <td colspan="3"><a href="{url route="withId" section="admin" id=$id action="addAction"}" class="jipLink">Создать действие</a></td>
    </tr>
    {foreach from=$actions item=action key=key}
        <tr>
            <td width="25%">{$key}</td>
            <td width="60%">{if !empty($action.title)}{$action.title}{else}<span style="color: #999;">названия нет</span>{/if}</td>
            <td style="width: 15%; text-align: right;">
                <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-edit"><a href="{url route="adminAction" section="admin" id=$id action_name="$key" action="editAction"}" class="mzz-jip-link" title="Редактировать действие"></a></span></span>
                <span class="mzz-icon mzz-icon-script"><span class="mzz-overlay mzz-overlay-del"><a href="{url route="adminAction" section="admin" id=$id action_name="$key" action="deleteAction"}" class="mzz-jip-link" title="Удалить действие"></a></span></span>
           </td>
        </tr>
    {/foreach}
</table>