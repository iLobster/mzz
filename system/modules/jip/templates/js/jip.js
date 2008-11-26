/**
 *  CSS and Javascript Loader
 */
fileLoader = Class.create({
    initialize: function()
    {
        this.pendingFiles  = [];
        this.loadingIndex = 0;
        this.onLoad = function () {}
    },

    loadJS: function(url)
    {
        if ($$('script').any(function (jsElm) { return jsElm.src == url; })) {
            return;
        }

        var scriptTag = new Element('script', {type: 'text/javascript'});
        if (!window.opera) {
            scriptTag.observe('readystatechange', fileLoader.updateLoadingCount);
        }
        scriptTag.observe('load', fileLoader.updateLoadingCount);
        scriptTag.observe('error', fileLoader.updateLoadingCount);
        scriptTag.src = url + '?' + new Date().getTime();
        document.getElementsByTagName('head')[0].appendChild(scriptTag);
        this.pendingFiles[this.pendingFiles.length] = url;
    },

    loadCSS: function(url)
    {
        if ($$('link').any(function (jsElm) { return jsElm.href == url; })) {
            return;
        }

        var cssLink = new Element('link', {type: 'text/css', rel: 'stylesheet', href: url});
        document.getElementsByTagName('head')[0].appendChild(cssLink);
    },

    updateLoadingCount: function(evt)
    {
        evt = evt || event;
        var elem = evt.target || evt.srcElement;
        if (evt.type == 'readystatechange' && elem.readyState && !(elem.readyState == 'complete' || elem.readyState == 'loaded')) {
            return;
        }

        if (fileLoader.pendingFiles == 0) {
            return;
        }

        fileLoader.loadingIndex++;
        fileLoader.check();
    },

    check: function()
    {
        if (fileLoader.loadingIndex >= fileLoader.pendingFiles.length) { // loaded
            fileLoader.pendingFiles = [];
            fileLoader.loadingIndex = 0;
            fileLoader.onLoad();
        }
    },

    onJsLoad: function(func)
    {
        fileLoader.onLoad = func;
        fileLoader.check();
    }
});

var fileLoader = new fileLoader;
var jipI18n = {
    en: {
        loading: 'The page is loading...',
        refresh: 'The window is refreshing...',
        cancel: 'cancel',
        close: 'Close',
        move: 'Move',
        error: 'Unable to complete request. Please try again.',
        noWindow: 'No window to open the page.'

    },
    ru: {
        loading: 'Страница открывается...',
        refresh: 'Перезагрузка окна...',
        cancel: 'отменить',
        close: 'Закрыть',
        move: 'Переместить',
        error: 'Невозможно выполнить запрос. Попробуйте еще раз.',
        noWindow: 'Нет ни одно окна для открытия страницы.'
    }
};

function buildJipLinks(elm) {
    var jipLinkFunc = function(link) {
        $(link).observe('click', function(event) {
            jipWindow.open(link.href);
            Event.stop(event);
            return false;
        });
    }
    // @todo сделать опции
    if (elm) {
        $(elm).select('a.jipLink').each(jipLinkFunc);
    } else {
        $$('a.jipLink').each(jipLinkFunc);
    }
}

document.observe("dom:loaded", function() { buildJipLinks(); });


/**
 * Cookie tools
 * Made by Vinnie Garcia
 */
var Cookie = {
    set: function(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    },

    get: function(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);
        if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
        } else {
            begin += 2;
        }
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
        return unescape(dc.substring(begin + prefix.length, end));
    },

    remove: function(name, path, domain) {
        if (Cookie.get(name)) {
            document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        }
    }
}

