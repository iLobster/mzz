/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipCore = DUI.Class.create(MZZ.eventManager.prototype, {
        __id: 0,
        id: 'jip_',
        window: false,              //текущее окно
        windows: [],                //стэк окошков
        windowCount: 0,             //всего окон
        currentWindow: 0,           //текущий ид
        redirectAfterClose: false,
        stack: [],                  //стэк урлов
        selects: {'bodyWindow': [],
                  'jipWindow': [],
                  'jip': []},       //стэк захайденных селектов для могучего IE

        tinyMCEIds: {},            //стэк tinyMCE
        locker: false,             //локер

        init: function() {
            var __t = this;
            this.__id = MZZ.tools.getId();
            this.id = this.id + '' + this.__id;
            
            this.lockerResize = function() {__t.lockContent();};
            this.eventKey = function(e) {if (e.keyCode == 27) {e.preventDefault();e.stopImmediatePropagation();__t.close();}};
            this._events.push('beforeclose', 'close', 'open', 'success', 'error', 'complete');
            this._allowAnyEvent = true;
            this.sup();
        },

        open: function(url, isNew, method, params, options) {
            isNew = (this.windowCount == 0) ? true : (isNew || false);
            params = params || {};
            options = options || {};
            params.jip = 1;
            method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';

            if (isNew) {
                this.currentWindow = this.windowCount++;

                if (this.currentWindow > 0) {
                    this.hideSelects(this.currentWindow - 1);
                    this.window.zIndex(900);
                    this.windows[this.currentWindow - 1] = this.window;
                }
                this.stack[this.currentWindow] = [];
                this.tinyMCEIds[this.currentWindow] = [];
                this.window = new MZZ.jipWindow(this, options);
                this.window.bind(this.windowEvents, false, this);
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
            }

            this.fire('open');

            return false;
        },

        refresh: function() {

        },

        close: function(windows) {
            if (this.window) {
                if (MZZ.browser.msie) {
                    this.window.content().find('select').addClass('mzz-ie-visibility');
                }

                if (tinyMCE) {
                    for (var i = 0, l = this.tinyMCEIds[this.currentWindow].length; i < l; i++) {
                        tinyMCE.execCommand('mceRemoveControl', false, this.tinyMCEIds[this.currentWindow][i]);
                    }
                }

                this.tinyMCEIds[this.currentWindow] = [];

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
                    this.window = null;
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

            params.push({name: 'jip', value: '1'});

            this.clean();
            this.request(url, method, params);

            return false;
        },

        request: function(url, type, data) {
            $.ajax({
                url: url,
                type: type,
                data: data,
                cache: false,
                complete: function(transport, status) {
                    if(status == 'success') {
                        jipWindow.successRequest(transport);
                    } else {
                        jipWindow.setErrorMsg(transport, status);
                    }
                }
            });
        },
        
        windowEvents: function(e) {
            if (e.type == 'close') {
                this.fire('beforeclose', e.originalcontext, e.target);
                this.close();
            } else {
                //this.fire(e.type);
            }
        },
        
        lockContent: function() {
            if (this.windowCount) {
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
                    this.fire('lock');
                    this.locker.fadeIn('slow');
                }
            }
        },

        unlockContent: function() {
            if(this.locker) {
                var t = this;
                this.locker.fadeOut('slow', function() {
                    $(this).css('display', 'none');
                    t.fire('unlock');
                    t.showSelects();
                });
            }
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

                var selects = [];

                if (id === false ) {
                    selects = this.selects.bodyWindow;
                    this.selects.bodyWindow = [];
                } else if(id == 'jips') {
                    selects = this.selects.jipWindow;
                    this.selects.jipWindow = [];
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
            this.tinyMCEIds[this.currentWindow].push(id);
        },

        deleteTinyMCEId: function(id) {
            var tinyMCEIds = [];
            for (var i = 0, l = this.tinyMCEIds[this.currentWindow].length; i < l; i++) {
                if (!(id == this.tinyMCEIds[this.currentWindow][i])) {
                    tinyMCEIds.push(this.tinyMCEIds[this.currentWindow][i]);
                }
            }
            this.tinyMCEIds[this.currentWindow] = tinyMCEIds;
        },

        successRequest: function(transport) {
            if (this.window){
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

                this.window.show();
            } else {
                console.log('MZZ.jipWindow::successRequest() window closed before data recived');
                return false;
            }
        },

        setErrorMsg: function (transport, status)
        {
            if (this.window) {
                this.setStyle('error').setTitle('error');
                var reason = 'Reason: ' + ((transport.status == 404) ? '404 Not found' : '') + ((transport.status == 403) ? '403 Forbidden' : '') + ((transport.status == 500) ? '500 серверу плохо' : '') + '';
                this.window.content('<p align="center">' + MZZ.jipI18n[JIP_LANG].error + ' ' + reason + '</p>');
            }
        },

        clean: function()
        {
            if (this.window) {
                this.setStyle('default').setTitle('loading...');
                this.window.content('<div id="jipLoad"><img src="' + SITE_PATH + '/images/jip/status_car.gif" width="38" height="16" /><br />' + MZZ.jipI18n[JIP_LANG].loading + '<br /><a href="javascript: void(jipWindow.close());">' + MZZ.jipI18n[JIP_LANG].cancel + '</a></div>');
            }
        },

        setRefreshMsg: function()
        {
            if (this.window) {
                this.setStyle('default').setTitle('Refresh');
                this.window.content('<div id="jipLoad"><img src="' + SITE_PATH + '/images/jip/status_car.gif" width="38" height="16" /><br />' + MZZ.jipI18n[JIP_LANG].refresh + '</div>');
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

        setStyle: function(style) {return this},

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

        getId: function()
        {
            return this.id + '_window_' + this.currentWindow;
        }
    });

    /**
     * Serving jip-links for openning jipWindows
     */
    MZZ.jipLinkObserver = function(e) {
        if (e.button === 0 && (!e.shiftKey && !e.ctrlKey && !e.altKey && !e.metaKey)) {
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

    var JIP_LANG = (!$.isUndefined(SITE_LANG) && !$.isUndefined(MZZ.jipI18n[SITE_LANG])) ? SITE_LANG : 'en';
})(jQuery);

var jipWindow = new MZZ.jipCore;
var tinyMCE = false;
