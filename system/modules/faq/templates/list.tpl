<h2>{$faqCategory->getTitle()} {$faqCategory->getJip()}</h2>
{foreach from=$faqCategory->getAnswers() item="faq"}
    <strong>Q:{$faq->getQuestion()}</strong>{$faq->getJip()}<br />
    A:{$faq->getAnswer()|nl2br}<br /><br />
{foreachelse}
    Пусто
{/foreach}