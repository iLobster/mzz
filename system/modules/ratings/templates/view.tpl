{add file="ratings.css"}
{if !$myrate && $errors->isEmpty()}
    {add file="prototype.js"}
    <div id="rate_{$folder->getParentId()}">
{/if}

    <div class="rated_text">
        Оценка <span class="out5Class">{$folder->getRate()}</span>/{$starsCount} (<span class="percentClass">{$folder->getPercentRate()|round:2}%</span>) (<span class="votesClass">{$folder->getRateCount()} Votes</span>)
    </div>
    <ul class="star-rating{if $myrate}-voted{/if}">
        <li class="current-rating" style="width: {$folder->getPercentRate()|round:2}%;">&nbsp;</li>
        {section name="star" loop=$stars}
            {strip}
            <li><a onclick="{if !$myrate}
            new Ajax.Request('{url route="withId" action="" id=$folder->getParentId()}', {ldelim}
                method: 'post',
                parameters: {ldelim}rate: {$stars[star]}, rate_subm: true{rdelim},
                onSuccess: function(transport) {ldelim}
                    $('rate_{$folder->getParentId()}').update(transport.responseText);
                {rdelim}
            {rdelim});{/if}
            return false;" href="#" title="{$stars[star]} star out of {$starsCount}" class="
                {if $stars[star] == 1}
                    one-star
                {elseif $stars[star] == 2}
                    two-stars
                {elseif $stars[star] == 3}
                    three-stars
                {elseif $stars[star] == 4}
                    four-stars
                {elseif $stars[star] == 5}
                    five-stars
                {/if}
            ">{$stars[star]}</a></li>
            {/strip}
        {/section}
    </ul>
    <div style="display: block;">
        {if $errors->get('rate')}
            <div class="voted_error">{$errors->get('rate')}</div>
        {elseif $myrate}
            <div class="voted">Ваша оценка {$myrate->getRate()}</div>
        {/if}
    </div>

{if !$myrate && $errors->isEmpty()}
    </div>
{/if}