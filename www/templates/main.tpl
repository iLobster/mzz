{* main="header.tpl" placeholder="content" *}

<div id="wrapper">
    <div id="nonFooter">
        <div id="background_lines">
            <div id="hcontainer">
                <div><a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="141" height="40" alt="" /></a></div>
            </div>
        </div>
        <div id="menucontainer">
            <div id="navMenu">
                {load module="menu" section="menu" action="view" name="hmenu" tplPrefix="header" 403handle="none"}
            </div>
        </div>

        <div id="content">

            <div id="leftMainCol">
                <div id="container">
                    <!--  left column  -->
                    <div id="col1">
                        {load module="menu" section="menu" action="view" name="smenu" tplPrefix="side" 403handle="none"}
                        <div class="sideBlock">
                            {load module="user" action="loginForm" section="user" id=0 403handle="none"}
                        </div>
                    </div>

                    <!-- center column -->
                    <div id="col2">
                        {$content}
                    </div>
                </div>
            </div>
            {if $current_section != 'gallery'}
            <!-- right column -->
            <div id="col3">
                <div class="sideBlock">
                    <p class="sideBlockTitle">Опрос</p>
                    <div class="sideBlockContent">
                        {load module="voting" section="voting" action="viewActual" name="simple" 403handle="none"}
                    </div>
                </div>

                <div class="sideBlock">
                    <p class="sideBlockTitle">Фото дня</p>
                    <div class="sideBlockContent" style="text-align: center;">
                        <img src="{$SITE_PATH}/gallery/admin/3/6/viewThumbnail" alt="" />
                    </div>
                </div>

            </div>
            {/if}

            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="footer">
    <span>{$smarty.const.MZZ_NAME} v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION} &copy; 2007.<br />
    {$timer->toString()}</span>
</div>
</body>
</html>