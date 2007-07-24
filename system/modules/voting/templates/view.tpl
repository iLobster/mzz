{$question->getQuestion()}{$question->getJip()}<br />
<form action="{$action}" method="post">
    {form->hidden name="url" id="backUrlField" value=$backURL}
{foreach name="answersIterator" from=$question->getAnswers() item="answer"}
{assign var="id" value=$answer->getId()}
{if $answer->getTypeTitle() == 'radio'}
    {form->radio name="answer[]" values="0|$id" text=$answer->getTitle() value=$id}<br />
{elseif $answer->getTypeTitle() == 'checkbox'}
    {form->checkbox name="answer[]" values="0|$id" text=$answer->getTitle() value=''}<br />
{elseif $answer->getTypeTitle() == 'text'}
    {form->radio name="answer[]" values="0|$id" text=$answer->getTitle() value=$id}
    {form->text name="answer_$id" value=""}<br />
{/if}
{/foreach}
{form->submit name="submit" value="Проголосовать"}
</form>
<a href="{url route="withAnyParam" action="results" name=$question->getName()}">Результаты</a>