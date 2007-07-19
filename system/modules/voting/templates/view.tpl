{$question->getQuestion()}{$question->getJip()}<br />
<form action="{$action}" method="post">
{form->hidden name="url" id="backUrlField" value=$backURL}
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{if $answer->getTypeTitle() == 'radio'}
{form->radio name="answer" value=$answer->getId()} {$answer->getTitle()}<br />
{elseif $answer->getTypeTitle() == 'checkbox'}
{assign var="id" value=$answer->getId()}
{form->checkbox name="answer[$id]" value=$answer->getId()} {$answer->getTitle()}<br />
{elseif $answer->getTypeTitle() == 'text'}
{assign var="id" value=$answer->getId()}
{form->radio name="answer" value=$answer->getId()} {$answer->getTitle()}
{form->text name="answer_$id" value=""}<br />
{/if}
{/foreach}
<input type="submit" value="Проголосовать" />
</form>
<a href="{url route="withAnyParam" action="results" name=$question->getName()}">Результаты</a>