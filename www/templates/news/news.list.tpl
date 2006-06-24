<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="7"><b>Папки:</b>
        {foreach from=$newsFolderMapper->getFolders('1') item=current_folder name=folders}
            <a href="{url section=news action=list params=$current_folder->getName()}">{$current_folder->getName()}</a>
            {if !$smarty.foreach.folders.last}
                /
            {/if}
        {/foreach}
        </td>
    </tr>
    <tr>
        <td><b>ID</b></td>
        <td><b>Название</b></td>
        <td><b>User</b></td>
        <td><b>Содержание</b></td>
        <td><b>Создано</b></td>
        <td><b>Изменено</b></td>
        <td><b>JIP</b></td>
    </tr>
    <tr>
        <td colspan="7">Страницы ({$pager->getPagesTotal()}): {$pager->toString()}</td>
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
        <td align="center"><a href="{url section=news action=createItem params=$folderPath}"><img src="/templates/images/add.png" width="16" height="16" border="0" /></a></td>
        <td colspan="6"><a href="{url section=news action=createItem params=$folderPath}">Добавить новость</a></td>
    </tr>
</table>
