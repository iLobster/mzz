<p class="pageTitle">������ �����������:{$folder->getJip()}</p>
{foreach from=$questions item="question"}
{$question->getId()} {$question->getQuestion()}{$question->getJip()}<br />
{/foreach}