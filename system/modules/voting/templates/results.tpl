{$question->getQuestion()}{$question->getJip()} (����� �������������: {$question->getResultsCount()})<br />
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getTitle()} : {$answer->getResults()}<br />
{/foreach}