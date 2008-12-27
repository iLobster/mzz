<a href="{url route=withId section=access id=$obj_id action=editACL}" class="jipLink"><img src="{$SITE_PATH}/templates/images/acl.gif" /></a>
<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    {foreach from=$items item=items}
        <tr>
            <td width="30" align="center">{$item->getId()}</td>
            <td>{$item->getName()}</td>
            <td width="20" >{$item->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center" width="30"><a href="{url route=default2 section=user action=create{{$controller_data.Class}}}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
        <td colspan="2"><a href="{url route=default2 section=user action=create{{$controller_data.Class}}}" class="jipLink">Добавить</a></td>
    </tr>
</table>
<div class="pages">{$pager->toString()}</div>