{$question->getQuestion()}{$question->getJip()} (Всего проголосовало: {$question->getVotesCount()})<br />
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{$answer->getTitle()} : {$question->getResult($answer)}<br />
{/foreach}