<p class="pageTitle">Список голосований:{$folder->getJip()}</p>
{foreach from=$questions item="question"}
{$question->getId()} {$question->getQuestion()}{$question->getJip()}<br />
{/foreach}