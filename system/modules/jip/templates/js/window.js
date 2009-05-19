/**
 *
 * Вспомогательный класс для работы с "оконами" (стоит перенести в modules/simple?)
 *
 * @todo: - autoSize();
 *        - actions & propertise: iconize, minimize, maximize, resize;
 *        - event'ы; ???
 *        - дефолтный стиль для окна.
 */
(function ($){

    MZZ.window = DUI.Class.create({

        /**
         * @constructor
         * @param {Object} params Хэшь параметров создания окна:
         *                        - id {String} идентификатор
         *                        - [style] {String} css-class, в бандле - default-серый, alert-ораньжевый, error-крассный (default: default)
         *                        - [zIndex] {Integer} z-index окна, (default: 902)
         *                        - [visible] {Boolean} сразу показать окно (default: false)
         *                        - [draggable] {Boolean} можно ли таскать окно (default: false)
         */
        init: function(params) {
            this._id = null;
            this._style   = null;
            this._zIndex  = null;
            this._visible = false;
            this._draggable = false;
            this._resizable = false;
            this._onClose = null;

            if ($.isUndefined(params) || $.isUndefined(params.id)) {
                console.log('MZZ.window::init() HALT! "id" not set, class instantinated with params = ', params);
                return false;
            }

            this._id = params.id;
            this._holder = $('<div class="mzz-window-holder" />');
            this._holder.attr('id', this._id);
            this._holder.append((!$.isUndefined(params.layout)) ? $(params.layout) : this._defaultLayout);
            if (!$.isUndefined(params.baseClass)) {
                this._holder.addClass(params.baseClass);
            }
            
            this._content = this._holder.find('.mzz-window-content:first');
            this._title   = this._holder.find('.mzz-window-title:first');
            this._icon    = this._holder.find('.mzz-window-icon:first');
            this._buttons = this._holder.find('.mzz-window-buttons:first');
            this._status  = this._holder.find('.mzz-window-status:last');

            this.style((!$.isUndefined(params.style)) ? params.style : 'default');
            this.zIndex((!$.isUndefined(params.zIndex)) ? params.zIndex : 902);

            this._holder.appendTo($('body'));
            
            if (!$.isUndefined(params.draggable)) {
                this._draggable = true;
                var dParams = {};
                if (params.draggable === true) {
                    dParams = {'containment': 'document', 'delay': 250};
                } else {
                    dParams = params.draggable;
                }

                if ($.isUndefined(params.handle)) {
                    dParams.handle = this._holder.find('.mzz-window-drag')
                }

                if (MZZ.browser.msie) {
                    dParams.opacity = null;
                }
                
                this._holder.draggable(dParams);
                
                this._holder.css('position', ''); //какого-то буя jQuery вешает position: relative от чего окну становиться херовато
            }

            if (!$.isUndefined(params.resizable)) {

                this._resizable = true;
                var rParams = params.resizable;
                if (rParams === true) {
                    rParams = {handles: 'se', minHeight: 100, minWidth: 600};
                } else {
                    // todo: чето я туто хотел доделать :( подумать над клонированием?
                    rParams = params.resizable;
                    if (!$.isUndefined(rParams.alsoResize) && rParams.alsoResize === true) {
                        rParams.alsoResize = this._holder.find('.mzz-window-alsoResize:first');
                        
                    } else {
                        rParams.alsoResize = null;
                    }
                }
                
                this._holder.resizable(rParams);
            }
            
            if (!$.isUndefined(params.visible) && params.visible == true) {
                this.show();
            }
            
        },
        
        /**
         * Call for the window's brutal death :)
         */
        kill: function() {
            console.log('Oh my God!!!, someone brutally killed the window [' + this._holder.attr('id') + ']... Rest in bits');
            if (this._draggable) {
                this._holder.draggable('destroy');
            }
            this._holder.fadeOut('slow', function(){$(this).remove()});
            this._style   = null;
            this._zIndex  = null;
            this._content = null;
            this._title = null;
            this._visible = false;
        },

        /**
         * Авторазмер окна под размер viewport'a броузера
         * @param {Boolean} auto True - для отслеживание изменение viewport'a, false - для однократного / снятия бинда
         */
        autoSize: function(auto) {
            auto = auto || false;
        },

        /**
         * Доступ к заголовку окна
         * @param {Mixed} title - пустое значение для прямого доступа к заголовку
         * @param {Boolean} append - приклеить к существующему или нет
         * @return ничего или объект jQuery(title)
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
         * Доступ к содержимому окна
         * @param {Mixed} content - пустое значение для прямого доступа к содержимому
         * @param {Boolean} append - приклеить к существующему или нет
         * @return ничего или объект jQuery(content)
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
         * Доступ к содержимому статус-бара
         * @param {Mixed} status - пустое значение для прямого доступа к статус-бару
         * @param {Boolean} append - приклеить к существующему или нет
         * @return ничего или объект jQuery(status)
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
         * Установить / получить стиль окна
         * @param {String} style - имя нового стиля или пустое для получение текущего
         * @return Возвращает текущий или старый стиль окна
         */
        style: function(style) {
            if ($.isUndefined(style) || !style) {
                return this._style;
            }

            var oldStyle = this._style;

            if (style != oldStyle) {
                if (oldStyle != 'default') {
                    this._holder.removeClass(oldStyle);
                }

                if (style != 'default') {
                    this._holder.addClass(style);
                }

                this._style = style;
            }

            return oldStyle;
        },

        /**
         * Установить / получить "глубину"(?) окна
         * @param {Integer} zIndex
         */
        zIndex: function(zIndex) {
            if (!$.isNumber(zIndex)) {
                return this._zIndex;
            }

            var oldIndex = this._zIndex;
            this._holder.css('z-index', zIndex);
            this._zIndex = zIndex;

            return oldIndex;
        },

        top: function(top) {
            if ($.isNumber(top)) {
                this._holder.css('top', top);
            } else {
                return this._holder.position().top;
            }
        },

        left: function(left) {
            if ($.isNumber(left)) {
                this._holder.css('left', left);
            } else {
                return this._holder.position().left;
            }
        },

        position: function() {
            return this._holder.position();
        },

        /**
         * Показать окно
         */
        show: function() {
            this._visible = true;
            this._holder.css({
                'display': 'block'
            });
        },

        /**
         * Спрятать окно
         */
        hide: function() {
            this._visible = false;
            this._holder.css({
                'display': 'none'
            });
        },

        /**
         * Затуглить окно
         * @return true - когда открывает окно или false
         */
        toogle: function() {
            if (this._holder.css('display') == 'none') {
                this.show();
                return true;
            }

            this.hide();
            return false;
        },

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

        _defaultLayout: $('<div class="mzz-window-title mzz-window-drag" /><div class="mzz-window-content" /><div class="mzz-window-footer" />')

    });

})(jQuery);