function getBrowserHeight() {
    var yScroll, windowHeight, pageHeight;

    if (window.innerHeight && window.scrollMaxY) {
        yScroll = window.innerHeight + window.scrollMaxY;
    } else if (document.body.scrollHeight > document.body.offsetHeight){
        yScroll = document.body.scrollHeight;
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
    pageHeight = (yScroll < windowHeight) ? windowHeight : yScroll;

    return {"pageHeight" : pageHeight, "windowHeight" : windowHeight};
}

function buildJipLinksEvent(event) {
    if (arguments.callee.done) return;
    arguments.callee.done = true;
    if (_loadTimer) {
        clearInterval(_loadTimer);
        _loadTimer = null;
    }
    buildJipLinks();
    Event.stopObserving(window, 'load', buildJipLinksEvent);
}

function buildJipLinks(elm) {
    var jipLinkFunc = function(link) {
        Event.observe(link, 'click', function(event) {
            jipWindow.open(link.href);
            Event.stop(event);
            return false;
        });
    }
    // @todo сделать опции
    if (elm) {
        $(elm).getElementsBySelector('a.jipLink').each(jipLinkFunc);
    } else {
        $$('a.jipLink').each(jipLinkFunc);
    }
}

if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", buildJipLinksEvent, false);
}

/* for Internet Explorer */
/*@cc_on @*/
/*@if (@_win32)
document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
var script = document.getElementById("__ie_onload");
script.onreadystatechange = function() {
if (this.readyState == "complete") {
buildJipLinksEvent(); // call the onload handler
}
};
/*@end @*/

if (/WebKit/i.test(navigator.userAgent)) {
    var _loadTimer = setInterval(function() {
        if (/loaded|complete/.test(document.readyState)) {
            buildJipLinksEvent();
        }}, 10);
}

Event.observe(window, 'load', buildJipLinksEvent);

