<p class="pageTitle">Список категорий:{$folder->getJip()}</p>
{foreach from=$categories item="category"}
<a href="{url route="withAnyParam" action="list" name=$category->getName()}">{$category->getTitle()} ({$category->getName()})</a>{$category->getJip()}<br />
<table cellspacing="0" cellpadding="3" class="tableList">
    <thead class="tableListHead">
        <tr>
            <td style="width: 30px;">ID</td>
            <td style="text-align: left;">Вопрос</td>
            <td style="width: 30px;">JIP</td>
        </tr>
    </thead>
    {foreach from=$category->getAnswers() item="answer"}
        <tr>
            <td style="text-align: center;">{$answer->getId()}</td>
            <td style="text-align: left;">{$answer->getQuestion()}</td>
            <td style="width: 30px;text-align: center;">{$answer->getJip()}</td>
        </tr>
    {/foreach}
</table>
<br />
{/foreach}