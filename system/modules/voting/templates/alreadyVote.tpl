{$question->getQuestion()}{$question->getJip()}<br />
{*
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getTitle()}<br />
{/foreach}
*}
��� ����� ������:
{foreach from=$votes item="vote"}
    {$vote->getAnswer()->getTitle()}
    {if $vote->getAnswer()->getTypeTitle() == 'text'} ({$vote->getText()|htmlspecialchars}){/if} 
{/foreach}<br />
<a href="{url route="withAnyParam" action="results" name=$vote->getQuestion()->getName()}">����������</a>