/**
 * Порт jipWindow на jQuery
 *
 * Возможна работа в режиме noConflict с другими фреймворками
 *
 * проверено в 7 / 8, firefox 3.0.10 / 3.5 beta4, opera 9.64 / 10 alpha, safari 3.2 / 4 beta
 *
 * @todo: - autoSize()
 *        - нормальный "preloader"
 *        - setIcon()
 *        - ресайз окна ручками ???
 *        - поправить css, для работы со сторонними основными стилями
 *
 *
 */

(function ($){
    MZZ.jipWindow = DUI.Class.create({
        init: function() {
            this.newWindow = {
                //layout: '<div class="t1"><div class="t2"><div class="t3"></div></div></div><div class="tl"><div class="tr"><div class="tc mzz-window-title mzz-window-drag"></div></div><div class="ml"><div class="mr"><div class="mc"><div class="mzz-window-content"></div></div></div></div><div><div class="bl"><div class="br"><div class="bc"></div></div></div></div></div>',

            }

            this.window = false;    //текущее окно
            this.windows = []; //стэк окошков
            this.windowCount = 0;   //всего окон
            this.currentWindow = 0; //текущий ид
            this.redirectAfterClose = false;
            this.stack = []; //стэк урлов
            this.selects = {
                'bodyWindow': [],
                'jipWindow': [],
                'jip': []
            }; //стэк захайденных селектов для могучего IE
            
            this.tinyMCEIds = []; //стэк tinyMCE
            this.locker = false;    //локер
            
            this.lockerResize = function() {
                jipWindow.lockContent();
            };
        },

        open: function(url, isNew, method, params) {
            isNew = isNew || false;
            //isNew = true;
            params = params || {};
            params.ajax = 1;
            method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';

            if (isNew || this.windowCount == 0) {
                this.currentWindow = this.windowCount++;

                if (this.currentWindow > 0) {
                    this.hideSelects(this.currentWindow - 1);
                    this.window.zIndex(900);
                    this.windows[this.currentWindow - 1] = this.window;
                }
                this.stack[this.currentWindow] = new Array;
                this.window = new MZZ.window({
                    layout: '<div class="mzz-window-title mzz-window-drag" /><div class="mzz-window-content mzz-window-alsoResize" /><div class="mzz-window-footer"><div class="mzz-window-status" /></div><div class="mzz-window-icon" /><div class="mzz-window-buttons" /><div class="mzz-window-resizer" />',
                    id: 'jip_window_' + this.currentWindow,
                    baseClass: 'mzz-jip-window',
                    draggable: true,
                    resizable: {'handles': 'se', 'minWidth': 600, 'minHeight': 150, 'alsoResize': true},
                    visible: true
                    });
                // подумать над переносом в opts
                this.window.addButton('close', SITE_PATH + '/templates/images/jip/btn-close.png', '', function(){jipWindow.close()});
                this.window.top(this.window.top() + $(window).scrollTop());
                this.setStatus('<strong>Window url:</strong> ' + url);
                $(document).keypress(this.eventKey);
            } else {
            //????
            }
            
            if (this.window) {
                this.lockContent();
                this.clean();
                this.request(url, method, params);

                if(url.match(/[&\?]_confirm=/) == null) {
                    this.stack[this.currentWindow].push(url);
                }

                return false;
            }

            return false;
        },

        close: function(windows) {
            if (this.window) {
                if (MZZ.browser.msie) {
                    this.window.content().find('select').addClass('mzz-ie-visibility');
                }

                for (var i = 0, l = this.tinyMCEIds; i < l; i++) {
                    tinyMCE.execCommand('mceRemoveControl', false, this);
                    jipWindow.deleteTinyMCEId(this);
                }
                windows = (windows >= 0) ? windows : 1;

                var stack = this.stack[this.currentWindow];

                if (stack.length > 0) {
                    for (var i = 0; i < windows; i++) {
                        stack.pop();
                    }
                    var prevUrl = stack.pop();
                    if (prevUrl != undefined) {
                        return this.open(prevUrl);
                    }
                }

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
                    this.window.kill();
                    $(document).unbind('keypress', this.eventKey);
                    this.unlockContent();
                } else {
                    this.window.kill();
                    this.window = this.windows[--this.currentWindow];
                    this.window.zIndex(902);
                    this.showSelects(this.currentWindow);
                }
            }
        },

        sendForm: function(form) {
            var frm = $(form);
            var url = frm.attr('action') || window.location.href;
            var method = frm.attr('method') || 'GET';
            var params = frm.serializeArray();
            
            params.push({ajax: 1});
            
            this.clean();
            this.request(url, method, params);

            return false;
        },

        request: function(url, type, data) {
            $.ajax({
                url: url,
                type: type,
                data: data,
                cache: 'false',
                complete: function(transport, status) {
                    if(status == 'success') {
                        jipWindow.successRequest(transport);
                    } else {
                        jipWindow.setErrorMsg(transport, status);
                    }
                }
            });
        },

        autoSize: function() {
            console.log('MZZ.jipWindow::autoSize() To be implimented soon.');
        },

        lockContent: function() {
                
            if (!this.windowCount) {
                return false;
            }

            if (!this.locker) {
                this.locker = $('<div id="mzz-content-locker" class="mzz-content-locker" />');
                this.locker.css('opacity', '0.5');
                this.locker.prependTo($('body'));
            }

            var win = $(window);
            this.locker.css({'height': win.height()});
            if (this.locker.css('display') != 'block') {
                win.bind('resize', this.lockerResize);
                this.hideSelects();
                this.locker.fadeIn('slow');
            }
        },

        unlockContent: function() {
            if (!this.locker) {
                return false;
            }

            this.locker.fadeOut('slow', function() {
                $(this).css('display', 'none');
                jipWindow.showSelects();
            });
        },

        hideSelects: function(id) {
            if (MZZ.browser.msie) {
                if ($.isUndefined(id)) {
                    id = false;
                }

                var source = (id !== false) ? (id == 'jips' ? '.mzz-jip-window ' : '#jip_window_' + id + ' ') : '';
                var selects = $(source + 'select:not(:hidden)');

                for (var i = 0, l = selects.length; i < l; i++) {
                    selects[i] = $(selects[i]).addClass('mzz-ie-visibility');
                }

                if (id === false) {
                    this.selects.bodyWindow = selects;
                } else if (id == 'jips') {
                    this.selects.jipWindow = selects;
                } else {
                    this.selects.jip[id] = selects;
                }
            }
        },

        showSelects: function(id) {
            if (MZZ.browser.msie) {
                if ($.isUndefined(id)) {
                    id = false;
                }

                var selects = new Array;

                if (id === false ) {
                    selects = this.selects.bodyWindow;
                    this.selects.bodyWindow = new Array;
                } else if(id == 'jips') {
                    selects = this.selects.jipWindow;
                    this.selects.jipWindow = new Array;
                } else if(!$.isUndefined(this.selects.jip[id])) {
                    selects = this.selects.jip[id];
                    delete this.selects.jip[id];
                }

                for (var i = 0, l = selects.length; i < l; i++) {
                    selects[i].removeClass('mzz-ie-visibility');
                }
            }
        },

        addTinyMCEId: function(id) {
            this.tinyMCEIds.push(id);
        },

        deleteTinyMCEId: function(id) {
            var tinyMCEIds = [];
            console.log(this.tinyMCEIds, this.tinyMCEIds.length);
            for(var i in this.tinyMCEIds) {
                if (!(id == this.tinyMCEIds[i])) {
                    tinyMCEIds.push(this.tinyMCEIds[i]);
                }
            }
            this.tinyMCEIds = tinyMCEIds;
            console.log(this.tinyMCEIds, this.tinyMCEIds.length);
        },
        
        successRequest: function(transport) {
            if ($.isUndefined(transport.responseXML) && $.isUndefined(transport.responseText)) {
                console.log('MZZ.jipWindow::successRequest() undefined responseXML && responseText, transport = ', transport);
                return false;
            }

            var ctype = transport.getResponseHeader("content-type");
            var tmp = '';
            if (!$.isUndefined(transport.responseXML) && ctype.indexOf("xml") >= 0) {
                responseXML = transport.responseXML.documentElement;
                var item = responseXML.getElementsByTagName('html')[0];
                if (!$.isUndefined(item)) {
                    for (var i = 0, l = item.childNodes.length; i < l; i++) {
                        if (item.childNodes[i].data != '') {
                            tmp += item.childNodes[i].data;
                        }
                    }
                }
            } else {
                tmp = transport.responseText;
            }
            if (tmp == '') {
                console.log('MZZ.jipWindow::successRequest() "tmp" is empty, server ignored us? transport = ', transport);
            }

            this.window.content().html(tmp);
            var title = this.window.content().find('div.jipTitle:first');

            if (title.length > 0) {
                this.window.title(title.html());
                title.remove();
            }

            this.window.content().find('a.mzz-jip-link').addClass('mzz-jip-link-new');
            this.window.show();

        },

        setErrorMsg: function (transport, status)
        {
            if (this.window) {
                this.setStyle('error').setTitle('error');
                this.window.content('<p align=center>' + MZZ.jipI18n[SITE_LANG].error + '</p>');
            }
        },

        clean: function()
        {
            if (this.window) {
                this.setStyle('default').setTitle('loading...');
                this.window.content('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/jip/statusbar.gif" width="32" height="32" /><br />' + MZZ.jipI18n[SITE_LANG].loading + '<br /><a href="javascript: void(jipWindow.close());">' + MZZ.jipI18n[SITE_LANG].cancel + '</a></div>');
            }
        },

        setRefreshMsg: function()
        {
            if (this.window) {
                this.setStyle('default').setTitle('Refresh');
                this.window.content('<div id="jipLoad"><img src="' + SITE_PATH + '/templates/images/jip/statusbar.gif" width="32" height="32" /><br />' + MZZ.jipI18n[SITE_LANG].refresh + '</div>');
            }
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

        setStyle: function(style)
        {
            if (this.window) {
                this.window.style(style);
            }

            return this;
        },

        setTitle: function(title)
        {
            if (this.window) {
                this.window.title(title);
            }

            return this;
        },

        setStatus: function(status)
        {
            if (this.window) {
                this.window.status(status);
            }

            return this;
        },

        eventKey: function(e)
        {
            if (e.keyCode == 27) {
                e.preventDefault();
                e.stopImmediatePropagation();
                jipWindow.close();
            }
        }
    });

    /**
     * Serving jip-links for openning jipWindows
     */
    MZZ.jipLinkObserver = function(e) {
        if (e.button === 0 && (!e.shiftKey && !e.ctrlKey && !e.altKey && !e.metaKey)) {
            console.log(e.shiftKey,e.ctrlKey,e.altKey,e.metaKey);
            e.preventDefault();
            e.stopImmediatePropagation();
            var link = $(this);
            if ($.isUndefined(link.attr('href'))) {
                console.log('MZZ.jipLinkObserver() Halt, no href defined on ', this);
                return false;
            }

            jipWindow.open(link.attr('href'), link.hasClass('mzz-jip-link-new'));
            return false;
        }
    };

    /**
     * Binds to jip-links
     */
    $('a.mzz-jip-link').live('click', MZZ.jipLinkObserver);
    $('a.jipLink').live('click', MZZ.jipLinkObserver); //old links

    MZZ.jipI18n = {
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

    if (typeof(SITE_LANG) == 'undefined' || typeof(MZZ.jipI18n[SITE_LANG]) == 'undefined')
    {
        var SITE_LANG = 'en';
    }
})(jQuery);

var jipWindow = new MZZ.jipWindow;

/**
 * ?? MOVE TO simple/*
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