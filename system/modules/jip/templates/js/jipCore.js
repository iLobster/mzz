// REQUIRE:jquery.ex.js;fileLoader.js;jip/jipWindow.js
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipCore = DUI.Class.create({
        __id: 0,
        eh: null,
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
            var t = this;
            this.eh = $('<div />');
            this.__id = MZZ.tools.getId();
            this.id = this.id + '' + this.__id;
            
            this.lockerResize = function() {t.lockContent();};
            this.eventKey = function(e) {if (e.keyCode == 27) {e.preventDefault();e.stopImmediatePropagation();t.close();}};
        },

        bind: function(eType, eData, eObject) {
            return this.eh.bind(eType, eData, eObject);
        },

        one: function(eType, eData, eObject) {
            return this.eh.one(eType, eData, eObject);
        },

        unbind: function(eType, eObject)
        {
            return this.eh.unbind(eType, eObject);
        },

        triggerHandler: function(eType, eParams) {
            return this.eh.triggerHandler(eType, eParams);
        },

        open: function(url, isNew, method, params, redirect) {
            isNew = (this.windowCount == 0) ? true : (isNew || false);
            params = params || {};
            params.jip = 1;
            method = (method && method.toUpperCase() == 'POST') ? 'POST' : 'GET';

            if (this.triggerHandler('beforeopen', [this, url, isNew, method, params]) === false) {
                return false;
            }

            if (isNew) {
                this.currentWindow = this.windowCount++;

                if (this.currentWindow > 0) {
                    this.hideSelects(this.currentWindow - 1);
                    this.windows[this.currentWindow - 1] = this.window;
                }

                this.stack[this.currentWindow] = [];
                this.tinyMCEIds[this.currentWindow] = [];
                this.window = new MZZ.jipWindow(this);
                this.window.zIndex(MZZ.tools.lastzIndex()+2);
                this.window.bind('beforeshow onshowe show beforehide onhide hide kill', this.windowEvents);
                var t = this;
                var refresh = $('<img height="16" width="16" alt="" src="' + SITE_PATH + '/images/spacer.gif" class="refresh" />').bind('click', function() {t.refresh()});
                var status = $('<span />').append(refresh).append(' ' + url);
                this.setStatus(status);
                $(document).keypress(this.eventKey);
            } else {
                //????
            }

            if (this.window) {
                this.lockContent();
                this.setLoadingMsg();
                this.request(url, method, params);

                if(url.match(/[&\?]_confirm=/) == null && redirect !== true) {
                    this.stack[this.currentWindow].push(url);
                }

                if (redirect === true) {
                    this.stack[this.currentWindow] = [];
                    this.stack[this.currentWindow].push(url);
                }
            }

            this.triggerHandler('open', [this, url, isNew, method, params]);

            return false;
        },

        refresh: function() {
            var stack = this.stack[this.currentWindow];
            var prevUrl = stack.pop();
            if (prevUrl != undefined) {
                this.open(prevUrl);
            }

            return false;
        },

        close: function(windows) {
            if (this.window) {
                if (this.triggerHandler('beforeclose', [this]) === false){
                    return false;
                }

                if (MZZ.Browser.trident) {
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
                    //this.window.zIndex(902);
                    this.locker.css( 'z-index', this.window.zIndex()-1);
                    this.lockContent();
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

            this.setLoadingMsg();
            this.request(url, method, params);

            return false;
        },

        request: function(url, type, data) {
            var t = this;
            $.ajax({
                url: url,
                type: type,
                data: data,
                cache: false,
                complete: function(data, status, request) {
                    if(status == 'success') {
                        t.successRequest(data, status, request);
                        t.triggerHandler('success', [t, data, status, request]);
                    } else {
                        t.setErrorMsg(data, status, request);
                        t.triggerHandler('error', [t, data, status, request]);
                    }
                    t.triggerHandler('complete', [t, data, status, request]);
                }
            });
        },
        
        windowEvents: function(e, object) {
            if (e.type == 'close') {
                return object._parent.close();
            } else if (e.type == 'kill') {
                return object._parent.triggerHandler(e.type, [this]);
            } else {
                return object._parent.triggerHandler(e.type, [object._parent]);
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
                this.locker.css({'height': win.height(), 'z-index': this.window.zIndex()-1});
                if (this.locker.css('display') != 'block') {
                    win.bind('resize', this.lockerResize);
                    this.hideSelects();
                    this.triggerHandler('lock', [this]);
                    this.locker.fadeIn('slow');
                }
            }
        },

        unlockContent: function() {
            if(this.locker) {
                var t = this;
                this.locker.fadeOut('slow', function() {
                    $(this).css('display', 'none');
                    t.triggerHandler('unlock', [this]);
                    t.showSelects();
                });
            }
        },

        hideSelects: function(id) {
            if (MZZ.Browser.trident) {
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
            if (MZZ.Browser.trident) {
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

                this.window.content(tmp);
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

        setErrorMsg: function (transport, status, request)
        {
            if (this.window) {
                this.setTitle('error');
                var reason = 'Reason: ' + ((transport.status == 404) ? '404 Not found' : '') + ((transport.status == 403) ? '403 Forbidden' : '') + ((transport.status == 500) ? '500 Server sick' : '');
                var message = '<p align="center">' + MZZ.jipI18n[JIP_LANG].error + ' ' + reason + '</p>';
                if (typeof DEBUG_MODE != "undefined" && DEBUG_MODE == true) {
                    message = message + '<div style="width: 700px; border: 1px solid #D6D6D6; background-color: #FAFAFA;font-family: arial, tahoma, verdana; font-size: 12px;padding: 10px; line-height: 140%;">';
                    message = message + '<img style="float: left; margin-right: 7px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAARCAYAAAA7bUf6AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMi8wMi8wOOE6tm4AAAAYdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3Jrc0+zH04AAAHsSURBVDiNlZDNahNhFIaf+clkkknSNNHUohSRYlyIyxYRXLhVL8B7qCIKigUR3IobewOC0EWgdyCIf4sstLSRlopasQhxmkyTSTIZJ/PjIiZlzJTEB87iO3w8vO8RHMcJiOBX+Qad6iu0E1eYWVyN+jJEjFoalfvYtTKZmUXsepnqu+v/J3Gam5g/SqSOXyCuFZiavchvcwujcm9yiVFZJqZOo6g5CDwkSSGVP09j9wVd/eV4idPcwDI+oGXnIfCGo6hZEuk59tdvj5cYlQfEEwUkSQlJCDy0qTP4PRNj8+7REs+uYtXXSWbnABdwyS+UyC+UABdBDEjlzmLureE0N6IlB5+WkZUUsqweJhjw9x1PTBNT0tQ+LkVLOvprkpmT4Rr/SPq1TuF0vtPZWw1LWl+fEfg94onMsEp/BhzuJDmGqhU42HkSljR3n6Nq+ZFjRiUh8EikjuF292lsPwJAaOvl4Ofba+QK5xCl2Mjlj6LbqWG1DU5f/Ybc2H6MomiIogCBG/qYv/QGgPr7yyOSRDJLt6XT2HqI8HmtEKSzsyhqauIUA2yrSdvUkQUxhu854RtMiO/3EMUYYq64RNvU6XbqBL7TrzRmfNfGatWw2nVyxZsIjuMErS9PMXZW8Fx74hSSrJIr3iI9f4c/ZwP51LVnSksAAAAASUVORK5CYII=" alt="exception" />';
                    message = message + '<div style="padding-top: 2px;color: #AA0000;font-size: 120%;font-weight: bold;">DEBUG_MODE: raw response text</div>';
                    message = message + '<div style="line-height: 150%; font-family: verdana, tahoma, arial;margin: 10px 0; font-size:95%;"><pre style="color: black !important;">' + transport.responseText.replace(/\</g, '&lt;') + '</pre></div>';
                    message = message + '</div>';
                }
                this.window.show().content(message);
            }
        },

        clean: function()
        {
            if (this.window) {

                if (tinyMCE) {
                    for (var i = 0, l = this.tinyMCEIds[this.currentWindow].length; i < l; i++) {
                        tinyMCE.execCommand('mceRemoveControl', false, this.tinyMCEIds[this.currentWindow][i]);
                    }
                }

                this.tinyMCEIds[this.currentWindow] = [];
                
                this.setTitle('');
                this.window.show().content('');
            }
        },

        setLoadingMsg: function()
        {
            if (this.window) {
                this.clean();
                this.setTitle('loading...');
                this.window.show().content('<div id="jipLoad"><img src="' + SITE_PATH + '/images/jip/loader.gif" /><br />' + MZZ.jipI18n[JIP_LANG].loading + '<br /><a href="javascript: void(jipWindow.close());">' + MZZ.jipI18n[JIP_LANG].cancel + '</a></div>');
            }
        },

        setRefreshMsg: function()
        {
            if (this.window) {
                this.clean();
                this.setTitle('Refresh');
                this.window.show().content('<div id="jipLoad"><img src="' + SITE_PATH + '/images/jip/loader.gif" /><br />' + MZZ.jipI18n[JIP_LANG].refresh + '</div>');
            }
        },

        refreshAfterClose: function(url)
        {
            url = url || false;
            if (url === true) {
                this.redirectAfterClose = true;
            } else {
                this.redirectAfterClose = url;
            }
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

        setContent: function(content, append)
        {
            if (this.window) {
                this.window.content(content, append);
            }

            return this;
        },

        resize: function()
        {
            if (this.window) {
                this.window.resize();
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

            if (link.hasClass('mzz-jip-link-redirect')) {
                jipWindow.open(link.attr('href'), false, null, null, true);
            } else {
                jipWindow.open(link.attr('href'), link.hasClass('mzz-jip-link-new'));
            }
            
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
