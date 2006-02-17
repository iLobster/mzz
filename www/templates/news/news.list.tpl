<table border="0" width="70%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="6"><b>Папки:</b>
        {foreach from=$newsFolder->getFolders('') item=current_folder name=folders}
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
        <td><b>Содержание</b></td>
        <td><b>Создано</b></td>
        <td><b>Изменено</b></td>
        <td><b>JIP</b></td>
    </tr>
    {foreach from=$news item=current_news}
        <tr>
            <td><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getId()}</a></td>
            <td>{$current_news->getTitle()}</td>
            <td>{$current_news->getText()}</td>
            <td>{$current_news->getCreated()}</td>
            <td>{$current_news->getUpdated()}</td>
            <td>{$current_news->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td colspan="6"><a href="{url section=news action=createItem params=$folderName}">Добавить новость</a></td>
    </tr>
</table>

