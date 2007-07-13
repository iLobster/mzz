{$question->getQuestion()}{$question->getJip()}<br />
<form action="{$action}" method="post">
{form->hidden name="url" id="backUrlField" value=$backURL}
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{form->radio name="answer" value=$answer->getId()} {$answer->getName()}<br />
{/foreach}
<input type="submit" value="Проголосовать" />
</form>
<a href="{url route="withAnyParam" action="results" name=$question->getName()}">Результаты</a>