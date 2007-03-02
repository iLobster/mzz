/** @todo
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
}
**/

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
}

function buildJipLinks(elm) {

    var elements = (elm) ? document.getElementsByClassName('jipLink', elm) : document.getElementsByClassName('jipLink');

    elements.each(function(link) {
        Event.observe(link, 'click', function(event) {
          jipWindow.open(link.href);
          Event.stop(event);
          return false;
        });
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
var Cookie = {
 set: function (name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
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
//  AJAX tools
// -------------------------------
mzzAjax = Class.create();
mzzAjax.prototype = {
  initialize: function() {
    this.drag = false;
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
        mzzAjax.success(transport);
      },
      onFailure: function(transport) {
        mzzAjax.onError(transport);
      }
    });
    return false;
  },

  setTargetEelement: function(element) {
    this.element = $(element);
  },

  success: function(transport)
  {
    if(typeof(this.element) != 'undefined' && (typeof(transport.responseXML) != 'undefined' || typeof(transport.responseText) != 'undefined')){
        var element = this.element;
        element.update('<div class="jipClose"><img class="jip" width="12" height="12" src="' + SITE_PATH + '/templates/images/jip/close.gif" onclick="javascript: jipWindow.close();" alt="Закрыть" title="Закрыть" /></div>');
        var tmp = '';
        var ctype = transport.getResponseHeader("content-type");

        if (ctype.indexOf("xml") >= 0 && transport.responseXML != null) {

            responseXML = transport.responseXML.documentElement;
            var item = responseXML.getElementsByTagName('html')[0];
            var cnodes = item.childNodes.length;
            for (var i=0; i<cnodes; i++) {
                if (item.childNodes[i].data != '') {
                    tmp += item.childNodes[i].data;
                }
            }
        } else {
            tmp = transport.responseText;
        }

        element.update(element.innerHTML + tmp);
        if (document.getElementsByClassName('jipTitle').length > 0) {
            var jipTitle = document.getElementsByClassName('jipTitle').last();
            var jipMoveDiv = document.createElement('div');
            jipMoveDiv.id = 'jip-' + jipTitle.parentNode.id;
            jipMoveDiv.setAttribute('title', 'Переместить');
            Element.extend(jipMoveDiv);
            jipMoveDiv.addClassName('jipMove');
            jipMoveDiv.update('<img width="5" height="13" src="' + SITE_PATH + '/templates/images/jip/move.gif" alt="Переместить" title="Переместить" />');
            jipTitle.insertBefore(jipMoveDiv, jipTitle.childNodes[0]);
            this.drag = new Draggable('jip' + jipWindow.currentWindow, 'jip-' + jipTitle.parentNode.id);
        }

        //element.innerHTML.evalScripts();
        buildJipLinks(element);
        //new Draggable('jip' + jipWindow.currentWindow, 'jip-' + jipTitle.parentNode.id);
    } else {
        alert("No response from script. \r\n TransID: " + transport.tId + "; HTTP status: " + transport.status + "; Message: " + transport.statusText);
    }
  },

  successIn: function(transport)
  {
    if(typeof(this.element) != 'undefined' && (typeof(transport.responseXML) != 'undefined' || typeof(transport.responseText) != 'undefined')){
        var element = this.element;
        var tmp = '';
        var ctype = transport.getResponseHeader("content-type");

        if (ctype.indexOf("xml") >= 0 && transport.responseXML != null) {
            responseXML = transport.responseXML.documentElement;
            var item = responseXML.getElementsByTagName('html')[0];
            var cnodes = item.childNodes.length;
            for (var i=0; i<cnodes; i++) {
                if (item.childNodes[i].data != '') {
                    tmp += item.childNodes[i].data;
                }
            }
        } else {
            tmp = transport.responseText;
        }

        element.update(tmp);
        element.innerHTML.evalScripts();
    } else {
        alert("No response from script. \r\n TransID: " + transport.tId + "; HTTP status: " + transport.status + "; Message: " + transport.statusText);
    }
  },

  onError: function(transport)
  {
    this.stack.pop(); // delete broken url
    alert("Error. \r\n TransID: " + transport.tId + "; HTTP status: " + transport.status + "; Message: " + transport.statusText);
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

    this.eventKeypress  = this.keyPress.bindAsEventListener(this);
    this.eventLockClick  = this.lockClick.bindAsEventListener(this);
    this.eventLockUpdate  = this.lockContent.bindAsEventListener(this);
  },

  open: function(url, isNew, method)
  {
    isNew = isNew || false;
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
    if (typeof(mzzAjax) != 'object') {
        mzzAjax = new mzzAjax();
    }
    mzzAjax.setTargetEelement(this.jip);
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
        this.jip.setStyle({
            'top': new Number(jipWindowOffsetTop) + (this.currentWindow * 5) + new Number(document.documentElement.scrollTop) + 'px',
            'left': new Number(jipWindowOffsetLeft)  + (this.currentWindow * 5) + 'px'
        });

        new Ajax.Request(url, {
            'method': method,
            parameters: { 'ajax': 1 },
            onSuccess: function(transport) {
                mzzAjax.success(transport);
            },
            onFailure: function(transport) {
                mzzAjax.onError(transport);
            }
        });
        this.stack[this.currentWindow].push(url);
        this.lockContent();
        return false;
    }
    return true;
  },


  openIn: function(url, target, method, params)
  {
    method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';

    var winInWin = $(target);
    if (typeof(mzzAjax) != 'object') {
        mzzAjax = new mzzAjax();
    }
    mzzAjax.setTargetEelement(winInWin)
    var parameters = $H({ 'ajax': 1 });
    if (params) {
        parameters.merge(params);
    }
    if (winInWin) {
        new Ajax.Request(url, {
            'method': method,
            'parameters': parameters,
            onSuccess: function(transport) {
                mzzAjax.successIn(transport);
            },
            onFailure: function(transport) {
                mzzAjax.onError(transport);
            }
        });
        return false;
    }
    return true;
  },

  lockContent: function()
  {
    var pageHeight = getBrowserHeight();
    if (!this.locker) {
            this.locker = document.createElement('div');
            this.locker.setAttribute('id', 'lockContent');
            Element.extend(this.locker);
            document.body.insertBefore(this.locker, document.body.childNodes[0]);
    }
    //this.locker = $('lockContent');
    this.locker.setStyle({height: pageHeight.pageHeight +"px"});

    if (this.locker.getStyle('display') != 'block') {
        Event.observe(window, "resize", this.eventLockUpdate);
        Event.observe(this.locker, "click", this.eventLockClick);
        this.locker.setStyle({opacity: 0.01, display: 'block'});
        new Effect.Opacity(this.locker, {"from" : 0, "to": 0.8, "duration": 0.5});
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
            }
        });
    }
  },

  toggleEditorById: function(link_elm, editor_id)
  {
    if (this.toggleEditorStatus[editor_id] == 1) {
        link_elm.innerHTML = "Включить WYSIWYG-редактор";
        this.toggleEditorStatus[editor_id] = 0;
        if (typeof(tinyMCE) != 'undefined') {
            tinyMCE.triggerSave(false, false);
            tinyMCE.execCommand('mceRemoveEditor' , false, editor_id);
        }
    } else {
        link_elm.innerHTML = "Включить обычный режим";
        this.toggleEditorStatus[editor_id] = 1;
        if (typeof(tinyMCE) != 'undefined') {
            tinyMCE.execCommand('mceAddEditor' , true, editor_id);
        }
    }
  },

  refreshAfterClose: function(url)
  {
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
                if (mzzAjax.drag) {
                    mzzAjax.drag.destroy();
                }
                return this.open(prevUrl);
            }
        } else {
            // @todo не нужно?
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
        this.jip.setStyle({display: 'none'});
        if(--this.windowCount == 0) {
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

  keyPress: function(event) {
    if(event.keyCode==Event.KEY_ESC) {
        jipWindow.close();
        Event.stop(event);
    }
  },

  lockClick: function(event) {
    Event.stopObserving(this.locker, "click", this.eventLockClick);
    new Effect.HighlightBorder(this.jip, {
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
  },

  keyPress: function(event) {
    if (event.keyCode==Event.KEY_ESC && this.current.menu != false && this.current.button != false) {
        this.close($(this.current.menu));
    }
  },

  show: function(button, id) {
      var jip_menu = $('jip_menu_' + id);
      if (jip_menu.getStyle('display') == 'none') {
          this.jipButton = button;
          this.open(jip_menu);
          this.current.menu = 'jip_menu_' + id;
          this.current.button = button;
          Event.observe(jip_menu, "mouseout", this.eventMouseOut);
          Event.observe(jip_menu, "mouseover", this.eventMouseIn);
          Event.observe(document, "keypress", this.eventKeypress);
          this.mouseOut();
      } else {
          Event.stopObserving(jip_menu, "mouseout", this.eventMouseOut);
          Event.stopObserving(jip_menu, "mouseover", this.eventMouseIn);
          this.close(jip_menu);
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
        this.layertimer = setTimeout("jipMenu.close($(jipMenu.current.menu))", 800);
    }
  },

  close: function(jip_menu) {
    Event.stopObserving(document, "keypress", this.eventKeypress);
    jip_menu.setStyle({display: 'none'});
    this.current.button.src = SITE_PATH + '/templates/images/jip.gif';
    this.mouseIn();
    this.current = {"menu": false, "button": false};
  },

  open: function(jip_menu) {
    var jip_win = $('jip' + jipWindow.currentWindow);
    this.jipButton.src = SITE_PATH + '/templates/images/jip_active.gif';
    jip_menu.setStyle({
      top: '-100px',
      left: '-100px',
      display: 'block'
    });

    if (this.current.menu != false && this.current.button != false) {
        this.close($(this.current.menu), this.current.button);
    }

    var body = (jip_win && jip_win.getStyle('display') == 'block') ? jip_win : document.documentElement;

    var size = Element.getDimensions(jip_menu);
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
    y = (y < 0) ? 0 : y;

    jip_menu.setStyle({
      left: x + 'px',
      top: (y + 1) + 'px'
    });
  }
}
var jipMenu = new jipMenu;



//--------------------------------
//  Draggable for JIP window
// -------------------------------
Draggable = Class.create();
Draggable.prototype = {
  initialize: function(element, byElement) {
    var pageSize = Element.getDimensions(document.documentElement);
    this.pageHeight = pageSize.height;
    this.pageWidth = pageSize.width;

    this.element      = $(element);
    this.byElement      = $(byElement);
    Element.makePositioned(this.element);

    this.active       = false;
    this.offsetX      = 0;
    this.offsetY      = 0;
    this.eventX       = 0;
    this.eventY       = 0;
    this.offsetLeft = 0;
    this.offsetTop = 0;

    this.eventMouseDown = this.startDrag.bindAsEventListener(this);
    this.eventMouseUp   = this.endDrag.bindAsEventListener(this);
    this.eventMouseMove = this.update.bindAsEventListener(this);
    this.eventKeypress  = this.keyPress.bindAsEventListener(this);

    Event.observe(this.byElement, "mousedown", this.eventMouseDown);
    Event.observe(document, "mouseup", this.eventMouseUp);
    Event.observe(document, "mousemove", this.eventMouseMove);
    Event.observe(document, "keypress", this.eventKeypress);
  },
  destroy: function() {
    Event.stopObserving(this.byElement, "mousedown", this.eventMouseDown);
    Event.stopObserving(document, "mouseup", this.eventMouseUp);
    Event.stopObserving(document, "mousemove", this.eventMouseMove);
    Event.stopObserving(document, "keypress", this.eventKeypress);
  },
  startDrag: function(event) {
    if(Event.isLeftClick(event)) {
      this.active = true;
      this.initOffsets(event);
      Event.stop(event);
    }
  },
  finishDrag: function(event, success) {
      this.initOffsets(event);
      this.active = false;
  },
  keyPress: function(event) {
    if(this.active) {
      if(event.keyCode==Event.KEY_ESC) {
        this.finishDrag(event, false);
        Event.stop(event);
      }
    }
  },
  endDrag: function(event) {
    if(this.active) {
      var cookiePath = (SITE_PATH == '') ? '/' : SITE_PATH;
      Cookie.set('jip_window_top', new Number(this.offsetTop) - new Number(document.documentElement.scrollTop), new Date(new Date().getTime() + 50000000000), cookiePath);
      Cookie.set('jip_window_left', this.offsetLeft, new Date(new Date().getTime() + 50000000000), cookiePath);
      jipWindow.lockContent();
      this.finishDrag(event, true);
      Event.stop(event);
    }
    this.active = false;
  },
  draw: function(event) {
    var style = this.element.style;
    var offsetLeft = this.offsetX + Event.pointerX(event) - this.eventX;
    var offsetTop = (this.offsetY + Event.pointerY(event) - this.eventY);
    if (offsetLeft >= 0) {
        this.offsetLeft = this.offsetX + Event.pointerX(event) - this.eventX;
        style.left = this.offsetLeft + "px";
    }
    if (offsetTop >= 0) {
        this.offsetTop = (this.offsetY + Event.pointerY(event) - this.eventY);
        style.top  = this.offsetTop + "px";
    }
  },
  update: function(event) {
    if(this.active) {
      this.draw(event);
      Event.stop(event);
    }
  },
  initOffsets: function(event) {
    var offset = Position.cumulativeOffset(this.element);
    this.offsetX = parseInt(offset[0] + 0);
    this.offsetY = parseInt(offset[1] + 0);
    this.eventX = Event.pointerX(event);
    this.eventY = Event.pointerY(event);
  }
}

Effect.HighlightBorder = Class.create();
Object.extend(Object.extend(Effect.HighlightBorder.prototype, Effect.Base.prototype), {
  initialize: function(element) {
    this.element = $(element);
    if(!this.element) throw(Effect._elementDoesNotExistError);
    var options = Object.extend({ startcolor: '#000000' }, arguments[1] || {});
    this.start(options);
  },
  setup: function() {
    if(this.element.getStyle('display')=='none') { this.cancel(); return; }
    if(!this.options.endcolor)
      this.options.endcolor = this.element.getStyle('border-color').parseColor('#999999');
    if(!this.options.restorecolor)
      this.options.restorecolor = this.element.getStyle('border-color');
    this._base  = $R(0,2).map(function(i){ return parseInt(this.options.startcolor.slice(i*2+1,i*2+3),16) }.bind(this));
    this._delta = $R(0,2).map(function(i){ return parseInt(this.options.endcolor.slice(i*2+1,i*2+3),16)-this._base[i] }.bind(this));
  },
  update: function(position) {
    this.element.setStyle({borderColor: $R(0,2).inject('#',function(m,v,i){
      return m+(Math.round(this._base[i]+(this._delta[i]*position)).toColorPart()); }.bind(this)) });
  },
  finish: function() {
    this.element.setStyle({borderColor: this.options.restorecolor});
  }
});