{* main="admin/main/adminHeader.tpl" placeholder="content" *}
      <div id="adminBody">
          <div id="adminHeader" class="clearfix">
              <h1>
                  <a href="{$SITE_PATH}/" title="Visit Site">{$toolkit->getRequest()->getUrl()}/</a>
              </h1>
              <div class="userInfo">{load module="user" action="login" onlyForm=true tplPath="admin/"}</div>
          </div>
          <div id="adminWrap" class="clearfix">
              <div class="c-topLeft"></div>
              <div class="c-top"></div>
              <div class="c-topRight"></div>
              <div class="c-left"></div>
              <div class="c-right"></div>
              <div class="c-bottomLeft"></div>
              <div class="c-bottom"></div>
              <div class="c-bottomRight"></div>
              <div id="adminSidebar">
                {load module="admin" action="menu"}
              </div>
              <div id="adminPageWrap" class="clearfix">
                <div id="adminPage" class="clearfix">
                  <div class="c-topLeft"></div>
                  <div class="c-top"></div>
                  <div class="c-topRight"></div>
                  <div class="c-left"></div>
                  <div class="c-right"></div>
                  <div class="c-bottomLeft"></div>
                  <div class="c-bottom"></div>
                  <div class="c-bottomRight"></div>
                  {$content}
                </div>
              </div>
          </div>
          <div id="adminFooter"><span style="float:left"><a href="http://www.mzz.ru/">{$smarty.const.MZZ_NAME}</a> (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}) 2005-{"Y"|date} | <a href="http://www.mzz.ru/docs/">Documentation</a> | <a href="http://trac.mzz.ru">Trac</a></span> {$timer->toString('timer/admin/timer.tpl')}</div>
      </div>
{*<div id="header">
    <div class="bar">
        <div class="siteInfo">
            <div class="glass">
                <a href="{$SITE_PATH}/" class="logo" rel="homepage">{$toolkit->getRequest()->getUrl()}/</a>
            </div>
        </div>
        <div class="loginInfo">
            {load module="user" action="login" onlyForm=true tplPrefix="admin/"}
        </div>
    </div>
</div>
<div id="content" class="marginal">
    <div id="sidebar">
        {load module="admin" action="menu"}
    </div>
    <div id="mainbar">
        
    </div>
    <div  style="clear: both"></div>
</div>
<div id="footer" class="marginal">
    <div class="foot">
        <div class="mid"></div>
        <div class="rig"></div>
    </div>
</div>*}