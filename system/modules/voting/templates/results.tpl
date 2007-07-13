{$question->getQuestion()}{$question->getJip()} (Всего проголосовало: {$question->getResultsCount()})<br />
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getName()} : {$answer->getResults()}<br />
{/foreach}