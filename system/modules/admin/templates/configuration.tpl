{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="jip.css"}
{add file="jip.js"}
<div class="pageTitle">Конфигурация модулей</div>
<div class="pageContent">



{foreach from=$info item=module key=module_name}
    {foreach from=$module item=section key=section_name}
        {assign var="name" value="`$section_name`_`$module_name`"}
        {if not empty($cfgAccess.$name)}
            <div class="configurationItem">
                <a href="{url route="withAnyParam" section="admin" name="`$section_name`/`$module_name`" action="editConfig"}" class="jipLink">
                <img src="{$SITE_PATH}/templates/images/config.gif" width="16" height="16" alt="configuration"/></a>
                <a href="{url route="withAnyParam" section="admin" name="`$section_name`/`$module_name`" action="editConfig"}" class="jipLink">
                {$section_name}</a> - {$module_name}
            </div>
        {/if}
    {/foreach}
{/foreach}

</div>
</div>
