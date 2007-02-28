Текущий каталог: <b>{$current_folder->getPath()}</b><br />
<a href="{url route=withAnyParam section=$current_section action=upload name=$current_folder->getPath()}" class="jipLink">Загрузить файл</a><br />
Каталоги:
<table border="1">
    <tr>
        <td>id</td>
        <td>имя</td>
        <td>титл</td>
        <td>jip</td>
    </tr>
    {foreach from=$folders item=folder}
        <tr>
            <td>{$folder->getId()}</td>
            <td><a href="{url route=withAnyParam section=$current_section action=list name=$folder->getPath()}">{$folder->getName()}</a></td>
            <td>{$folder->getTitle()}</td>
            <td>{$folder->getJip()}</td>
        </tr>
    {/foreach}
</table>

Файлы:
<table border="1">
    <tr>
        <td>id</td>
        <td>оригинальное имя</td>
        <td>имя</td>
        <td>расширение</td>
        <td>размер</td>
        <td>jip</td>
    </tr>
    {foreach from=$files item=file}
        <tr>
            <td>{$file->getId()}</td>
            <td>{$file->getRealname()}</td>
            <td>{$file->getName()}</td>
            <td>{$file->getExt()}</td>
            <td>{$file->getSize()}</td>
            <td>{$file->getJip()}</td>
        </tr>
    {/foreach}
</table>