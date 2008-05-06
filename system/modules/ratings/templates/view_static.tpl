{add file="ratings.css"}

{* ширина изображения со звездами *}
{assign var="starimgwidth" value=25}

    <div class="rated_text">
        {_ rating} <span class="out5Class">{$folder->getRate()|round:1}</span>/{$starsCount} (<span class="percentClass">{$folder->getPercentRate()|round:2}%</span>) (<span class="votesClass">{_ votes_count $folder->getRateCount()}</span>)
    </div>
    <ul class="star-rating-inactive" style="width: {$starsCount*$starimgwidth}px;">
        <li class="current-rating" style="width: {$folder->getPercentRate()|round:2}%;">&nbsp;</li>
        {foreach from=$stars item="star" name="starsIterator"}
            <li>
                <a onclick="return false;" href="#" title="{$folder->getRate()|round:1}/{$starsCount}, {$folder->getPercentRate()|round:2}%" style="z-index: {$starsCount-$smarty.foreach.starsIterator.iteration}; width: {math equation="(100 / x) * z" x=$starsCount z=$smarty.foreach.starsIterator.iteration}%;">{$star}</a>
            </li>
        {/foreach}
    </ul>