jipWindow = Class.create({
    initialize: function() {
        this.jip = false;
        this.locker = false;
        this.stack = new Array;
        this.windowCount = 0;
        this.currentWindow = 0;
        this.toggleEditorStatus = $H();
        this.redirectAfterClose = false;
        this.windowExists = false;
        this.selectElements = $H({'jip': $A([])});
        this.drag = false;
        this.onJipLoadFunc = null;

        this.eventKeypress  = this.keyPress.bindAsEventListener(this);
        this.eventLockClick  = this.lockClick.bindAsEventListener(this);
        this.eventLockUpdate  = this.lockContent.bindAsEventListener(this);
        this.tinyMCEIds = new Array();
    },

    open: function(url, isNew, method, params)
    {
        isNew = isNew || false;
        params = params || {};
        method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';
        if (isNew || this.windowCount == 0) {
            this.currentWindow = this.windowCount++;
            if (this.currentWindow > 0) {
                this.hideSelects(this.currentWindow - 1);
            }
            this.stack[this.currentWindow] = new Array();
            var jipDiv = new Element('div', {id: 'jip' + this.currentWindow, 'class': 'jipWindow'});
            document.body.appendChild(jipDiv);
            if (this.jip) {
                this.jip.setStyle({'zIndex': 900});
            }
        } else {
            this.savePosition(this.jip);
        }

        if (!this.windowExists) {
            this.windowExists = true;
            document.observe("keypress", this.eventKeypress);
        }

        this.jip = $('jip' + this.currentWindow);

        if (this.jip) {
            this.lockContent();
            this.clean();
            this.jip.setStyle({display: 'block'});

            var jipWindowOffsetTop = null;
            var jipWindowOffsetLeft = null;
            var jipWindowOffsets = Cookie.get('jip_pos');
            if (jipWindowOffsets != null) {
                jipWindowOffsets = jipWindowOffsets.match(/(\d+),(\d+)/);
                jipWindowOffsetTop = jipWindowOffsets[1];
                jipWindowOffsetLeft = jipWindowOffsets[2];
            }

            if (jipWindowOffsetTop == null || jipWindowOffsetLeft == null) {
                jipWindowOffsetTop = this.jip.offsetHeight;
                jipWindowOffsetLeft = this.jip.offsetLeft;
            }
            var topScroll = (new Number(document.documentElement.scrollTop) > 0) ? document.documentElement.scrollTop : document.body.scrollTop;

            this.jip.setStyle({
            'top': new Number(jipWindowOffsetTop) + (this.currentWindow * 20) + new Number(topScroll) + 'px',
            'left': new Number(jipWindowOffsetLeft)  + (this.currentWindow * 20) + 'px'
            });

            new Ajax.Request(url, {
            'method': method,
            parameters: $H({'ajax': 1}).merge(params),
            onSuccess: function(transport) {
                jipWindow.successRequest(transport);
            },
            onFailure: function(transport) {
                jipWindow.setErrorMsg(transport);
            }});

            if(url.match(/[&\?]_confirm=/) == null) {
                this.stack[this.currentWindow].push(url);
            }

            return false;
        }
        return true;
    },

    close: function(windows)
    {
        if(this.jip) {
            document.stopObserving("keypress", this.eventKeypress);
            // избавляемся от "вспышки" в IE
            if(Prototype.Browser.IE) {
                $A(this.jip.getElementsByTagName('select')).each(function (elm) {
                    $(elm).setStyle({visibility: "hidden"});
                });
            }
            //this.savePosition(this.jip);
            this.tinyMCEIds.each(function(id) { tinyMCE.execCommand('mceRemoveControl', false, id); jipWindow.deleteTinyMCEId(id); });
            this.oncloseEvents = new Array();
            windows = (windows >= 0) ? windows : 1;
            var currentWin = this.currentWindow;
            var stack = this.stack[currentWin];
            if (typeof(tinyMCE) != 'undefined') {
                this.toggleEditorStatus.each(function(pair) {
                    tinyMCE.execCommand('mceRemoveEditor' , false, pair.key);
                });

                this.toggleEditorStatus = $H();
            }
            if (stack.length > 0) {
                var i = 0;
                for (var i = 0; i < windows; i++) {
                    stack.pop();
                }
                var prevUrl = stack.pop();
                if (prevUrl != undefined) {
                    if (this.drag) {
                        this.drag.destroy();
                    }
                    document.observe("keypress", this.eventKeypress);
                    return this.open(prevUrl);
                }
            } else {
                // нужно?
                this.currentWindow--;
            }
            this.jip = $('jip' + (currentWin));
            var jipParent = this.jip.parentNode;
            //this.clean();
            if (this.redirectAfterClose) {
                if (this.redirectAfterClose === true) {
                    window.location.reload();
                } else {
                    window.location = this.redirectAfterClose;
                }
                this.setRefreshMsg();
                this.redirectAfterClose = false;
                return true;
            }

            if(--this.windowCount == 0) {
                this.savePosition(this.jip);
                this.jip.setStyle({display: 'none'});

                if (this.drag) {
                    this.drag.destroy();
                    this.drag = false;
                }
                this.windowExists = false;
                this.unlockContent();
                jipParent.removeChild(this.jip);
                jipParent = null;
                this.jip = false;
                this.currentWindow = 0;
                this.stack = new Array();
            } else {
                var closedJip = this.jip;
                new Effect.DropOut('jip' + (this.currentWindow), {
                    afterFinish: function() {
                        closedJip.setStyle({display: 'none'});
                        jipParent.removeChild(closedJip);
                        closedJip = null;
                    }
                });

                this.jip = $('jip' + (--this.currentWindow));
                document.observe("keypress", this.eventKeypress);
                this.jip.setStyle({zIndex: 902});
                this.showSelects(this.currentWindow);
            }
        }
    },

    successRequest: function(transport)
    {
        this.element = this.jip;
        if (Object.isUndefined(this.jip)) {
            alert(jipI18n[SITE_LANG].noWindow);
            return false;
        }
        if (Object.isUndefined(transport.responseXML) && Object.isUndefined(transport.responseText)) {
            this.setErrorMsg();
            return false;
        }

        this.jip.update('<div class="jipClose"><img class="jip" width="12" height="12" src="' + SITE_PATH + '/templates/images/jip/close.gif" onclick="javascript: jipWindow.close();" alt="' + jipI18n[SITE_LANG].close + '" title="' + jipI18n[SITE_LANG].close + '" /></div>');

        var tmp = '';
        var ctype = transport.getResponseHeader("content-type");
        if (!Object.isUndefined(transport.responseXML) && ctype.indexOf("xml") >= 0) {
            responseXML = transport.responseXML.documentElement;
            var item = responseXML.getElementsByTagName('html')[0];
            if (!Object.isUndefined(item)) {
                var cnodes = item.childNodes.length;
                for (var i=0; i<cnodes; i++) {
                    if (item.childNodes[i].data != '') {
                        tmp += item.childNodes[i].data;
                    }
                }
            }
        } else {
            tmp = transport.responseText;
        }
        if (tmp == '') {
            this.setErrorMsg();
        }

        this.jip.update(this.jip.innerHTML + tmp);

        var jipTitle = '';
        var jipClose = '';
        var currentElement = '';
        for (var i = 0; i < 5; i++) {
            currentElement = this.jip.childNodes[i];

            if (Object.isElement(currentElement) && $(currentElement).hasClassName('jipTitle')) {
                jipTitle = currentElement;
            } else if (Object.isElement(currentElement) && $(currentElement).hasClassName('jipClose')) {
                jipClose = currentElement;
            }
            if (jipTitle != '' && jipClose != '') {
                i = -1;
                break;
            }
        }

        if (i == -1) {
            jipTitle = jipTitle.remove();
            jipClose = jipClose.remove();
            this.jip.update('<div style="padding: 10px;">' + this.jip.innerHTML + '</div>');
            this.jip.insert({top: jipTitle});
            this.jip.insert({top: jipClose});

            var jipMoveDiv = new Element('div', {id: 'jip-' + jipTitle.parentNode.id, title: jipI18n[SITE_LANG].move, 'class': 'jipMove'});
            jipTitle.insert({top: jipMoveDiv});
            this.drag = new Draggable('jip' + jipWindow.currentWindow, {
            'handle': 'jip-' + jipTitle.parentNode.id,
            'onStart': function() {
                this.defaultsHandlers = [document.body.ondrag, document.body.onselectstart];
                document.body.ondrag = function () { return false; }
                document.body.onselectstart = function () { return false; }
                jipWindow.hideSelects('jips');
            },
            'onEnd': function() {
                document.body.ondrag = this.defaultsHandlers[0];
                document.body.onselectstart = this.defaultsHandlers[1];
                jipWindow.lockContent();
                jipWindow.showSelects('jips');
            }
            });
        }
        this.lockContent();
        buildJipLinks(this.jip);
        window.setTimeout(function () {
            if (jipWindow.onJipLoadFunc) {
                jipWindow.onJipLoadFunc();
                jipWindow.onJipLoadFunc = null;
           }
        }, 1);
    },

    getPageHeight: function()
    {
        var yScroll, windowHeight;

        if (window.innerHeight && window.scrollMaxY) {
            yScroll = window.innerHeight + window.scrollMaxY;
        } else if (document.body.scrollHeight > document.body.offsetHeight){
            yScroll = document.body.scrollHeight;
        } else if (document.documentElement && document.documentElement.scrollHeight > document.documentElement.offsetHeight){
            yScroll = document.documentElement.scrollHeight;
        } else {
            yScroll = document.body.offsetHeight;
        }

        if (self.innerHeight) {
            windowHeight = self.innerHeight;
        } else if (document.documentElement && document.documentElement.clientHeight) {
            windowHeight = document.documentElement.clientHeight;
        } else if (document.body) {
            windowHeight = document.body.clientHeight;
        }
        return (yScroll < windowHeight) ? windowHeight : yScroll;
    },

    lockContent: function()
    {
        if (!this.windowCount) {
            return false;
        }
        var pageHeight = this.getPageHeight();

        if (!this.locker) {
            this.locker = new Element('div', {id: 'lockContent'});
            this.locker.id = 'lockContent';
            Element.extend(this.locker);
            $(document.body).insert({top: this.locker});
        }

        if (Prototype.Browser.IE) {
            var cumulativeOffsets = Position.cumulativeOffset(this.jip);
            var diff = (this.jip.offsetHeight + cumulativeOffsets[1]) - pageHeight;
            if (diff > 0) {
                pageHeight += diff;
            }
        }

        this.locker.setStyle({height: pageHeight +  "px"});

        if (this.locker.getStyle('display') != 'block') {
            Event.observe(window, "resize", this.eventLockUpdate);
            this.locker.observe("click", this.eventLockClick);
            this.locker.setStyle({opacity: 0.01, display: 'block'});
            this.setOpacityEffect();
            // hide select elements
            this.hideSelects();
        }
    },

    unlockContent: function()
    {
        if (this.locker && this.locker.getStyle('display') == 'block') {
            this.locker.stopObserving("click", this.eventLockClick);
            Event.stopObserving(window, "resize", this.eventLockUpdate);
            this.setOpacityEffect({
            "from": 0.8,
            "to": 0,
            "afterFinish": function () {
                jipWindow.locker.setStyle({opacity: 0.01, display: 'none'});
                jipWindow.showSelects();
            }
            });
        }
    },

    hideSelects: function()
    {
        if (Prototype.Browser.IE) {
            var jipId = (arguments.length > 0) ? $A(arguments).last() : false;
            var id = (jipId !== false) ? (jipId == 'jips' ? '.jipWindow ' : '#jip' + jipId + ' ') : '';
            var selectElements = $$(id + 'select');

            selectElements.each(function (elm, index) {
                if (elm.getStyle('visibility') == 'hidden') {
                    selectElements[index] = null;
                    delete selectElements[index];
                } else {
                    elm.setStyle({visibility: 'hidden'});
                }
            });

            if (jipId === false) {
                jipWindow.selectElements.set('browserWindow', selectElements);
            } else {
                if (jipId == 'jips') {
                    jipWindow.selectElements.set('jipWindow', selectElements);
                } else {
                    var jips = jipWindow.selectElements.get('jip');
                    jips[jipId] = selectElements;
                    jipWindow.selectElements.set('jip', jips);
                }
            }
        }
    },

    showSelects: function()
    {
        if (Prototype.Browser.IE) {
            var jipId = (arguments.length > 0) ? $A(arguments).last() : false;
            var showSelect = function (elm) { if (elm) elm.setStyle({visibility: 'visible'}); };
            if (jipId === false) {
                if (Object.isUndefined(jipWindow.selectElements.get('browserWindow'))) {
                    return;
                }
                jipWindow.selectElements.get('browserWindow').each(showSelect);
                jipWindow.selectElements.set('browserWindow', $H());
            } else if (jipId == 'jips') {
                var selects = jipWindow.selectElements.get('jipWindow');
                if (Object.isUndefined(selects)) {
                    return;
                }
                jipWindow.selectElements.get('jipWindow').each(showSelect);
                jipWindow.selectElements.set('jipWindow', $H());
            } else {alert(1);
                var jips = jipWindow.selectElements.get('jip');
                if (Object.isUndefined(jips[jipId])) {
                    return;
                }
                jips[jipId].each(showSelect);
                jips[jipId] = $H();
                jipWindow.selectElements.set('jip', jips);
            }
        }
    },

    autoSize: function()
    {
        var offsets = Position.cumulativeOffset(this.jip);
        var topOffset = parseInt(offsets[1]) - new Number(document.documentElement.scrollTop);
        topOffset = (topOffset >= 0) ? topOffset : 0;
        if (document.viewport.getHeight() - (this.jip.getHeight() + topOffset) < 0) {
            var newHeight = (document.viewport.getHeight() - topOffset * 2);
            newHeight = newHeight < 150 ? 150 : newHeight;
            this.jip.setStyle({height: newHeight + 'px'});
        }
    },

    onJipLoad: function(func)
    {
        this.onJipLoadFunc = func;
    },

    addTinyMCEId: function(id)
    {
        this.tinyMCEIds[this.tinyMCEIds.length] = id;
    },

    deleteTinyMCEId: function(id)
    {
        this.tinyMCEIds = this.tinyMCEIds.without(id);
    },

    sendForm: function(form)
    {
        var params = $(form).serialize(true);

        params.ajax = 1;
        jipWindow.clean();
        $(form).request({
            parameters: params,
            onSuccess: function(transport) {
                jipWindow.successRequest(transport);
            },
            onFailure: function(transport) {
                jipWindow.setErrorMsg(transport);
            }
        });
        return false;
    },

    setOpacityEffect: function() {
        var options = Object.extend({
        "from": 0,
        "to": 0.8,
        "duration": 0.3,
        "fps": 500
        }, arguments[0] || {});

        new Effect.Opacity(this.locker, options);
    },

    refreshAfterClose: function(url)
    {
        url = url || true;
        if (url === true) {
            this.redirectAfterClose = true;
        } else {
            this.redirectAfterClose = url;
        }
    },

    savePosition: function(jip)
    {
        // убрать после 1 декабря 08 :)
        Cookie.remove('jip_window_top');
        Cookie.remove('jip_window_left');
        var cookiePath = (SITE_PATH == '') ? '/' : SITE_PATH;
        var cookieLifeTime = new Date(new Date().getTime() + 50000000000);
        var offsets = Position.cumulativeOffset(jip);
        var topOffset = parseInt(offsets[1]) - new Number(document.documentElement.scrollTop);
        var leftOffset = (offsets[0] >= 0) ? offsets[0] : 0;
        topOffset = (topOffset >= 0) ? topOffset : 0;
        Cookie.set('jip_pos', topOffset + ',' + leftOffset, cookieLifeTime, cookiePath);
    },

    clean: function()
    {
        if (this.drag) {
            this.drag.destroy();
            this.drag = false;
        }
        if (this.jip) {
            this.jip.update('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/statusbar2.gif" width="32" height="32" /><br />' + jipI18n[SITE_LANG].loading + '<br /><a href="javascript: void(jipWindow.close());">' + jipI18n[SITE_LANG].cancel + '</a></div>');
        }
    },

    setRefreshMsg: function()
    {
        if (this.jip) {
            this.jip.update('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/statusbar3.gif" width="32" height="32" /><br />' + jipI18n[SITE_LANG].refresh + '</div>');
        }
    },

    setErrorMsg: function()
    {
        if (this.jip) {
            this.jip.update('<p align=center>' + jipI18n[SITE_LANG].error + '</p>');
        }
    },

    keyPress: function(event)
    {
        if(event.keyCode == Event.KEY_ESC) {
            jipWindow.close();
            Event.stop(event);
            return false;
        }
    },

    lockClick: function(event)
    {
        // fix double click
        this.locker.stopObserving("click", this.eventLockClick);

        new Effect.Highlight(this.jip.select('.jipTitle').last(), {
        "afterFinish": function () {
            jipWindow.locker.observe("click", jipWindow.eventLockClick);
        }});
        Event.stop(event);
    }
});

