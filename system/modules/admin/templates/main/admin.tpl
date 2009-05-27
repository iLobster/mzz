{* main="admin/main/adminHeader.tpl" placeholder="content" *}
        <div id="header">
            <div class="bar">
                <div class="siteInfo">
                    <div class="glass">
                        <a href="/" class="logo">www.mzz.ru</a>
                    </div>
                </div>
                <div class="loginInfo">
                    login form
                </div>
            </div>
        </div>
        <div id="content" class="marginal">
            <div id="sidebar">
                <div class="title">Меню</div>
                {load module="admin" action="menu"}
            </div>
            <div id="mainbar">
{$content}
            </div>
            <div  style="clear: both"></div>

        </div>
        <div id="footer" class="marginal">
            <div class="foot">
                <div class="mid"></div>
                <div class="rig"></div>
            </div>
            <div class="timer">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}) 2005-{"Y"|date}. {$timer->toString('timer/admin/timer.tpl')}</div>
        </div>