{$question->getQuestion()}{$question->getJip()} (����� �������������: {$question->getResultsCount()})<br />
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getName()} : {$answer->getResults()}<br />
{/foreach}