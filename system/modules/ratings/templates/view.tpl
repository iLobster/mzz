{if !$myrate && !$errors->get('rate')}
    {add file="prototype.js"}
    {add file="ratings.js"}
    <form action="{url route="withId" action="" id=$folder->getParentId()}" method="post" onsubmit="javascript: sendRate(this, $('rate_{$folder->getParentId()}')); return false;">
        <div id="rate_{$folder->getParentId()}">
{/if}

{$folder->getRate()}<br />
{if $myrate}
    Моя оценка: {$myrate->getRate()}
{/if}
    <div>
        {$errors->get('rate')}
        {section name="star" loop=$stars}
            {form->radio name="rate" value=$stars[star] text=$stars[star]}
        {/section}
        {if !$myrate}
            <br />
            {form->submit name="rate_subm" value="Оценить"}
        {/if}
    </div>

{if !$myrate && !$errors->get('rate')}
        </div>
    </form>
{/if}