<p class="pageTitle">Список категорий:{$folder->getJip()}</p>
{foreach from=$categories item="category"}
{$category->getTitle()} ({$category->getName()}){$category->getJip()}<br />
{foreach from=$category->getQuestions() item="question"}
<strong>{$question->getId()}.</strong>{$question->getQuestion()} {$question->getJip()}<br />
{/foreach}
<br /><br />
{/foreach}