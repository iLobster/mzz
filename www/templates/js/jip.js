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
/* todo
var onLoadEvents = new Array();
function callLoadEvents() {
onLoadEvents.each(function(eventFunc) {
if(eventFunc != callLoadEvents) {
eventFunc();
}
});
}
function addOnLoad(eventFunc) {
if(window.onload && window.onload != callLoadEvents) {
onLoadEvents[onLoadEvents.size()] = window.onload;
}
window.onload = callLoadEvents;
onLoadEvents[onLoadEvents.size()] = eventFunc;
}*/

function buildJipLinksEvent(event) {
    if (arguments.callee.done) return;
    arguments.callee.done = true;
    if (_loadTimer) {
        clearInterval(_loadTimer);
        _loadTimer = null;
    }
    buildJipLinks();
}

function buildJipLinks(elm) {

    var elements = $A((elm || document).getElementsByTagName('a'));

    elements.each(function(link) {
        if (/jipLink/.test(link.className)) {
            Event.observe(link, 'click', function(event) {
                jipWindow.open(link.href);
                Event.stop(event);
                return false;
            });
        }
    });
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

window.onload = buildJipLinksEvent;

//--------------------------------
//  Cookie tools
//  Cookie: a class for dealing with cookies.
//  Simple set, get, and remove methods.
//  Made by Vinnie Garcia but adapted from code
//  publicly available on many JavaScript sites.
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
        this.redirectToAfterClose = false;
        this.windowExists = false;
        this.selectElements = null;
        this.drag = false;

        this.eventKeypress  = this.keyPress.bindAsEventListener(this);
        this.eventLockClick  = this.lockClick.bindAsEventListener(this);
        this.eventLockUpdate  = this.lockContent.bindAsEventListener(this);
    },

    open: function(url, isNew, method, params)
    {
        isNew = isNew || false;
        params = params || {};
        method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';
        if (isNew || this.windowCount == 0) {
            var jipDiv = document.createElement('div');
            this.currentWindow = this.windowCount++;
            this.stack[this.currentWindow] = new Array();
            jipDiv.id = 'jip' + this.currentWindow;
            Element.extend(jipDiv);
            jipDiv.addClassName('jipWindow');
            document.body.appendChild(jipDiv);
            if (this.jip) {
                this.jip.setStyle({'zIndex': 900});
            }
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
            'top': new Number(jipWindowOffsetTop) + (this.currentWindow * 5) + new Number(topScroll) + 'px',
            'left': new Number(jipWindowOffsetLeft)  + (this.currentWindow * 5) + 'px'
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


    sendForm: function(form, method) {
        var params = $(form).serialize().toQueryParams();
        params.ajax = 1;
        jipWindow.clean();
        method = (method && method.toUpperCase() == 'GET') ? 'GET' : 'POST';

        new Ajax.Request(form.action, {
            'method': method,
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
            Object.values(item.childNodes).each(function (elm) {
                if (typeof(elm.data) == 'string' && elm.data != '') {
                    tmp += elm.data;
                }
            });
        } else {
            tmp = transport.responseText;
        }
        this.jip.update(this.jip.innerHTML + tmp);

        var jipTitles = document.getElementsByClassName('jipTitle');
        if (jipTitles.length > 0) {
            var jipTitle = jipTitles.last();
            var jipMoveDiv = document.createElement('div');
            jipMoveDiv.id = 'jip-' + jipTitle.parentNode.id;
            jipMoveDiv.setAttribute('title', 'Переместить');
            Element.extend(jipMoveDiv);
            jipMoveDiv.addClassName('jipMove');
            jipMoveDiv.update('<img width="5" height="13" src="' + SITE_PATH + '/templates/images/jip/move.gif" alt="Переместить" title="Переместить" />');
            jipTitle.insertBefore(jipMoveDiv, jipTitle.childNodes[0]);
            this.drag = new Draggable('jip' + jipWindow.currentWindow, {
                'handle': 'jip-' + jipTitle.parentNode.id,
                'onEnd': function() {
                    jipWindow.lockContent();
                }
            });
        }
        this.lockContent();
        buildJipLinks(this.jip);
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
        this.locker.setStyle({height: pageHeight.pageHeight +  "px"});

        if (this.locker.getStyle('display') != 'block') {
            Event.observe(window, "resize", this.eventLockUpdate);
            Event.observe(this.locker, "click", this.eventLockClick);
            this.locker.setStyle({opacity: 0.01, display: 'block'});
            new Effect.Opacity(this.locker, {"from" : 0, "to": 0.8, "duration": 0.5});
            // hide select elements
            if(/MSIE/.test(navigator.userAgent) && !window.opera) {
                this.selectElements = $A(document.getElementsByTagName('select'));
                this.selectElements.each(function (elm, index) {
                    if (elm.style.visibility == "hidden") {
                        delete jipWindow.selectElements[index];
                    } else {
                        elm.style.visibility = "hidden";
                    }
                });
            }
        }
    },

    unlockContent: function()
    {
        if (this.locker && this.locker.getStyle('display') == 'block') {
            Event.stopObserving(this.locker, "click", this.eventLockClick);
            Event.stopObserving(window, "resize", this.eventLockUpdate);
            new Effect.Opacity(this.locker, {
            "from": 0.8,
            "to": 0,
            "duration": 0.5,
            "afterFinish": function () {
                jipWindow.locker.setStyle({opacity: 0.01, display: 'none'});
                if(/MSIE/.test(navigator.userAgent) && !window.opera) {
                    jipWindow.selectElements.each(function (elm) { if (elm) { elm.style.visibility = "visible"; } } );
                    jipWindow.selectElements = null;
                }
            }
            });
        }
    },

    refreshAfterClose: function(url)
    {
        url = url || true;
        if (url === true) {
            this.redirectToAfterClose = new String(window.location).replace(window.location.hash, '');
        } else {
            this.redirectToAfterClose = url;
        }
    },

    close: function(windows)
    {
        if(this.jip) {
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
            if (this.redirectToAfterClose) {
                window.location = this.redirectToAfterClose;
                this.setRefreshMsg();
                this.redirectToAfterClose  = false;
                return true;
            }

            if(--this.windowCount == 0) {
                var cookiePath = (SITE_PATH == '') ? '/' : SITE_PATH;
                var cookieLifeTime = new Date(new Date().getTime() + 50000000000);
                var offsets = Position.cumulativeOffset(this.jip);
                var topOffset = parseInt(offsets[1]) - new Number(document.documentElement.scrollTop);
                var leftOffset = (offsets[0] >= 0) ? offsets[0] : 0;
                topOffset = (topOffset >= 0) ? topOffset : 0;
                Cookie.set('jip_window_top', topOffset, cookieLifeTime, cookiePath);
                Cookie.set('jip_window_left', leftOffset, cookieLifeTime, cookiePath);

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
                this.jip = $('jip' + (--this.currentWindow));
                this.jip.setStyle({zIndex: 902});
            }
        }
    },

    clean: function()
    {
        if (this.jip) {
            this.jip.update('<p align=center><img src="' + SITE_PATH + '/templates/images/statusbar2.gif" align="texttop"><span id="jipLoad">Загрузка данных... (<a href="javascript: void(jipWindow.close());">отмена</a>)</span></p>');
        }
    },

    setRefreshMsg: function()
    {
        if (this.jip) {
            this.jip.update('<p align=center><img src="' + SITE_PATH + '/templates/images/statusbar3.gif" align="texttop"><span id="jipLoad">Подождите, требуется перезагрузка окна браузера...</span></p>');
        }
    },

    setErrorMsg: function()
    {
        if (this.jip) {
            this.jip.update('<p align=center>Невозможно выполнить запрос. Попробуйте еще раз.</p>');
        }
    },

    keyPress: function(event) {
        if(event.keyCode==Event.KEY_ESC) {
            jipWindow.close();
            Event.stop(event);
        }
    },

    lockClick: function(event) {
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
    },

    keyPress: function(event) {
        if (event.keyCode==Event.KEY_ESC && this.current.menu != false && this.current.button != false) {
            this.close();
        }
    },

    show: function(button, menuId, items) {
        id = 'jip_menu_' + menuId;

        // open if closed
        if($(id) == null) {
            if (this.current.menu != false && this.current.button != false) {
                this.close();
            }

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

            this.jipButton = button;
            this.jipMenu = jipMenuDOM;
            this.draw();
            this.current.menu = id;
            this.current.button = button;
            Event.observe(jipMenuDOM, "mouseout", this.eventMouseOut);
            Event.observe(jipMenuDOM, "mouseover", this.eventMouseIn);
            Event.observe(document, "keypress", this.eventKeypress);
            this.mouseOut();
        } else {
            this.close();
        }

    },

    mouseIn: function() {
        if (this.layertimer) {
            clearTimeout(this.layertimer);
        }
    },

    mouseOut: function() {
        if (this.layertimer) {
            this.mouseIn();
        }
        if (this.current.menu) {
            this.layertimer = setTimeout("jipMenu.close()", 800);
        }
    },

    close: function() {
        this.jipMenu.setStyle({'visibility': 'hidden'});
        Event.stopObserving(this.jipMenu, "mouseout", this.eventMouseOut);
        Event.stopObserving(this.jipMenu, "mouseover", this.eventMouseIn);
        Event.stopObserving(document, "keypress", this.eventKeypress);
        this.current.button.src = SITE_PATH + '/templates/images/jip.gif';
        this.mouseIn();
        this.current = {"menu": false, "button": false};
        setTimeout(function () { jipMenu.jipMenu.parentNode.removeChild(jipMenu.jipMenu); jipMenu.jipMenu = false; }, 10);
        this.jipButton = false;
    },

    draw: function() {
        var jip_win = $('jip' + jipWindow.currentWindow);
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