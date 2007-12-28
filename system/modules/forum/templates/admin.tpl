<p class="pageTitle">Список категорий: {$categoryFolder->getJip()}</p>
<div class="pageContent">
{foreach from=$categories item="category" name="cat"}
    Категория <strong>{$category->getTitle()} {$category->getJip()}</strong>
    {foreach from=$category->getForums() item="forum" name="forums"}
    {if $smarty.foreach.forums.first}
        <table cellspacing="0" cellpadding="3" class="tableList" style="padding-left: 25px;">
            <thead class="tableListHead">
                <tr>
                    <td style="text-align: left;">Название</td>
                    <td style="width: 120px;text-align: center;">Количество тем</td>
                    <td style="width: 30px;">JIP</td>
                </tr>
            </thead>
    {/if}
        <tr>
            <td>{$forum->getTitle()}</td>
            <td style="text-align: center;">{$forum->getThreadsCount()}</td>
            <td style="text-align: center;">{$forum->getJip()}</td>
        </tr>
    {if $smarty.foreach.forums.last}
        </table>
    {/if}
    {foreachelse}
        <div style="padding-left: 25px;">Нет форумов в этой категории</div>
    {/foreach}
{if not $smarty.foreach.cat.last}
    <br /><br />
{/if}
{foreachelse}
    Нет категорий
{/foreach}
</div>