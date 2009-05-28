{*add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="jip.css"}
{add file="jip.js"*}
{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="jquery-ui/effects.core.js"}
{add file="jquery-ui.css"}
{add file="jquery-ui/ui.draggable.js"}
{add file="jquery-ui/ui.resizable.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}
{add file="jip.css"}
{add file="jip/fileLoader.js"}
{add file="jip/window.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
<div class="yitle">Конфигурация модулей</div>
{foreach from=$folders item="folder"}
    <div class="configurationItem">
        <a href="{url route="withAnyParam" section="config" name=$folder->getName() action="configure"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/config.gif" width="16" height="16" alt="configuration"/></a>
        <a href="{url route="withAnyParam" section="config" name=$folder->getName() action="configure"}" class="jipLink">{$folder->getName()|h}</a>
    </div>
{/foreach}