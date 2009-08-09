/**
 *  MZZ.window: helper class for jipWindow
 */
(function ($){

    MZZ.window = DUI.Class.create({

        //default opts for window
                                 //default layout;
        defaults: {'layout':     $('<div class="mzz-window-title" /><div class="mzz-window-content" /><div class="mzz-window-footer" />'),
                   'style':      'default', //style of the window
                   'baseClass':  false,     //base css-class, that will be appended to the 'holder'
                   'zIndex':     902,       //default window zIndex
                   'visible':    true,      //visible of newly created window
                   'drag':       false,     //is draggable window
                                            //opts for draggable, see jQuery.UI doc @ http://jqueryui.com/demos/draggable/
                   'dragOpts':   {'handle':      '.mzz-window-drag',
                                  'containment': 'document',
                                  'delay':       250,
                                  'opacity':     null},

                   'resize':     false,     //is resizable window
                                            //opts for resizable, see jQuery.UI doc @ http://jqueryui.com/demos/resizable/
                   'resizeOpts': {'alsoResize': false,
                                  'handles':    'se',
                                  'minHeight':   150,
                                  'minWidth':    650},

                   'onKill':     {'animation':   false,    //fadeOut, animate or hide
                                  'speed':       'normal', //fast, normal, slow or number in ms
                                  'params':      null,     //params for animation method
                                  'easing':      null}},   //see jQuery doc @ http://docs.jquery.com/Effects/animate

        /**
         * @constructor
         * @param {Object} params for the newly created window:
         *                        - id {String} of the window
         *                        ... all other see this.defaults;
         */
        init: function(params) {
            var t = this;
            if ($.isUndefined(params.id)) {
                console.log('MZZ.window::init() HALT! "id" not set, class instantinated with params = ', params);
                return;
            }
            
            this._onClose = null; 
            this._params = $.extend(true, {}, this.defaults, params);
            this._em = new MZZ.eventManager(['dragstart', 'drag', 'dragstop', 'resizestart', 'resize', 'resizestop']);
            
            this._holder = $('<div class="mzz-window-holder" />');
            this._holder.attr('id', this._params.id);
            this._holder.append(this._params.layout);
            
            if (this._params.baseClass) {
                this._holder.addClass(this._params.baseClass);
            }
            
            this._content = this._holder.find('.mzz-window-content:first');
            this._title   = this._holder.find('.mzz-window-title:first');
            this._icon    = this._holder.find('.mzz-window-icon:first');
            this._buttons = this._holder.find('.mzz-window-buttons:first');
            this._status  = this._holder.find('.mzz-window-status:last');

            this._holder.appendTo($('body'));

            if (this._params.drag && $.isFunction($.fn.draggable)) {
                if (this._params.dragOpts.handle) {
                    this._params.dragOpts.handle = this._holder.find(this._params.dragOpts.handle);
                }

                if (MZZ.browser.msie) {
                    this._params.dragOpts.opacity = null;  //fix for IE opacity problems
                }

                this._params.dragOpts.start = function(event, ui) {t._em.fire('dragstart', null, event, ui);}
                this._params.dragOpts.drag = function(event, ui) {t._em.fire('drag', null, event, ui);}
                this._params.dragOpts.stop = function(event, ui) {t._em.fire('dragstop', null, event, ui);}

                this._holder.draggable(this._params.dragOpts);
                this._holder.css('position', '');         //for some reasons jQuery sets position: relative
            } else {
                this._params.drag = false;
            }


            if (this._params.resize && $.isFunction($.fn.resizable)) {
                if (this._params.resizeOpts.alsoResize) {
                    this._params.resizeOpts.alsoResize = this._holder.find(this._params.resizeOpts.alsoResize);
                }

                this._params.resizeOpts.start = function(event, ui) {t._em.fire('resizestart', null, event, ui);}
                this._params.resizeOpts.drag = function(event, ui) {t._em.fire('resize', null, event, ui);}
                this._params.resizeOpts.stop = function(event, ui) {t._em.fire('resizestop', null, event, ui);}

                this._holder.resizable(this._params.resizeOpts);
            } else {
                this._params.resize = false;
            }
            
            if (this._params.visible) {
                this.show();
            }

        },
        
        /**
         * Call for the window's brutal death :)
         */
        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this._holder.attr('id') + ']... Rest in bits');
            
            if (this._params.resize) {
                this._holder.resizable('destroy');
            }
            
            if (this._params.drag) {
                this._holder.draggable('destroy');
            }

            this._content = null;
            this._title   = null;
            this._icon    = null;
            this._buttons = null;
            this._status  = null;
            
            if (this._params.onKill) {
                var call = function(){$(this).remove()};
                if (this._params.onKill.animation == 'fadeOut') {
                    this._holder.fadeOut(this._params.onKill.speed, call);
                } else if (this._params.onKill.animation == 'animate') {
                    this._holder.animate(this._params.onKill.params, this._params.onKill.speed, this._params.onKill.easing, call);
                } else if (this._params.onKill.animation == 'hide') {
                    this._holder.hide(this._params.onKill.speed, call)
                } else {
                    this._holder.css({'display': 'block'});
                    this._holder.remove();
                }
            }
        },

        autoSize: function(auto) {
            auto = auto || false;
        },

        /**
         * get/set window Title
         * @param {Mixed} title - text/html to set Title or undefined to get Title object
         * @param {Boolean} append - to exists Title
         * @return null or jQuery(title)
         */
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

        /**
         * get/set window Content
         * @param {Mixed} content - text/html to set Content or undefined to get Content object
         * @param {Boolean} append - to exists Content
         * @return null or jQuery(content)
         */
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
                return this;
            }

            return false;
        },

        /**
         * get/set window Status
         * @param {Mixed} status - text/html to set Status or undefined to get Status object
         * @param {Boolean} append - to exists Status
         * @return null or jQuery(status)
         */
        status: function(status, append) {
            if (this._status.length > 0) {
                if($.isUndefined(status)) {
                    return this._status;
                }

                append = append || false;
                if (append) {
                    status = this._status.html() + status;
                }

                this._status.html(status);
                return this;
            }

            return false;
        },

        /**
         * get/set window Style
         * @param {String} style - css-style name or empty to get current
         * @return {String}
         */
        style: function(style) {
            if ($.isUndefined(style) || !style) {
                return this._params.style;
            }

            var oldStyle = this._params.style;

            if (style != oldStyle) {
                if (oldStyle != 'default') {
                    this._holder.removeClass(oldStyle);
                }

                if (style != 'default') {
                    this._holder.addClass(style);
                }

                this._params.style = style;
            }

            return oldStyle;
        },

        /**
         * get/set zIndex of window
         * @param {Integer} zIndex or empty to get current
         * @return {Integer}
         */
        zIndex: function(zIndex) {
            if (!$.isNumber(zIndex)) {
                return this._params.zIndex;
            }

            var oldIndex = this._params.zIndex;
            this._holder.css('z-index', zIndex);
            this._params.zIndex = zIndex;

            return oldIndex;
        },

        /**
         * get/set Top of window
         * @paran {Integer} to set or empty to get current Top value
         * @return {Integer}
         */
        top: function(top) {
            if ($.isNumber(top)) {
                this._holder.css('top', top);
            } else {
                return this._holder.position().top;
            }
        },

        /**
         * get/set Left of window
         * @paran {Integer} to set or empty to get current Left value
         * @return {Integer}
         */
        left: function(left) {
            if ($.isNumber(left)) {
                this._holder.css('left', left);
            } else {
                return this._holder.position().left;
            }
        },

        /**
         * get window position
         * @return {Hash}
         */
        position: function() {
            return this._holder.position();
        },

        /**
         * Show window
         */
        show: function() {
            this._params.visible = true;
            this._holder.css({
                'display': 'block'
            });
        },

        /**
         * Hide window
         */
        hide: function() {
            this._params.visible = false;
            this._holder.css({
                'display': 'none'
            });
        },

        /**
         * Toggle window
         * @return {Boolean} - true on show, false on hide
         */
        toogle: function() {
            if (this._holder.css('display') == 'none') {
                this.show();
                return true;
            }

            this.hide();
            return false;
        },

        /**
         *
         */
        addButton: function(type, src, style, func) {
            if (this._buttons.length > 0) {
                var img = $('<img />').attr({'src': src, 'title': type}).addClass('mzz-window-button ' + style);

                if ($.isFunction(func)) {
                    img.bind('click', func);
                } else if (type == 'close') {
                    img.bind('click', this, this.onClose);
                }

                img.appendTo(this._buttons);
            }

        },

        /**
         * 
         */
        onClose: function(param) {
            if ($.isFunction(param)) {
                this._onClose = param;
            } else {
                var window = param.data;
                
                if ($.isFunction(window._onClose)) {
                    window._onClose();
                }

                window.kill();
            }
        },

        bind: function(event, callback) {
            return this._em.bind(event, callback);
        },

        undind: function(event, callback) {
            return this._em.unbind(event, callback);
        }
    });
})(jQuery);