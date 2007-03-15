{* main="adminHeader.tpl" placeholder="content" *}

{*
    <div id="menu">
     <span class="menu_element"><a href="{url route=default2 section=news action=""}">{if $current_section eq "news"}<b>{/if}Новости{if $current_section eq "news"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=page action=""}">{if $current_section eq "page"}<b>{/if}Страницы{if $current_section eq "page"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=fileManager action=""}">{if $current_section eq "fileManager"}<b>{/if}Файлменеджер{if $current_section eq "fileManager"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route="default2" section="catalogue"}">{if $current_section eq "catalogue"}<b>{/if}Каталог{if $current_section eq "catalogue"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=user action=list}">{if $current_section eq "user"}<b>{/if}Пользователи{if $current_section eq "user"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=admin action=view}">{if $current_section eq "admin"}<b>{/if}Панель управления{if $current_section eq "admin"}</b>{/if}</a></span>
    </div>

    {load module="user" action="login" section="user" id=0 403handle="none"}
*}


<div id="page">
    <div id="header">
        <div class="loginInfo">{load module="user" action="login" section="user" id=0 403handle="none" tplPrefix="admin"}</div>
        <div class="siteName"><div>www.mzz.ru</div></div>
        <div class="favorite">
            <div>
                <img src="{$SITE_PATH}/templates/images/admin/favorite.png" class="favoriteIcon" width="14" height="15" alt="favorite" title="Избранное" />
                <span class="doubleSeparator">&nbsp;</span> <a href="#">Добавить новость</a>
                <span>&nbsp;</span> <a href="#">Добавить страницу</a>
            </div>
        </div>
    </div>
    {if not empty($menu)}
        <div id="sidebar">
            <p class="sideMenuTitle">Разделы сайта</p>
            {*<a href="{url route=withAnyParam section="admin" name="`$section_name`/`$module_name`" action="admin"}"> *}
            <table cellspacing="0" cellpadding="0">
            {foreach from=$menu item=module key=module_name}
                {if sizeof($module.sections) == 1}
                    <!--{$module_name} -->
                    <tr>
                        <td class="menuSectionImg"><img src="{$SITE_PATH}/templates/images/admin/{$module.icon}" width="24" height="24" alt="" /></td>
                        {assign var='section_name' value=$module.sections|@key}
                        <td class="menuSection"><a href="{url route=withAnyParam section="admin" name="`$section_name`/`$module_name`" action="admin"}">
                            {if $module_name eq $current_module}<strong>{/if}
                            {$module.title}
                            {if $module_name eq $current_module}</strong>{/if}
                        </a></td>
                    </tr>
                {else}
                    <tr>
                        <td class="menuSectionImg"><img src="{$SITE_PATH}/templates/images/admin/{$module.icon}" width="24" height="24" alt="" /></td>
                        <td class="menuSection">{$module.title}</td>
                    </tr>
                    {foreach from=$module.sections item=section key=section_name}
                        <tr>
                            <td>&nbsp;</td>
                            <td class="menuLink"><a href="{url route=withAnyParam section="admin" name="`$section_name`/`$module_name`" action="admin"}">
                                {if $module_name eq $current_module}{if $section_name eq $current_section}<strong>{/if}{/if}
                                {$section.title}
                                {if $module_name eq $current_module}{if $section_name eq $current_section}<strong>{/if}{/if}
                            </a></td>
                    </tr>
                    {/foreach}
                {/if}
            {/foreach}
            </table>
            <div class="patch_minheight"></div>
        </div>
    {/if}

    <div id="mainbar">
    {$content}
    <div class="patch_minheight"></div>
    </div>

    <div class="footer_guarantor">&nbsp;</div>
</div>

<div class="footer">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}) 2005-2007.


{load module="timer" action="view" section="timer" 403handle="none" tplPrefix="admin"}

</div>

</body>
</html>
