<table border="1">
    {foreach from=$pageFolder->getFolders(1) item=current_folder name=folders}
        <tr>
            {math equation="((level-1)*15 + 10)" level=$current_folder->getLevel() assign=padding}
            <td style="padding-left: {$padding}px;"><a href="{url route='admin' params=$current_folder->getPath() section_name=page module_name=page}">{$current_folder->getTitle()}</a></td>
            <td>{$current_folder->getJip()}</td>
        </tr>
    {/foreach}
    {foreach from=$pages item=current_page}
        <tr>
            <td style="padding-left: {$padding}px;">{$current_page->getTitle()}</td>
            <td>{$current_page->getJip()}</td>
        </tr>
    {/foreach}
</table>