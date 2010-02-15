/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipWindow = DUI.Class.create(MZZ.eventManager.prototype, {
        _defaults: {'shadow':    true,
                    'draggable': true,
                    'draginit':  false,
                    'draghand':  false,
                    'dragopts':  {'handle':      '.mzz-window-drag',
                                  'containment': 'document',
                                  'delay':       250,
                                  'opacity':     null},
                    'resizeable': true,
                    'resizeinit': false,
                    'resizeopts': {'alsoResize': false,
                                   'handles':    'se',
                                   'minHeight':   150,
                                   'minWidth':    650}},
        config: {},

        dom: null,
        _header: null,
        _title: null,
        _wrapper: null,
        _content: null,
        _render: null,
        //_footer: null,

        _hidden: true,

        __body: null,
        __window: null,
        _onWindowResize: null,

        init: function(jipCore, options) {
            this._events.push('show', 'beforeshow', 'onshow', 'hide', 'beforehide', 'onhide', 'kill');
            this.parent = jipCore;
            this.__body = $('body');
            this.__window = $(window);
            var t = this;
            this._onWindowResize = function(){t._onResize()};
            this._prepareDom();
            this.sup();
        },

        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this.dom.attr('id') + ']... Rest in bits');
            this.fire('kill');
            this.__window.unbind('resize', this._onWindowResize);
            this._render.remove();
            this.dom.remove();
        },

        title: function(title, append) {
            if (this._title.length > 0) {
                if($.isUndefined(title)) {
                    return this._title;
                }

                append = append || false;
                if (append) {
                    title = this._title.html() + title;
                }

                this._title.html(title);
                return this;
            }

            return false;
        },

        _resize: function(ch) {
            var wh = this.__window.height();
            var whs = 40 /* shadow */ + 34 /*title*/ + 30 /*content padding*/;
            if ((wh-whs-ch) < 40) {
                ch = wh - whs;
            }
            this._content.height(ch);
            var domTop = (wh - (ch + whs - 40))/2;
            console.log(wh, ch, whs, domTop);
            this.dom.css({'top': domTop});

        },

        _onResize: function() {
            var ch = this._content[0].scrollHeight;
            this._resize(ch);
            //console.log();
        },
        
        content: function(content, append) {
            if (this._content.length > 0) {
                if($.isUndefined(content)) {
                    return this._content;
                }

                append = append || false;
                if (append) {
                    content = this._content.html() + content;
                }

                this._render.empty();
                this._render.html(content);
                var ch = this._render.outerHeight();
                this._content.html(content);
                this._render.empty();
                this._resize(ch);
                return this;
            }

            return false;
        },

        status: function(status, append) {
            return '';
            if (this._footer.length > 0) {
                if($.isUndefined(status)) {
                    return this._footer;
                }

                append = append || false;
                if (append) {
                    status = this._footer.html() + status;
                }

                this._footer.html(status);
                return this;
            }

            return false;
        },

        zIndex: function(zIndex) {
            if (!$.isNumber(zIndex)) {
                return this.dom.css('z-index');
            }

            var oldIndex = this.dom.css('z-index');
            this.dom.css('z-index', zIndex);

            return oldIndex;
        },

        top: function(top) {
            if ($.isNumber(top)) {
                this.dom.css('top', top);
            } else {
                return this.dom.position().top;
            }
        },

        left: function(left) {
            if ($.isNumber(left)) {
                this.dom.css('left', left);
            } else {
                return this.dom.position().left;
            }
        },

        show: function() {
            if (this.hidden !== false && this.fire('beforeshow', this) !== false) {
                this.hidden = false;
                this.dom.show();
                this.__window.bind('resize', this._onWindowResize);
                this.fire('onshow');
            }
            this.fire('show');
            return this;
        },

        hide: function() {
            if (this.hidden !== true && this.fire('beforehide') !== false) {
                this.hidden = true;
                this.dom.hide();
                this.__window.unbind('resize', this._onWindowResize);
                this.fire('onhide');
            }
            this.fire('hide');
            return this;
        },

        toggle: function() {
            if (this.hidden === true) {
                this.show();
            } else {
                this.hide();
            }
            return this;
        },

        _prepareDom: function() {
            if (!this.dom) {
                this.dom = $('<div id="' + this.parent.id + '_window_' + this.parent.currentWindow + '" class="mzz-jip-window" />');
                this._wrapper = $('<div class="mzz-jip-wrapper"><div class="mzz-jip-topLeft"></div><div class="mzz-jip-top"></div>' +
                    '<div class="mzz-jip-topRight"></div><div class="mzz-jip-left"></div><div class="mzz-jip-right"></div>' +
                    '<div class="mzz-jip-bottomLeft"></div><div class="mzz-jip-bottom"></div><div class="mzz-jip-bottomRight"></div>' +
                    '<img class="mzz-jip-gradient" src="/images/jip/window-bg.png" alt="window gradient" /></div>').appendTo(this.dom);
                this._body = $('<div class="mzz-jip-body">').appendTo(this._wrapper);
                this._title = $('<span />').appendTo($('<div class="mzz-jip-title" />').appendTo(this._body));
                this._content = $('<div class="mzz-jip-content" />').appendTo(this._body);

                this.hide();
                this.dom.appendTo(this.__body);

                this._render = $('<div style="max-width: 600px; overflow: auto" />').hide().appendTo(this.__body);
            }
        }

    });
})(jQuery);