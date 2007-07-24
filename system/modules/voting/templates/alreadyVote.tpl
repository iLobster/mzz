{$question->getQuestion()}{$question->getJip()}<br />
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getTitle()}<br />
{/foreach}
Вы уже отдали свой голос: 
{foreach from=$votes item="vote"}{$vote->getAnswer()->getTitle()}{if $vote->getAnswer()->getTypeTitle() == 'text'} ({$vote->getText()}){/if}, {/foreach}<br />
<a href="{url route="withAnyParam" action="results" name=$vote->getQuestion()->getName()}">Результаты</a>