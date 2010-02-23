/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipWindow = DUI.Class.create($('<div />'), {
        _defaults: {},
        config: {},

        dom: null,
        _header: null,
        _title: null,
        _wrapper: null,
        _content: null,
        _render: null,
        _cRealHeight: 0,
        _cHeight: 0,
        //_footer: null,

        _hidden: true,
        
        __body: null,
        __window: null,
        _onWindowResize: null,

        init: function(jipCore, options) {
            this._parent = jipCore;
            this.__body = $('body');
            this.__window = $(window);
            var t = this;
            this._onWindowResize = function(){t.resize();};
            this._prepareDom();
        },

        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this.dom.attr('id') + ']... Rest in bits');
            this.triggerHandler('kill');
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

        resize: function(force) {
           if (force === true) {
                this._getContentSize();
            }

            var wHeight = this.__window.height();
                var cHeight = this._cRealHeight;
                if ((wHeight - 104 - cHeight) < 0) {
                    cHeight = wHeight - 104;
                }

                if (cHeight != this._cHeight) {
                    this._content.height(cHeight);
                    this._cHeight = cHeight;
                }

                this.dom.css({'top': (wHeight - cHeight - 64)/2});
        },

        _getContentSize: function() {
            this._render.empty();
            this._render.html(this._content.html() /* + "<br />"*/);
            this._render.find('div.jipTitle').remove();
            this._cRealHeight = this._render.outerHeight();
            this._render.empty();
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

                this._content.html(content);
                this.resize(true);
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

        show: function() {
            if (this.hidden !== false && this.triggerHandler('beforeshow', this) !== false) {
                this.hidden = false;
                this.dom.show();
                this.__window.bind('resize', this._onWindowResize);
                this.triggerHandler('onshow');
            }
            this.triggerHandler('show');
            return this;
        },

        hide: function() {
            if (this.hidden !== true && this.triggerHandler('beforehide') !== false) {
                this.hidden = true;
                this.dom.hide();
                this.__window.unbind('resize', this._onWindowResize);
                this.triggerHandler('onhide');
            }
            this.triggerHandler('hide');
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
                var t = this;
                this.dom = $('<div id="' + this._parent.id + '_window_' + this._parent.currentWindow + '" class="mzz-jip-window" />');
                this._wrapper = $('<div class="mzz-jip-wrapper"><div class="mzz-jip-topLeft"></div><div class="mzz-jip-top"></div>' +
                    '<div class="mzz-jip-topRight"></div><div class="mzz-jip-left"></div><div class="mzz-jip-right"></div>' +
                    '<div class="mzz-jip-bottomLeft"></div><div class="mzz-jip-bottom"></div><div class="mzz-jip-bottomRight"></div>' +
                    '<img class="mzz-jip-gradient" src="/images/jip/window-bg.png" alt="window gradient" /></div>').appendTo(this.dom);
                this._body = $('<div class="mzz-jip-body">').appendTo(this._wrapper);
                this._title = $('<span />').appendTo($('<div class="mzz-jip-title" />').appendTo(this._body));
                this._content = $('<div class="mzz-jip-content" />').appendTo($('<div class="mzz-jip-contentwrap" />').appendTo(this._body));
                this._body.append($('<a href="" class="mzz-jip-close">x</a>').bind('click', function(e){e.preventDefault();e.stopImmediatePropagation();t._parent.close();}));
                this.hide();
                this.dom.appendTo(this.__body);

                this._render = $('<div style="width: 600px; overflow: auto" />').hide().appendTo(this.dom);
            }
        }

    });
})(jQuery);