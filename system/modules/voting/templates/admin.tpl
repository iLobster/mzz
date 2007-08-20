<p class="pageTitle">Список категорий:{$folder->getJip()}</p>
{foreach from=$categories item="category"}
{$category->getTitle()} ({$category->getName()}){$category->getJip()}<br />
<table cellspacing="0" cellpadding="3" class="tableList">
    <thead class="tableListHead">
        <tr>
            <td style="width: 30px;">ID</td>
            <td style="text-align: left;">Вопрос</td>
            <td style="width: 120px;">Дата начала</td>
            <td style="width: 120px;">Дата окончания</td>
            <td style="width: 30px;">JIP</td>
        </tr>
    </thead>
    {foreach from=$category->getQuestions() item="question"}
        <tr>
            <td style="text-align: center;">{$question->getId()}</td>
            <td style="text-align: left;">{$question->getQuestion()}</td>
            <td style="width: 120px;text-align: center;">{$question->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td style="width: 120px;text-align: center;">{$question->getExpired()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td style="width: 30px;text-align: center;">{$question->getJip()}</td>
        </tr>
    {/foreach}
</table>
<br />
{/foreach}