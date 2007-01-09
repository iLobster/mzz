<table border="1">
    {foreach from=$newsFolder->getFolders(1) item=current_folder name=folders}
        <tr>
            {math equation="((level-1)*15 + 10)" level=$current_folder->getLevel() assign=padding}
            <td style="padding-left: {$padding}px;"><a href="{url route='admin' params=$current_folder->getPath() section_name=news module_name=news}">{$current_folder->getTitle()}</a></td>
            <td>{$current_folder->getJip()}</td>
        </tr>
    {/foreach}
    {foreach from=$news item=current_news}
        <tr>
            <td style="padding-left: {$padding}px;">{$current_news->getTitle()}</td>
            <td>{$current_news->getJip()}</td>
        </tr>
    {/foreach}
</table>