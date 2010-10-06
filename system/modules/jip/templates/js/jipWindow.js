// REQUIRE:jquery.ex.js
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($){
    MZZ.jipWindow = DUI.Class.create({
        _dom: null,
        _header: null,
        _title: null,
        _wrapper: null,
        _content: null,
        _footer: null,

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
            this._dom = $('<div />');
            this._dom.attr({'id': this._parent.id + '_window_' + this._parent.currentWindow, 'class': 'mzz-jip-window'});
            this._title = $('<span />').appendTo($('<div class="mzz-jip-title" />').appendTo(this._dom));
            $('<a href="" class="mzz-jip-close">x</a>').bind('click', function(e){e.preventDefault();e.stopImmediatePropagation();t._parent.close();}).appendTo(this._dom);
            this._wrapper = $('<div class="mzz-jip-wrapper" />').appendTo(this._dom);
            this._content = $('<div class="mzz-jip-content" />').appendTo(this._wrapper);
                        this._footer= $('<div class="mzz-jip-footer" />').appendTo(this._dom);

            this._dom.appendTo(this.__body);
        },

        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this._dom.attr('id') + ']... Rest in bits');
            this.triggerHandler('kill', [this]);
            this.__window.unbind('resize', this._onWindowResize);
            this._dom.empty();
            this._dom.remove();
        },

        bind: function(eType, eData, eObject) {
            return this._dom.bind(eType, eData, eObject);
        },

        triggerHandler: function(eType, eParams) {
            return this._dom.triggerHandler(eType, eParams);
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
                var cHeight = t._content.outerHeight();
                console.log(cHeight,wHeight);
                if (cHeight < 70) {
                    cHeight = 70;
                }

                cHeight+= (window.opera) ? 15 : 10;
                
                var nHeight = cHeight;

                if ((wHeight - 57 - cHeight) < 0) {
                    nHeight = wHeight - 57;
                }

                t._wrapper.height(nHeight);
                t._wrapper.css('overflow', (nHeight != cHeight) ? 'auto' : 'hidden');
                t._dom.css({'top': (wHeight - nHeight - 57)/2});
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
                return this._dom.css('z-index');
            }

            var oldIndex = this._dom.css('z-index');
            this._dom.css('z-index', zIndex);

            return oldIndex;
        },

        show: function() {
            if (this.hidden !== false && this.triggerHandler('beforeshow', [this]) !== false) {
                this.hidden = false;
                this._dom.css('display', 'block');
                this.__window.bind('resize', this._onWindowResize);
                this.triggerHandler('onshow', [this]);
            }
            this.triggerHandler('show', [this]);
            return this;
        },

        hide: function() {
            if (this.hidden !== true && this.triggerHandler('beforehide', [this]) !== false) {
                this.hidden = true;
                this._dom.css('display', 'none');
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