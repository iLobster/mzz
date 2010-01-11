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
        _bwrap: null,
        _body: null,
        _footer: null,

        _hidden: true,

        init: function(jipCore, options) {
            this._events.push('show', 'beforeshow', 'onshow', 'hide', 'beforehide', 'onhide', 'kill');
            this.parent = jipCore;
            this._prepareDom();
            this.sup();
        },

        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this.dom.attr('id') + ']... Rest in bits');
            this.fire('kill');
            if (this.config.resizeable) {
                this.dom.resizable('destroy');
            }

            if (this.config.draggable) {
                this.dom.draggable('destroy');
            }

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

        content: function(content, append) {
            if (this._body.length > 0) {
                if($.isUndefined(content)) {
                    return this._body;
                }

                append = append || false;
                if (append) {
                    content = this._body.html() + content;
                }

                this._body.html(content);
                return this;
            }

            return false;
        },

        status: function(status, append) {
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
                this.dom.show('fast');
                this.fire('onshow');
            }
            this.fire('show');
            return this;
        },

        hide: function() {
            if (this.hidden !== true && this.fire('beforehide') !== false) {
                this.hidden = true;
                this.dom.hide('fast');
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
                var t = this;
                this.dom = $('<div id="' + this.parent.id + '_window_' + this.parent.currentWindow + '" class="mzz-jip-window" />');
                var tl = $('<div class="mzz-jip-window-tl" />').appendTo(this.dom);
                var tr = $('<div class="mzz-jip-window-tr" />').appendTo(tl);
                var tc = $('<div class="mzz-jip-window-tc" />').appendTo(tr);

                this._header = $('<div class="mzz-jip-window-header" />').appendTo(tc);
                $('<div class="mzz-jip-window-button mzz-jip-window-button-close" />').bind('click', function(e){t.fire('close');}).appendTo(this._header);
                this._title = $('<span class="mzz-jip-window-title" />').appendTo(this._header);

                this._bwrap = $('<div class="mzz-jip-window-bwrap" />').appendTo(this.dom);
                var ml = $('<div class="mzz-jip-window-ml" />').appendTo(this._bwrap);
                var mr = $('<div class="mzz-jip-window-mr" />').appendTo(ml);
                var mc = $('<div class="mzz-jip-window-mc" />').appendTo(mr);

                this._body = $('<div class="mzz-jip-window-body" />').appendTo(mc);
                var bl = $('<div class="mzz-jip-window-bl" />').appendTo(this._bwrap);
                var br = $('<div class="mzz-jip-window-br" />').appendTo(bl);
                var bc = $('<div class="mzz-jip-window-bc" />').appendTo(br);
                var fwrap = $('<div class="mzz-jip-window-fwrap" />').appendTo(bc);

                this._footer = $('<div class="mzz-jip-window-footer" />').appendTo(fwrap);

                this.dom.hide('fast');
                this.dom.appendTo($('body'));
                if ($.isFunction($.fn.draggable)) {
                    this.dom.draggable({'handle': this._header, 'delay': 250, 'containment': 'document', 'opacity': null});
                }

                if ($.isFunction($.fn.resizable)) {
                    this.dom.resizable({'alsoResize': this._body, 'handles': 'se', 'minHeight': 150, 'minWidth': 650});

                }
            }
        }

    });
})(jQuery);