var jipWindow = new jipWindow;



/**
 * JIP Menu
 */
jipMenu = Class.create({
    initialize: function() {
        this.jipButton = false;
        this.eventMouseOut = this.mouseOut.bindAsEventListener(this);
        this.eventMouseIn = this.mouseIn.bindAsEventListener(this);
        this.layertimer = false;
        this.current = $H({"menu": false, "button": false});
        this.eventKeypress  = this.keyPress.bindAsEventListener(this);
        this.eventDocumentClick  = this.documentClick.bindAsEventListener(this);
        this.eventResize  = this.setPosition.bindAsEventListener(this);
        this.jipMenu = false;
        this.langs = {};
        this.jipLangMenu = false;
        this.langTimer = $H({});
        this.langParent = null;
        //this.closeTimer = false;
    },

    keyPress: function(event) {
        if (event.keyCode == Event.KEY_ESC && this.current.get('menu') != false && this.current.get('button') != false) {
            this.close();
        }
    },

    documentClick: function(event) {
        if (event.isLeftClick() && this.current.get('menu') != false && this.current.get('button') != false) {
            this.close();
        }
    },

    show: function(button, menuId, items, langs) {
        id = 'jip_menu_' + menuId;
        // open if closed
        if(!$(id) || $(id).getStyle('display') == 'none') {
            if (this.current.get('menu') != false && this.current.get('button') != false) {
                this.close();
            }
            //(function () {
            if (langs) this.langs = langs;
            jipMenu.current.set('menu', id);
            jipMenu.current.set('button', button);
            jipMenu.draw(button, id, items);
            //}).delay(this.closeTimer ? 11 : 0);
        } else {
            this.close();
        }
    },

    mouseIn: function() {
        if (this.layertimer) {
            clearTimeout(this.layertimer);
            this.layertimer = null;
        }
    },

    mouseOut: function() {
        if (this.layertimer) {
            this.mouseIn();
        }
        if (this.current.get('menu')) {
            this.layertimer = setTimeout("jipMenu.close()", 1000);
        }
    },

    close: function(immediately) {
        this.closeLang(immediately);
        this.jipMenu.setStyle({'display': 'none'});

        this.jipMenu.stopObserving("mouseout", this.eventMouseOut);
        this.jipMenu.stopObserving("mouseover", this.eventMouseIn);
        document.stopObserving("keypress", this.eventKeypress);
        document.stopObserving("click", this.eventDocumentClick);
        Event.stopObserving(window, "resize", this.eventResize);
        this.current.get('button').writeAttribute('src',  SITE_PATH + '/templates/images/jip.gif');
        this.mouseIn();
        this.current = $H({'menu': false, 'button': false});
        //this.closeTimer = setTimeout(function () { jipMenu.jipMenu.parentNode.removeChild(jipMenu.jipMenu); jipMenu.jipMenu = false; }, 10);
        //this.jipMenu.parentNode.removeChild(jipMenu.jipMenu);
        this.jipMenu = false;
        this.jipButton = false;
    },

    closeLang: function(immediately) {
        if (!this.jipLangMenu) return;

        $(this.langParent).cells[1].removeClassName('jipItemTextWithLanguage');
        $(this.langParent).cells[1].removeClassName('jipItemTextActive');
        this.langParent = null;
        if (immediately) this.jipLangMenu.setStyle({'display': 'none'});
        else Effect.Fade(this.jipLangMenu.identify(), { duration: 0.2 });

        this.jipLangMenu.stopObserving("mouseout", this.eventMouseOut);
        this.jipLangMenu.stopObserving("mouseover", this.eventMouseIn);
        this.jipLangMenu = false;
    },

    setLangTimer: function (type, id)
    {
        var timer = this.langTimer.get(type);
        if (timer) {
            window.clearTimeout(timer);
            this.langTimer.set(type, null)
        }
        this.langTimer.set(type, id)
    },

    draw: function(button, id, items) {
        //var jip_win = $('jip' + jipWindow.currentWindow);

        if (!$(id)) {
            var jipMenuDiv = new Element('div', {id: id, 'class': 'jipMenu', style: 'display: none;'});
            var jipMenuTable = new Element('table', {'class': 'jipItems', cellPadding: 3, cellSpacing: 0});
            var jipMenuTbody = new Element('tbody');
            $A(items).each(function (elm, i) {
                var jipMenuTableTR = new Element('tr', {id: id + '_' + i});

                jipMenuTableTR.observe('click', function (event) {
                    if (elm[3] == true) {
                        jipMenu.drawLang(jipMenuTableTR, elm[1]);
                        jipMenu.setLangTimer('open', null);
                        return false;
                    } else {
                        jipMenu.close();
                        return jipWindow.open(elm[1]);
                    }
                });

                jipMenuTableTR.observe('mouseout', function () {
                    jipMenuTableTR.cells[1].removeClassName('jipItemTextActive');
                    if (jipMenu.langParent) {
                        $(jipMenu.langParent).cells[1].addClassName('jipItemTextActive');
                    }
                    jipMenu.setLangTimer('open', null);
                });

                jipMenuTableTR.observe('mouseover', function (event) {
                    jipMenuTableTR.cells[1].addClassName('jipItemTextActive');
                    if (jipMenu.langParent && $(jipMenu.langParent).identify() != jipMenuTableTR.identify()) {
                        $(jipMenu.langParent).cells[1].removeClassName('jipItemTextActive');
                    }
                    if (elm[3] == true) {
                        jipMenu.setLangTimer('open', (function () { jipMenu.drawLang(jipMenuTableTR, elm[1]); }).delay(0.5));
                        jipMenuTableTR.observe('click', Event.stop);
                    } else {
                        jipMenu.closeLang();
                    }
                });

                var jipMenuTdTitle = new Element('td', {'class': 'jipItemText' + (elm[3] == true ? ' jipItemTextWithLang': '')});
                jipMenuTdTitle.update(elm[0]);
                var jipMenuTdIcon = new Element('td', {'class': 'jipItemIcon'});
                var jipMenuItemImg = new Element('img', {src: elm[2], height: 16, width: 16});
                var jipMenuItemA = new Element('a', {href: elm[1]});
                jipMenuItemA.observe('click', function(event) {
                    jipMenu.close();
                    event.stop();
                    return jipWindow.open(elm[1]);
                });

                jipMenuItemA.appendChild(jipMenuItemImg);
                jipMenuTdIcon.appendChild(jipMenuItemA);
                jipMenuTableTR.appendChild(jipMenuTdIcon);
                jipMenuTableTR.appendChild(jipMenuTdTitle);
                jipMenuTbody.appendChild(jipMenuTableTR);
            });

            jipMenuTable.appendChild(jipMenuTbody);
            jipMenuDiv.appendChild(jipMenuTable);
            $(document.body).insert({bottom: jipMenuDiv});
        } else {
            var jipMenuDiv = $(id);
            jipMenuDiv.setStyle({display: 'inline'});
        }
        jipMenuDiv.observe("mouseout", this.eventMouseOut);
        jipMenuDiv.observe("mouseover", this.eventMouseIn);
        document.observe("keypress", this.eventKeypress);
        (function () { document.observe("click", jipMenu.eventDocumentClick); }).defer();
        //window.observe("resize", this.eventResize());
        Event.observe(window, "resize", this.eventResize);

        //this.mouseOut();

        this.jipButton = $(button);
        this.jipMenu = jipMenuDiv;
        this.jipButton.writeAttribute('src', SITE_PATH + '/templates/images/jip_active.gif');
        this.prepareDiv(jipMenuDiv);
        this.setPosition();
    },

    setPosition: function()
    {
        var jip_win = $('jip' + jipWindow.currentWindow);
        var body = (jip_win && jip_win.getStyle('display') == 'block') ? jip_win : document.documentElement;
        var posScroll = Position.realOffset(document.documentElement);

        var size = Element.getDimensions(this.jipMenu);
        var buttonSize = Element.getDimensions(this.jipButton);
        var pos = Position.cumulativeOffset(this.jipButton);
        if (Position.within(body, pos[0] + size.width - posScroll[0], 0)) {
            var x = pos[0] + 1;
        } else {
            var x = pos[0] - size.width + buttonSize.width - 1;
        }

        if (Position.within(body, 0, pos[1] + size.height + 10 - posScroll[1])) {
            var y = pos[1] + buttonSize.height + 1;
        } else {
            var y = pos[1] - size.height - buttonSize.height + 8;
        }

        x = (x < 0) ? 0 : x;
        y = (y < 0) ? 0 : y;

        this.jipMenu.setStyle({
            left: x + 'px', top: y + 1 + 'px'
        });
    },

    drawLang: function(parentItem, link) {
        var id = parentItem.identify();
        //parentItem.stopObserving('mouseout');

        //id = id.sub(/(\d+)$/, 'lang_#{1}');
        var itemNumber = 0;
        id = id.sub(/(\d+)$/, function(match){
            itemOrder = match[1];
            return 'lang_' + match[1];
        });

        if (this.jipLangMenu) {
            if (this.jipLangMenu.identify() == id) return;
            else jipMenu.closeLang();
        }

        this.langParent = parentItem.identify();
        parentItem.cells[1].addClassName('jipItemTextWithLanguage');

        if(!$(id)) {
            var jipMenuDiv = new Element('div', {id: id, 'class': 'jipMenu', style: 'display: none;'});
            var jipMenuTable = new Element('table', {'class': 'jipItems', cellPadding: 3, cellSpacing: 0});
            var jipMenuTbody = new Element('tbody');
            $H(this.langs).each(function (pair) {
                var linkWithLang = link + '?lang_id=' + pair.key;
                var jipMenuTableTR = new Element('tr');

                jipMenuTableTR.observe('click', function () {
                    jipMenu.close(true);
                    return jipWindow.open(linkWithLang);
                });

                jipMenuTableTR.observe('mouseout', function () {
                    //parentItem.cells[1].removeClassName('jipItemTextActive');
                    jipMenuTableTR.cells[1].removeClassName('jipItemTextActive');
                });

                jipMenuTableTR.observe('mouseover', function () {
                    //parentItem.cells[1].addClassName('jipItemTextActive');
                    jipMenuTableTR.cells[1].addClassName('jipItemTextActive');
                });

                var jipMenuTdTitle = new Element('td', {'class': 'jipItemText'});
                jipMenuTdTitle.update(pair.value[1]);

                var jipMenuTdIcon = new Element('td', {'class': 'jipItemIcon', style: 'height: 22px;'});
                var jipMenuItemImg = new Element('img', {
                    src: SITE_PATH + '/templates/images/langs/' + pair.value[0] + '.png',
                    height: 11,
                    width: 16
                });
                var jipMenuItemA = new Element('a', {href: linkWithLang});
                jipMenuItemA.observe('click', function(event) {
                    jipMenu.close(true);
                    event.stop();
                    return jipWindow.open(linkWithLang);
                });

                jipMenuItemA.appendChild(jipMenuItemImg);
                jipMenuTdIcon.appendChild(jipMenuItemA);
                jipMenuTableTR.appendChild(jipMenuTdIcon);
                jipMenuTableTR.appendChild(jipMenuTdTitle);
                jipMenuTbody.appendChild(jipMenuTableTR);
            });
            jipMenuTable.appendChild(jipMenuTbody);
            jipMenuDiv.appendChild(jipMenuTable);
            $(document.body).insert({bottom: jipMenuDiv});
        } else {
            var jipMenuDiv = $(id);
            if (jipMenuDiv.getStyle('display') != 'none') return;
            //jipMenuDiv.setStyle({display: 'inline'});
        }

        this.prepareDiv(jipMenuDiv);

        var jip_win = $('jip' + jipWindow.currentWindow);
        var body = (jip_win && jip_win.getStyle('display') == 'block') ? jip_win : document.documentElement;

        var leftOffset = parseInt(this.jipMenu.getStyle('left'));
        var y = parseInt(this.jipMenu.getStyle('top')) + (parentItem.getHeight() + 3) * itemOrder;

        var posScroll = Position.realOffset(document.documentElement);

        if (Position.within(body, leftOffset + this.jipMenu.getWidth() + jipMenuDiv.getWidth() + 2 - posScroll[0], 0)) {
            var x = leftOffset + this.jipMenu.getWidth() + 2;
        } else {
            var x = leftOffset - this.jipMenu.getWidth() - 2;
        }

        this.jipLangMenu = jipMenuDiv;
        this.jipLangMenu.setStyle({
            left: x + 'px', top: y + 'px', display: 'none'
        });
        this.jipLangMenu.observe("mouseout", this.eventMouseOut);
        this.jipLangMenu.observe("mouseover", this.eventMouseIn);

        new Effect.Appear(this.jipLangMenu, { duration: 0.2 });
    },

    prepareDiv: function (elm)
    {
        elm.setStyle({
            top: '-500px',
            left: '-500px',
            display: 'block'
        });
    }
});
var jipMenu = new jipMenu;
