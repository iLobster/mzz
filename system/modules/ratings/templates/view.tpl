{add file="ratings.css"}
{if !$isPost}
    {add file="prototype.js"}
    {add file="ratings.js"}
    <div id="rate_{$folder->getId()}">
{/if}

    <div class="rated_text">
        {_ rating} <span class="out5Class">{$folder->getRate()|round:1}</span>/{$starsCount} (<span class="percentClass">{$folder->getPercentRate()|round:2}%</span>) (<span class="votesClass">{_ votes_count $folder->getRateCount()}</span>)
    </div>
    <ul class="star-rating{if $myrate}-voted{/if}">
        <li class="current-rating" style="width: {$folder->getPercentRate()|round:2}%;">&nbsp;</li>
        {section name="star" loop=$stars}
            <li><a onclick="javascript: rate(this.href, $('rate_{$folder->getId()}')); return false;" href="{url route="withId" action="post" id=$folder->getId() _rate=$stars[star]}" class="{if $stars[star] == 1}one-star{elseif $stars[star] == 2}two-stars{elseif $stars[star] == 3}three-stars{elseif $stars[star] == 4}four-stars{elseif $stars[star] == 5}five-stars{/if}">{$stars[star]}</a></li>
        {/section}
    </ul>
    {if $isPost}
        {if $isSaved}<div class="voted">Спасибо за Ваш голос ({$myrate->getRate()})</div>{/if}
        {if $errors->get('rate')}<div class="voted_error">{$errors->get('rate')}</div>{/if}
    {/if}
{if !$isPost}</div>{/if}