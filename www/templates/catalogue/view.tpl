<a href="{url route="default2" section="catalogue" action="add"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="��������" title="��������" align="texttop" /></a>
<br/><br/>
{foreach from=$items item="item"}
    {foreach from=$item->exportOldProperties() key="property" item="value"}
    {$item->getTitle($property)}: {$value}<br/>
    {/foreach}
    {$item->getJip()}
    <br/><br/>
{/foreach}