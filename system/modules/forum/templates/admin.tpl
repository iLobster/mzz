<div class="pageContent">
    <a href="{url route=default2 section=$current_section action=createCategory}" class="jipLink">Создать категорию</a><br /><br />

    <table border="1" width="100%">
        {foreach from=$categories item=category name=cat}
            <tr>
                <td>Категория: {$category->getTitle()} {$category->getJip()}</td>
            </tr>
            {foreach from=$category->getForums() item=forum}
                <tr>
                    <td>{$forum->getTitle()} {$forum->getJip()}</td>
                </tr>
            {/foreach}
            {if not $smarty.foreach.cat.last}
                <tr>
                    <td>&nbsp;</td>
                <tr>
            {/if}
        {/foreach}
    </table>
</div>