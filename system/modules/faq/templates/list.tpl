{title append="FAQ"}
{title append=$faqCategory->getTitle()|htmlspecialchars}
{include file="faq/categories.tpl" categories=$categories current=$faqCategory->getName()}
<h2>{$faqCategory->getTitle()} {$faqCategory->getJip()}</h2>
{foreach from=$faqCategory->getAnswers() item="faq"}
<a href="{url}#faq{$faq->getId()}">{$faq->getQuestion()}</a><br />
{/foreach}
<br /><br />
{foreach from=$faqCategory->getAnswers() item="faq"}
    <a name="faq{$faq->getId()}"></a><strong>Q:{$faq->getQuestion()}</strong>{$faq->getJip()}<br />
    A:{$faq->getAnswer()|nl2br}<br /><br />
{foreachelse}
    Пусто
{/foreach}