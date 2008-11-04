{$question->getQuestion()}{$question->getJip()}<br /> (Всего проголосовало: {$question->getResultsCount()})<br />
{*
{foreach name="answersIterator" from=$answers item="answer"}
{$answer->getTitle()}<br />
{/foreach}
*}
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getTitle()} : {$question->getResult($answer)}<br />
{/foreach}
Ваш голос:
{foreach from=$votes item="vote"}
    {$answers[$vote.answer_id]->getTitle()}
    {if $answers[$vote.answer_id]->getTypeTitle() == 'text'} ({$vote.text|htmlspecialchars}){/if}
{/foreach}<br />
<a href="{url route="withId" action="results" id=$question->getId()}">Результаты</a>