(function ($){
    $.widget("ui.mzzWindow", {
        // default options
        options: {
            layout: '<div class="mzz-window-header" /><div class="mzz-window-content" /><div class="mzz-window-footer" />',
            autoOpen: false,
            closeOnEscape: false,
            focusLast: true,
            id: null,
            idPrefix: null,
            idPostfix: null,
            base_class: '',
            draggable: true,
            resizable: true,
            handles: 'se',
            top: 0,
            left: 0,
            width: 300,
            height: 'auto',
            minWidth: 150,
            minHeight: 150,
            maxWidth: false,
            maxHeight: false,
            title: '&nbsp;',
            status: '&nbsp;'
        },

        _dom: null,
        _window: null,
        _header: null,
        _content: null,
        _footer: null,
        _overlay: null,
        _original: null,
        _isOpen: false,

        _create: function() {
            var t = this;

            var onKeyDown = function(event) {
                if (t.options.closeOnEscape && event.keyCode &&
                    event.keyCode === $.ui.keyCode.ESCAPE) {

                    t.close(event);
                    event.preventDefault();
                }
            };

            var onMouseDown = function(e) {
                t.moveToTop(e);
            };

            var onFocusIn = function(e) {
                $('body > .mzz-window-active').focusout();
                t._dom.addClass('mzz-window-active');
                // if (MZZ.Browser.Engine.presto && e.type !== 'focus') { t._dom.focus() }
                t._trigger('focus', e);
            };

            var onFocusOut= function(e) {
                t._dom.removeClass('mzz-window-active');
                t._trigger('blur', e);
            };


            this.options.id = ((this.options.idPrefix) ? this.options.idPrefix + '_' : '') + 'mzzWindow' + ((this.options.idPostfix) ? '_' + this.options.idPostfix : '') + '_' + MZZ.tools.getId();
            this._dom = $('<div />').hide()
                                                    .appendTo($('body'))
                                                    .attr('id', this.options.id)
                                                    .attr('tabIndex', -1)
                                                   .addClass('mzz-window ' + this.options.base_class)
                                                   .css({'position': 'absolute',
                                                             'z-index': MZZ.tools.maxZ() + 2,
                                                             'top': this.options.top,
                                                             'left': this.options.left,
                                                             'width': this.options.width})
                                                   .append($(this.options.layout))
                                                   .mousedown(onMouseDown)
                                                   .keydown(onKeyDown)
                                                   .focusin(onFocusIn)
                                                   .focusout(onFocusOut);

            if (MZZ.Browser.Engine.presto) {
                this._dom.focus(onFocusIn).blur(onFocusOut);
            }

            this._original = $('<div id="' + this.options.id + '_original" class="mzz-window-orignal-holder">place holder</div>').insertAfter(this.element);

            this._content = this._dom.find('.mzz-window-content').append(this.element);
            this._header = $('<span />').html(this.options.title);
            this._dom.find('.mzz-window-header').append(this._header);
            this._footer = $('<span />').html(this.options.status);
            this._dom.find('.mzz-window-footer').append(this._footer);
            if (this.options.draggable && $.fn.draggable) {
                this._makeDraggable();
            }

            if (t.options.resizable && $.fn.resizable) {
                    this._makeResizable();
            }

             if (this.options.autoOpen) {
                this.open();
            }
        },

        _makeDraggable: function() {
            var t = this,
            doc = $(document),
            heightBeforeDrag;

            function filteredUi(ui) {
                return {
                    position: ui.position,
                    offset: ui.offset
                };
            }

            t._dom.draggable({
                cancel: '.mzz-window-content, .mzz-window-header span',
                handle: '.mzz-window-header',
                containment: 'document',
                start: function(event, ui) {
                    heightBeforeDrag = t.options.height === "auto" ? "auto" : $(this).height();
                   t._dom.height(t._dom.height()).addClass("mzz-window-dragging");
                    t._trigger('dragStart', event, filteredUi(ui));
                },
                drag: function(event, ui) {
                    t._trigger('drag', event, filteredUi(ui));
                },
                stop: function(event, ui) {
                    t.options.position = [ui.position.left - doc.scrollLeft(),
                        ui.position.top - doc.scrollTop()];
                    t._dom.removeClass("mzz-window-dragging").height(heightBeforeDrag);
                    t._trigger('dragStop', event, filteredUi(ui));
                }
            });
        },

        _makeResizable: function(handles) {
            handles = (handles === undefined ? this.options.resizable : handles);
            var t = this,
            position = this._dom.css('position'),
            resizeHandles = (typeof handles === 'string' ? handles: 'n,e,s,w,se,sw,ne,nw'), heightDiff;

            function filteredUi(ui) {
                return {
                    originalPosition: ui.originalPosition,
                    originalSize: ui.originalSize,
                    position: ui.position,
                    size: ui.size
                };
            }

            this._dom.resizable({
                cancel: '.mzz-window-content',
                containment: 'document',
                alsoResize: this._content,
                maxWidth: this.options.maxWidth,
                maxHeight: this.options.maxHeight,
                minWidth: this.options.minWidth,
                minHeight: this.minHeight(),
                handles: resizeHandles,

                start: function(event, ui) {
                    t._dom.addClass("mzz-window-resizing");
                    heightDiff = t._dom.height() - t._content.height();
                    t._trigger('resizeStart', event, filteredUi(ui));
                },

                resize: function(event, ui) {
                    t._trigger('resize', event, filteredUi(ui));
                },

                stop: function(event, ui) {
                    t._dom.removeClass("mzz-window-resizing");
                    t.options.height = t._dom.height();
                    t.options.width = t._dom.width();
                    t._content.height(t._dom.height() - heightDiff); //fixing fucking jQuery.ui bug, when its continuing resizing 'alsoResize' element
                    t._trigger('resizeStop', event, filteredUi(ui));
                }
            })
            .css('position', position)
            .find('.ui-resizable-se').addClass('ui-icon ui-icon-grip-diagonal-se');
        },

        destroy: function() {
            this.element.insertAfter(this._original);
            this._original.remove();
            this._dom.remove();
            $.Widget.prototype.destroy.apply( this, arguments );
        },

        moveToTop: function(event) {
            var maxZ = MZZ.tools.maxZ();
            if (maxZ != parseInt(this._dom.css('z-index'))) {
                this._dom.css('z-index', maxZ + 2);
            }

            if(!this._dom.hasClass('mzz-window-active')){
                this._dom.focusin().focus();
            }

            return this;
        },

        minHeight: function() {
                if (this.options.height === 'auto') {
                      return   this.options.minHeight;
                } else {
                       return Math.min(this.options.minHeight, this.options.height);
                }
        },

        open: function(options) {
            var showOptions = options || this.options.show;
            if (this._isOpen || false === this._trigger('beforeOpen')) {
                return;
            }

            this._dom.show(showOptions);
            this.moveToTop();

            if (this.options.modal) {
                    this._dom.bind('keypress.mzz-window', function(event) {
                            if (event.keyCode !== $.ui.keyCode.TAB) {
                                    return;
                            }

                            var tabbables = $(':tabbable', this),
                                    first = tabbables.filter(':first'),
                                    last  = tabbables.filter(':last');

                            if (event.target === last[0] && !event.shiftKey) {
                                    first.focus(1);
                                    return false;
                            } else if (event.target === first[0] && event.shiftKey) {
                                    last.focus(1);
                                    return false;
                            }
                    });
            }

           this._trigger('open');
           this._isOpen = true;
           return self;
        },

        close: function(event) {
            var t = this;
            if (false === this._trigger('beforeClose', event)) {
                return;
            }

            this._dom.unbind('keypress.mzz-window');

            if (this.options.hide) {
                    this._dom.hide(this.options.hide, function() {
                            this._trigger('close', event);
                    });
            } else {
                    this._dom.hide();
                    this._trigger('close', event);
            }

            this._isOpen = false;

            //if (this.options.focusLast) {
            //    this._showLast();
            //}
        },

        title: function(title) {
            if (this._header.length > 0) {
                if($.isUndefined(title)) {
                    return this._header;
                }

                this._header.html(title);
            }
        },

        content: function(content) {
            if (this.element.length > 0) {
                if($.isUndefined(content)) {
                    return this.element;
                }

                this.element.html(content);
              //  this.resize();
            }
        },

        status: function(status) {
            if (this._footer.length > 0) {
                if($.isUndefined(status)) {
                    return this._footer;
                }

                this._footer.html(status);
            }
        },

        _showLast: function() {
                var last, maxZ = 0;
                $.each( $('body > .mzz-window:visible'),
                function(i,e) {
                        var e = $(e);
                        var z = parseInt(e.css('z-index'));
                        if (z > maxZ) {
                            maxZ =z;
                            last = e;
                        }
                });

                if (last) {
                    last.focusin().focus();
                }
        }
    });
})(jQuery);