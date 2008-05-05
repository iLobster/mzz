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
            <li><a onclick="{if !$myrate}javascript: rate(this.href, $('rate_{$folder->getId()}')); {/if}return false;" href="{if $myrate}#{else}{url route="withId" action="post" id=$folder->getId() _rate=$stars[star]}{/if}" title="{if $myrate}{$folder->getRate()|round:1}/{$starsCount}, {$folder->getPercentRate()|round:2}%, Ваша оценка: {$myrate->getRate()}{else}{$stars[star]}/5{/if}" class="{if $stars[star] == 1}one-star{elseif $stars[star] == 2}two-stars{elseif $stars[star] == 3}three-stars{elseif $stars[star] == 4}four-stars{elseif $stars[star] == 5}five-stars{/if}">{$stars[star]}</a></li>
        {/section}
    </ul>
    {if $isPost}
        {if $isSaved}<div class="voted"> Ваш голос ({$myrate->getRate()}) принят</div>{/if}
        {if $errors->get('rate')}<div class="voted_error">{$errors->get('rate')}</div>{/if}
    {/if}
{if !$isPost}</div>{/if}