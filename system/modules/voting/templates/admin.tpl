<p class="pageTitle">������ �����������:{$folder->getJip()}</p>
{foreach from=$questions item="question"}
{$question->getQuestion()} (<strong>{$question->getName()}</strong>){$question->getJip()}<br />
    {foreach from=$question->getAnswers() item="answer"}
        
    {/foreach}
    <br /><br />
{/foreach}