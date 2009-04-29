{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="jip.css"}
{add file="jip.js"}
<div class="pageTitle">Конфигурация модулей</div>
<div class="pageContent">
{foreach from=$folders item="folder"}
    <div class="configurationItem">
        <a href="{url route="withAnyParam" section="config" name=$folder->getName() action="configure"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/config.gif" width="16" height="16" alt="configuration"/></a>
        <a href="{url route="withAnyParam" section="config" name=$folder->getName() action="configure"}" class="jipLink">{$folder->getName()|h}</a>
    </div>
{/foreach}

</div>
</div>