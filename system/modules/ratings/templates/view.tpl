{add file="ratings.css"}
{if !$isPost}
    {add file="prototype.js"}
    {add file="ratings.js"}
    <div id="rate_{$folder->getId()}">
{/if}

{* ширина изображения со звездами *}
{assign var="starimgwidth" value=25}

    <div class="rated_text">
        {_ rating} <span class="out5Class">{$folder->getRate()|round:1}</span>/{$starsCount} (<span class="percentClass">{$folder->getPercentRate()|round:2}%</span>) (<span class="votesClass">{_ votes_count $folder->getRateCount()}</span>)
    </div>
    <ul class="star-rating{if $myrate}-voted{/if}" style="width: {$starsCount*$starimgwidth}px;">
        <li class="current-rating" style="width: {$folder->getPercentRate()|round:2}%;">&nbsp;</li>
        {foreach from=$stars item="star" name="starsIterator"}
            <li><a onclick="{if !$myrate}javascript: rate(this.href, $('rate_{$folder->getId()}')); {/if}return false;" href="{if $myrate}#{else}{url route="withId" action="post" id=$folder->getId() _rate=$star}{/if}" title="{if $myrate}{$folder->getRate()|round:1}/{$starsCount}, {$folder->getPercentRate()|round:2}%, Ваша оценка: {$myrate->getRate()}{else}{$star}/5{/if}" style="z-index: {$starsCount-$smarty.foreach.starsIterator.iteration}; width: {math equation="(100 / x) * z" x=$starsCount z=$smarty.foreach.starsIterator.iteration}%;">{$star}</a></li>
        {/foreach}
    </ul>
    {if $isPost}
        {if $isSaved}<div class="voted"> Ваш голос ({$myrate->getRate()}) принят</div>{/if}
        {if $errors->get('rate')}<div class="voted_error">{$errors->get('rate')}</div>{/if}
    {/if}
{if !$isPost}</div>{/if}