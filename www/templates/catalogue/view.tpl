<a href="{url route="default2" section="catalogue" action="edit"}"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="настройка" title="Настройка" align="texttop" /></a>
<a href="{url route="default2" section="catalogue" action="add"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить" title="Добавить" align="texttop" /></a>
<br/><br/>
{foreach from=$items item="item"}
    {foreach from=$item->exportOldProperties() key="property" item="value"}
    {$item->getTitle($property)}: {$value}<br/>
    {/foreach}
    {$item->getJip()}
    <br/><br/>
{/foreach}