//--------------------------------
//  Cookie tools
//  Made by Vinnie Garcia
// -------------------------------
Cookie = Class.create();
var Cookie = {
    set: function (name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    },

    get: function (name) {
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

    remove: function (name, path, domain) {
        if (Cookie.get(name)) {
            document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        }
    }
}


//--------------------------------
//  Javascript Loader
// -------------------------------
jsLoaderClass = Class.create();
jsLoaderClass.prototype = {
    initialize: function()
    {
        this.pendingFiles  = [];
        this.loadingIndex = 0;
        this.onLoad = function () {}
    },

    load: function(url)
    {
        if ($$('script').any(function (jsElm) { return jsElm.src == url; })) {
            return;
        }

        var scr = document.createElement('script');
        scr.type = 'text/javascript';
        if (!window.opera) { Event.observe($(scr), 'readystatechange', jsLoader.onLoadScript); }
        Event.observe($(scr), 'load', jsLoader.onLoadScript);
        Event.observe($(scr), 'error', jsLoader.onLoadScript);
        scr.src = url + '?' + new Date().getTime();
        document.getElementsByTagName('head')[0].appendChild(scr);
        this.pendingFiles[this.pendingFiles.length] = url;
    },

    onLoadScript: function(evt)
    {
        evt = evt || event;
        var elem = evt.target || evt.srcElement;
        if (evt.type == 'readystatechange' && elem.readyState && !(elem.readyState == 'complete' || elem.readyState == 'loaded')) { return; }

        if (jsLoader.pendingFiles == 0) {
            return;
        }
        jsLoader.loadingIndex++;
        jsLoader.check();
    },

    check: function()
    {
        if (jsLoader.loadingIndex >= jsLoader.pendingFiles.length) { // loaded
            jsLoader.pendingFiles = [];
            jsLoader.loadingIndex = 0;
            jsLoader.onLoad();
        }
    },

    setOnLoad: function(func)
    {
        jsLoader.onLoad = func;
        jsLoader.check();
    }
}
jsLoader = new jsLoaderClass;

//--------------------------------
//  CSS Loader
// -------------------------------
cssLoader = {
    load: function(url)
    {
        if ($$('link').any(function (jsElm) { return jsElm.href == url; })) {
            return;
        }

        var cssLink = document.createElement('link');
        cssLink.type = 'text/css';
        cssLink.rel = 'stylesheet';
        cssLink.href = url;
        document.getElementsByTagName('head')[0].appendChild(cssLink);
    }
}

//--------------------------------
//  JIP window
// -------------------------------
jipWindow = Class.create();
jipWindow.prototype = {
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
            var jipDiv = document.createElement('div');
            this.currentWindow = this.windowCount++;
            if (this.currentWindow > 0) {
                this.hideSelects(this.currentWindow - 1);
            }
            this.stack[this.currentWindow] = new Array();
            jipDiv.id = 'jip' + this.currentWindow;
            Element.extend(jipDiv);
            jipDiv.addClassName('jipWindow');
            document.body.appendChild(jipDiv);
            if (this.jip) {
                this.jip.setStyle({'zIndex': 900});
            }
        } else {
            this.savePosition(this.jip);
        }

        if (!this.windowExists) {
            this.windowExists = true;
            Event.observe(document, "keypress", this.eventKeypress);
        }

        this.jip = $('jip' + this.currentWindow);

        if (this.jip) {
            this.lockContent();
            this.clean();
            this.jip.setStyle({display: 'block'});

            var jipWindowOffsetTop = Cookie.get('jip_window_top');
            var jipWindowOffsetLeft = Cookie.get('jip_window_left');

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
            }
            });

            if(url.match(/[&\?]_confirm=/) == null) {
                this.stack[this.currentWindow].push(url);
            }

            return false;
        }
        return true;
    },

    onJipLoad: function(func)
    {
        this.onJipLoadFunc = func;
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

    successRequest: function(transport)
    {
        this.element = this.jip;
        if (typeof(this.jip) == 'undefined') {
            alert('Нет ни одно окна для открытия страницы.');
            return false;
        }
        if (typeof(transport.responseXML) == 'undefined' && typeof(transport.responseText) == 'undefined') {
            this.setErrorMsg();
            return false;
        }

        this.jip.update('<div class="jipClose"><img class="jip" width="12" height="12" src="' + SITE_PATH + '/templates/images/jip/close.gif" onclick="javascript: jipWindow.close();" alt="Закрыть" title="Закрыть" /></div>');

        var tmp = '';
        var ctype = transport.getResponseHeader("content-type");
        if (typeof(transport.responseXML) != 'undefined' && ctype.indexOf("xml") >= 0) {
            responseXML = transport.responseXML.documentElement;
            var item = responseXML.getElementsByTagName('html')[0];
            if (typeof(item) != 'undefined') {
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
        for (var i = 1; i < 5; i++) {
            jipTitle = this.jip.childNodes[i];
            if (jipTitle.className == 'jipTitle') {
                i = 0;
                break;
            }
        }

        if (!i) {
            var jipMoveDiv = document.createElement('div');
            jipMoveDiv.id = 'jip-' + jipTitle.parentNode.id;
            jipMoveDiv.setAttribute('title', 'Переместить');
            Element.extend(jipMoveDiv);
            jipMoveDiv.addClassName('jipMove');

            jipTitle.insertBefore(jipMoveDiv, jipTitle.childNodes[0]);
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


    hideSelects: function() {
        if (Prototype.Browser.IE) {
            var jipId = (arguments.length > 0) ? $A(arguments).last() : false;
            var id = (jipId !== false) ? (jipId == 'jips' ? '.jipWindow ' : '#jip' + jipId + ' ') : '';
            var selectElements = $$(id + 'select');

            selectElements.each(function (elm, index) {
                if (elm.style.visibility == "hidden") {
                    delete selectElements[index];
                } else {
                    elm.style.visibility = "hidden";
                }
            });

            if (jipId === false) {
                jipWindow.selectElements.browserWindow = selectElements;
                //jipWindow.selectElements.jip = $H();
            } else {
                //jipWindow.selectElements.browserWindow = $H();
                if (jipId == 'jips') {
                    jipWindow.selectElements.jipWindow = selectElements;
                } else {
                    jipWindow.selectElements.jip[jipId] = selectElements;
                }
            }
        }
    },

    showSelects: function()
    {
        if (Prototype.Browser.IE) {
            var jipId = (arguments.length > 0) ? $A(arguments).last() : false;
            var showSelect = function (elm) { if (elm) elm.style.visibility = "visible"; };
            if (jipId === false) {
                if (typeof(jipWindow.selectElements.browserWindow) == 'undefined') {
                    return;
                }
                jipWindow.selectElements.browserWindow.each(showSelect);
                jipWindow.selectElements.browserWindow = $H();
            } else if (jipId == 'jips') {
                if (typeof(jipWindow.selectElements.jipWindow) == 'undefined') {
                    return;
                }
                jipWindow.selectElements.jipWindow.each(showSelect);
                jipWindow.selectElements.jipWindow = $H();
            } else {
                if (typeof(jipWindow.selectElements.jip[jipId]) == 'undefined') {
                    return;
                }
                jipWindow.selectElements.jip[jipId].each(showSelect);
                jipWindow.selectElements.jip[jipId] = $H();
            }
        }
    },

    lockContent: function()
    {
        var pageHeight = getBrowserHeight();
        if (!this.locker) {
            this.locker = document.createElement('div');
            this.locker.id = 'lockContent';
            Element.extend(this.locker);
            document.body.insertBefore(this.locker, document.body.childNodes[0]);
        }



        if (Prototype.Browser.IE) {
            var cumulativeOffsets = Position.cumulativeOffset(this.jip);
            var diff = (this.jip.offsetHeight + cumulativeOffsets[1]) - pageHeight.pageHeight;
            if (diff > 0) {
                pageHeight.pageHeight += diff;
            }
        }


        this.locker.setStyle({height: pageHeight.pageHeight +  "px"});

        if (this.locker.getStyle('display') != 'block') {
            Event.observe(window, "resize", this.eventLockUpdate);
            Event.observe(this.locker, "click", this.eventLockClick);
            this.locker.setStyle({opacity: 0.01, display: 'block'});
            this.setOpacityEffect();
            // hide select elements
            this.hideSelects();
        }
    },

    unlockContent: function()
    {
        if (this.locker && this.locker.getStyle('display') == 'block') {
            Event.stopObserving(this.locker, "click", this.eventLockClick);
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

    close: function(windows)
    {
        if(this.jip) {
            // избавляемся от "вспышки" в IE
            if(Prototype.Browser.IE) {
                $A(this.jip.getElementsByTagName('select')).each(function (elm) {
                    elm.style.visibility = "hidden";
                });
            }
            //this.savePosition(this.jip);
            this.tinyMCEIds.each(function(id) { tinyMCE.execCommand('mceRemoveControl', false, id); });
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
                    window.location.reload(true);
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
                }
                Event.stopObserving(document, "keypress", this.eventKeypress);
                this.windowExists = false;
                this.unlockContent();
                jipParent.removeChild(this.jip);
                this.jip = false;
                this.currentWindow = 0;
                this.stack = new Array();
            } else {

                var _this = this;
                new Effect.DropOut('jip' + (this.currentWindow), {
                    afterFinish: function() {
                        _this.jip.setStyle({display: 'none'});
                        jipParent.removeChild(_this.jip);
                        _this.jip = $('jip' + (--_this.currentWindow));
                        _this.jip.setStyle({zIndex: 902});
                        _this.showSelects(_this.currentWindow);
                    }
                });
            }
        }
    },

    savePosition: function(jip)
    {
        var cookiePath = (SITE_PATH == '') ? '/' : SITE_PATH;
        var cookieLifeTime = new Date(new Date().getTime() + 50000000000);
        var offsets = Position.cumulativeOffset(jip);
        var topOffset = parseInt(offsets[1]) - new Number(document.documentElement.scrollTop);
        var leftOffset = (offsets[0] >= 0) ? offsets[0] : 0;
        topOffset = (topOffset >= 0) ? topOffset : 0;
        Cookie.set('jip_window_top', topOffset, cookieLifeTime, cookiePath);
        Cookie.set('jip_window_left', leftOffset, cookieLifeTime, cookiePath);
    },

    clean: function()
    {
        if (this.jip) {
            this.jip.update('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/statusbar2.gif" width="32" height="32" /><br />Страница открывается...<br /><a href="javascript: void(jipWindow.close());">отменить</a></div>');
        }
    },

    setRefreshMsg: function()
    {
        if (this.jip) {
            this.jip.update('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/statusbar3.gif" width="32" height="32" /><br />Перезагрузка страницы...</div>');
        }
    },

    setErrorMsg: function()
    {
        if (this.jip) {
            this.jip.update('<p align=center>Невозможно выполнить запрос. Попробуйте еще раз.</p>');
        }
    },

    keyPress: function(event)
    {
        if(event.keyCode==Event.KEY_ESC) {
            jipWindow.close();
            Event.stop(event);
        }
    },

    lockClick: function(event)
    {
        // fix double click
        Event.stopObserving(this.locker, "click", this.eventLockClick);

        new Effect.Highlight(this.jip.getElementsByClassName('jipTitle').last(), {
        "afterFinish": function () {
            Event.observe(jipWindow.locker, "click", jipWindow.eventLockClick);
        }
        });
        Event.stop(event);
    }
}
var jipWindow = new jipWindow;

//--------------------------------
//  Menu for JIP actions
// -------------------------------
jipMenu = Class.create();
jipMenu.prototype = {
    initialize: function() {
        this.jipButton = false;
        this.eventMouseOut = this.mouseOut.bindAsEventListener(this);
        this.eventMouseIn = this.mouseIn.bindAsEventListener(this);
        this.layertimer = false;
        this.current = {"menu": false, "button": false};
        this.eventKeypress  = this.keyPress.bindAsEventListener(this);
        this.jipMenu = false;
        this.closeTimer = false;
    },

    keyPress: function(event) {
        if (event.keyCode==Event.KEY_ESC && this.current.menu != false && this.current.button != false) {
            this.close();
        }
    },

    show: function(button, menuId, items) {
        id = 'jip_menu_' + menuId;

        // open if closed
        if(!$(id) || $(id).getStyle('display') == 'none') {
            if (this.current.menu != false && this.current.button != false) {
                this.close();
            }
            var setupFunc = function () {
                jipMenu.current.menu = id;
                jipMenu.current.button = button;
                jipMenu.draw(button, id, items);
            }

            if (this.closeTimer) {
                setTimeout(setupFunc, 11);
            } else {
                setupFunc();
            }

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
        if (this.current.menu) {
            this.layertimer = setTimeout("jipMenu.close()", 1000);
        }
    },

    close: function() {
        this.jipMenu.setStyle({'display': 'none'});
        Event.stopObserving(this.jipMenu, "mouseout", this.eventMouseOut);
        Event.stopObserving(this.jipMenu, "mouseover", this.eventMouseIn);
        Event.stopObserving(document, "keypress", this.eventKeypress);
        this.current.button.src = SITE_PATH + '/templates/images/jip.gif';
        this.mouseIn();
        this.current = {"menu": false, "button": false};
        //this.closeTimer = setTimeout(function () { jipMenu.jipMenu.parentNode.removeChild(jipMenu.jipMenu); jipMenu.jipMenu = false; }, 10);
        //this.jipMenu.parentNode.removeChild(jipMenu.jipMenu);
        this.jipMenu = false;;
        this.jipButton = false;
    },

    draw: function(button, id, items) {
        var jip_win = $('jip' + jipWindow.currentWindow);

        if (!$(id)) {
            var jipMenuDOM = document.createElement('div');
            jipMenuDOM.id = id;
            $(jipMenuDOM).addClassName('jipMenu');
            var jipMenuTable = $(document.createElement('table')).addClassName('jipItems');
            jipMenuTable.cellPadding = 3;
            jipMenuTable.cellSpacing = 0;


            var jipMenuTbody = document.createElement('tbody');
            $A(items).each(function (elm, i) {
                var jipMenuTableTR = document.createElement('TR');
                jipMenuTableTR.onclick = function () { jipMenu.close(); return jipWindow.open(elm[1]); }

                jipMenuTableTR.onmouseout =  function (event) { jipMenuTableTR.cells[1].className = 'jipItemText'; };
                jipMenuTableTR.onmouseover = function (event) { jipMenuTableTR.cells[1].className = 'jipItemTextActive'; };

                var jipMenuTdTitle = document.createElement('td');
                jipMenuTdTitle.className = "jipItemText";

                var jipMenuItemTitle = document.createTextNode(elm[0]);
                jipMenuTdTitle.appendChild(jipMenuItemTitle);

                var jipMenuTdIcon = document.createElement('td');
                jipMenuTdIcon.className = "jipItemIcon";

                var jipMenuItemImg = document.createElement('img');
                jipMenuItemImg.src = elm[2];
                jipMenuItemImg.height= 16;
                jipMenuItemImg.width= 16;

                var jipMenuItemA = document.createElement('a');
                jipMenuItemA.href = elm[1];
                jipMenuItemA.oclick = false;
                jipMenuItemA.appendChild(jipMenuItemImg);
                jipMenuTdIcon.appendChild(jipMenuItemA);
                jipMenuTableTR.appendChild(jipMenuTdIcon);
                jipMenuTableTR.appendChild(jipMenuTdTitle);
                jipMenuTbody.appendChild(jipMenuTableTR);
            });


            jipMenuTable.appendChild(jipMenuTbody);
            jipMenuDOM.appendChild(jipMenuTable);
            button.parentNode.insertBefore(jipMenuDOM, button);
        } else {
            var jipMenuDOM = $(id);
            jipMenuDOM.setStyle({display: 'inline'});
        }
        Event.observe(jipMenuDOM, "mouseout", this.eventMouseOut);
        Event.observe(jipMenuDOM, "mouseover", this.eventMouseIn);
        Event.observe(document, "keypress", this.eventKeypress);

        this.mouseOut();

        this.jipButton = button;
        this.jipMenu = jipMenuDOM;
        this.jipButton.src = SITE_PATH + '/templates/images/jip_active.gif';
        this.jipMenu.setStyle({
            top: '-500px',
            left: '-500px',
            display: 'block'
        });

        var body = (jip_win && jip_win.getStyle('display') == 'block') ? jip_win : document.documentElement;

        var size = Element.getDimensions(this.jipMenu);
        var buttonSize = Element.getDimensions(this.jipButton);

        var pos = Position.positionedOffset(this.jipButton);
        var posScroll = Position.realOffset(document.documentElement);
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
        y = ((y < 0) ? 0 : y) + 1;

        this.jipMenu.setStyle({
            left: x + 'px', top: y + 'px'
        });
    }
}
var jipMenu = new jipMenu;