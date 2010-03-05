/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipWindow = DUI.Class.create($('<div />'), {
        _header: null,
        _title: null,
        _wrapper: null,
        _content: null,

        _hidden: true,
        
        __body: null,
        __window: null,
        _onWindowResize: null,

        init: function(jipCore) {
            this._parent = jipCore;
            this.__body = $('body');
            this.__window = $(window);
            var t = this;
            this._onWindowResize = function(){t.resize();};

            this.attr({'id': this._parent.id + '_window_' + this._parent.currentWindow, 'class': 'mzz-jip-window'});

            this.append($('<div class="mzz-jip-topLeft"></div><div class="mzz-jip-top"></div><div class="mzz-jip-topRight"></div><div class="mzz-jip-left"></div><div class="mzz-jip-right"></div><div class="mzz-jip-bottomLeft"></div><div class="mzz-jip-bottom"></div><div class="mzz-jip-bottomRight"></div><img alt="window gradient" src="/images/jip/window-bg.png" class="mzz-jip-gradient" />'));
            this._title = $('<span />').appendTo($('<div class="mzz-jip-title" style="" />').appendTo(this));
            $('<a href="" class="mzz-jip-close">x</a>').bind('click', function(e){e.preventDefault();e.stopImmediatePropagation();t._parent.close();}).appendTo(this);
            this._wrapper = $('<div class="mzz-jip-wrapper" />').appendTo(this);
            this._content = $('<div class="mzz-jip-content" style="" />').appendTo(this._wrapper);

            this.appendTo(this.__body);
        },

        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this.attr('id') + ']... Rest in bits');
            this.triggerHandler('kill', [this]);
            this.__window.unbind('resize', this._onWindowResize);
            this.empty();
            this.remove();
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

        resize: function() {
            var t = this;
            setTimeout(function(){
            var wHeight = t.__window.height();
                var cHeight = t._content.outerHeight() + 15;
                var nHeight = cHeight;

                if ((wHeight - 85 - cHeight) < 0) {
                    nHeight = wHeight - 85;
                }

                t._wrapper.height(nHeight);

                t._wrapper.css('overflow', (nHeight != cHeight) ? 'auto' : 'hidden');

                t.css({'top': (wHeight - nHeight - 40)/2});

            }, 1);

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
                this.resize();
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
                return this.css('z-index');
            }

            var oldIndex = this.css('z-index');
            this.css('z-index', zIndex);

            return oldIndex;
        },

        show: function() {
            if (this.hidden !== false && this.triggerHandler('beforeshow', [this]) !== false) {
                this.hidden = false;
                this.css('display', 'block');
                this.__window.bind('resize', this._onWindowResize);
                this.triggerHandler('onshow', [this]);
            }
            this.triggerHandler('show', [this]);
            return this;
        },

        hide: function() {
            if (this.hidden !== true && this.triggerHandler('beforehide', [this]) !== false) {
                this.hidden = true;
                this.css('display', 'none');
                this.__window.unbind('resize', this._onWindowResize);
                this.triggerHandler('onhide', [this]);
            }
            this.triggerHandler('hide', [this]);
            return this;
        },

        toggle: function() {
            if (this.hidden === true) {
                this.show();
            } else {
                this.hide();
            }
            return this;
        }
    });
})(jQuery);