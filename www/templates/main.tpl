{* main="header.tpl" placeholder="content" *}

<div id="wrapper">
    <div id="nonFooter">
        <div id="hbackground">
            <div id="hcontainer">
                <div><a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="146" height="42" alt="" /></a></div>
            </div>
        </div>
        <div id="menucontainer">
            <div id="navMenu">
                {load module="menu" section="menu" action="view" name="hmenu" tplPrefix="header" 403handle="none"}
            </div>
        </div>

        <div class="headerBorderLine"><img src="{$SITE_PATH}/templates/images/spacer.gif" width="1" height="2" /></div>
        <div id="content">

            <div id="leftMainCol">
                <div id="container">
                    <!--  left column  -->
                    <div id="col1">
                        <ul class="sideMenu">
                            <li><a href="#">Новости</a>
                            <ul>
                                <li><a href="#">Компании</a></li>
                                <li><a href="#">Партнеров</a></li>
                                <li><a href="#">Клиентам</a></li>
                            </ul></li>
                            <li><a href="#">Каталог</a></li>
                            <li><a href="#">Галерея</a></li>
                            <li><a href="#">Пользователи</a></li>
                            <li><a href="#">Форум</a></li>
                            <li><a href="#">Вопросы и ответы</a></li>
                            <li><a href="#">О нас</a></li>
                        </ul>
                        <div class="sideBlock">
                            {load module="user" action="loginForm" section="user" id=0 403handle="none"}
                        </div>
                    </div>

                    <!-- center column -->
                    <div id="col2">
                        {$content}
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            {if $current_section != 'gallery'}
            <!-- right column -->
            <div id="col3">
                <div class="sideBlock">
                    <p class="sideBlockTitle">Опрос</p>
                    <div class="sideBlockContent">
                        {load module="voting" section="voting" action="viewActual" name="simple"}
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