<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="7"><b>�����:</b>
                <table border="0" cellspacing="0" cellpadding="0"><tr>
                        {foreach from=$newsFolderMapper->getFolders(1) item=current_folder name=folders}
                                <td><a href="{url section=news action=list params=$current_folder->getPath()}">{$current_folder->getName()}</a></td><td>{$current_folder->getJip()}</td>
                            {if !$smarty.foreach.folders.last}
                                <td>/</td>
                            {/if}
                        {/foreach}
                </tr></table>
        </td>
    </tr>
    <tr>
        <td><b>ID</b></td>
        <td><b>��������</b></td>
        <td><b>User</b></td>
        <td><b>����������</b></td>
        <td><b>�������</b></td>
        <td><b>��������</b></td>
        <td><b>JIP</b></td>
    </tr>
    <tr>
        <td colspan="7">�������� ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>
    {foreach from=$news item=current_news}
        <tr>
            <td align="center"><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getId()}</a></td>
            <td><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getTitle()}</a></td>
            <td>{$current_news->getEditor()->getLogin()}</td>
            <td>{$current_news->getText()}</td>
            <td>{$current_news->getCreated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
            <td>{$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M:%S"}</td>
            <td align="center">{$current_news->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=news action=createItem params=$folderPath}"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a></td>
        <td colspan="6"><a href="{url section=news action=createItem params=$folderPath}">�������� �������</a></td>
    </tr>
</table>