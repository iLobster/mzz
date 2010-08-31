// REQUIRE:jquery.ex.js;jquery-ui/ui.core.js;jquery-ui/ui.widget.js
/* 
 * todo пофиксить баг определения sortable когда нет handler'а
 * добавить поддержу disable, добавить event'ов (start, stop, drag)?
 * документировать?
 */
(function($){
   $.widget("ui.mzz_ns",{

        options: {
            placeHolder: '<li />',
            sortables: 'li',
            handler: '.mzz-ns-handler',
            droppables: 'li',
            droppableHeight: false,
            dropInside: true,
            childPlace: 'ul',
            childWrap: '<ul class="mzz-ns-data" />',
            childOffset: 50, 
            cloneOpacity: 1
        },

        _create: function() {

            this._options    = $.extend({},this.options);
            this._document   = $(document);
            this._body       = $('body');
            this._sortable   = $(this.element);
            this._sortableId = this._sortable.attr('id');
            this._current    = null;
            this._currentId  = null;
            this._clone      = null;
            this._over       = null;
            this._after      = null;
            this._child      = null;
            this._place      = null;
            this._changed    = false;
            this._hash       = null;
            this._serialize  = null;
            this._serializeId = null;

            var self         = this;

            var mouseLeave = function(e) {
                self._sortable.find('.mzz-ns-placeholder').remove();
                self._over  = null;
                self._after = null;
                self._child = null;
                self._place = null;
                return false;
            };

            var mouseUp = function(e) {
                    if (self._place && self._current) {
                        self._place.hide();
                        self._current.insertAfter(self._place).show();
                        self._changed = true;
                        self._trigger('drop', e, {'sortable': self._current});
                        if (self._child == true) {
                            self._place.parents('.mzz-ns-wrap,.mzz-ns-data').removeClass('mzz-ns-wrap mzz-ns-placeholder mzz-ns-data');
                        }
                    }

                    self._cleanUp();
                    self._unBind();
                    self._body.css('cursor', 'auto');
                    return false;
            };

            var moveClone = function(e) {
                if (self._clone) {
                    self._clone.css ({
                        top: e.pageY + 1,
                        left: e.pageX + 1
                    });
                }
            };

            var overItem = function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    moveClone(e);

                    $this = $(this);

                    if (self._over != $this.attr('id')) {
                        self._over = $this.attr('id');
                        self._after = null;
                        self._child = null;
                        self._place = null;
                    }

                    var t = $this.offset().top;
                    var l = $this.offset().left;
                    var eh = $this.height();
                    var h = (self._options.droppableHeight == false) ? eh : self._options.droppableHeight;

                    var w = $this.width();

                    var ph = $(self._options.placeHolder).bind('mousemove.mzz-ns-item', function(e){doNothing(e); moveClone(e);}).addClass('mzz-ns-placeholder').hide();

                    if (e.pageY >= t && e.pageY < (t + h/2 - 1) ) {
                        if (self._after != false) {
                           self._after = false; self._child = false;
                           if (!$this.prev().hasClass('mzz-ns-placeholder')) {
                               self._sortable.find('.mzz-ns-placeholder').remove();
                               $this.before(ph);
                               ph.show();
                               self._place = ph;
                           }
                        }
                    } else if (e.pageY >(t + h/2) &&  e.pageY <= (t + eh)) {
                        if (e.pageX > l + self._options.childOffset && e.pageY <= (t + h)) {
                            if (self._after != true || self._child != true) {
                                self._after = true; self._child = true;
                                var cp = $this.find(self._options.childPlace + ':first');
                                if (cp.length == 0) {
                                    self._sortable.find('.mzz-ns-placeholder').remove();
                                    cp = $(self._options.childWrap).addClass('mzz-ns-placeholder mzz-ns-wrap');
                                    if (cp.hasClass('mzz-ns-data')) {
                                        ph.appendTo(cp);
                                    } else {
                                        ph.appendTo(cp.find('.mzz-ns-data:first'));
                                    }
                                    if (self._options.dropInside) {
                                        $this.append(cp);
                                    } else {
                                        $this.after(cp);
                                    }
                                    cp.show();
                                    ph.show();
                                    self._place = ph;
                                } else {
                                    if (!cp.children(':first').hasClass('mzz-ns-placeholder')) {
                                        self._sortable.find('.mzz-ns-placeholder').remove();
                                        cp.prepend(ph);
                                        ph.show();
                                        self._place = ph;
                                    }

                                }
                            }
                        } else {
                            if (self._after != true || self._child == true) {
                                self._after = true; self._child = false;
                                if (!$this.next().hasClass('mzz-ns-placeholder')) {
                                    self._sortable.find('.mzz-ns-placeholder').remove();
                                    $this.after(ph);
                                    ph.show();
                                    self._place = ph;
                                }
                            }
                        }
                    }
            };

            var mouseDown = function(e) {
                if (e.button != 2) {
                    $target = $(e.target);
                    $this = $(this);
                    self._current = null;

                    if ($target.hasClass('mzz-ns-handler')) {
                        if ($this.hasClass('mzz-ns-sortable')) {
                            self._current = $this;
                        } else {
                            self._current = $this.parents(self._options.sortables + ':first');
                        }

                    }

                    if (self._current) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        self._body.css('cursor', 'move');

                        self._clone = self._current.clone();
                        self._current.addClass('mzz-ns-current');

                        self._clone.attr('id', 'mzz-ns-clone').addClass('mzz-ns-clone').css({
                            'position': "absolute",
                            'top': e.pageY + 1,
                            'left': e.pageX + 1,
                            'list-style-type': 'none',
                            'opacity': self._options.clone_opacity,
                            'width': self._current.width() / 2
                        })
                        
                        self._current.hide();

                        self._document.bind('selectstart.mzz-ns-item', doNothing)
                                      .bind('mousemove.mzz-ns-item', moveClone)
                                      .bind('mouseup.mzz-ns-item', mouseUp);

                        self._sortable.bind('dblclick.mzz-ns-item', doNothing)
                                      .find(self._options.droppables + ':visible:not(.mzz-ns-current)')
                                      .bind('mousemove.mzz-ns-item', overItem);
                        self._clone.appendTo(self._body);

                    }
                    return false;
                }



            };

            var doNothing = function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            };

            var binds = this._sortable.bind('mouseleave.mzz-ns', mouseLeave).find(this._options.sortables);
            for (var i = 0, l = binds.length; i < l; i++) {
                var bind = $(binds[i]);
                var handlers = bind.addClass('mzz-ns-sortable').find(this._options.handler).addClass('mzz-ns-handler').bind('click.mzz-ns', doNothing).bind('mousedown.mzz-ns', mouseDown).bind('selectstart.mzz-ns', doNothing);
                if (handlers.length == 0) {
                    bind.bind('mousedown.mzz-ns', mouseDown);
                } else {
                }
            }
        },

        _cleanUp: function() {

            this._sortable.find('.mzz-ns-clone').remove();
            this._sortable.find('.mzz-ns-placeholder').remove();

            this._clone.remove();
            this._clone = null;
            this._after = null;
            this._child = null;
            this._over = null;

            if (this._current) {
                this._current.show();
                this._current.removeClass('mzz-ns-current');
            }

            this._current = null;
        },

        _unBind: function(all) {
            this._document.unbind('.mzz-ns-item');
            this._sortable.unbind('.mzz-ns-item').find(this._options.droppables).unbind('.mzz-ns-item');

            if (all) {
                this._sortable.unbind('.mzz-ns').find(this._options.sortables).unbind('.mzz-ns');
            }
        },

        serialize: function(id) {
            id = id || this._sortableId;
            if (this._changed || !this._serialize || id != this._serializeId) {
                this._serialize = this._reSerialize(this.hash(), id);
            }
            return this._serialize;
        },

        _reSerialize: function(hash, path) {

            var serialize = '';

            for(var key in hash) {
                serialize = serialize + path + '[' + key + '][id]=' + hash[key].id + '&';
                if (hash[key].childs) {
                    serialize = serialize + this._reSerialize(hash[key].childs, path + '[' + key + '][childs]');
                }
            }
            return serialize;

        },

        hash: function() {
            if (this._changed || !this._hash) {
                this._hash = this._reHash(this._sortable);
            }
            return this._hash;
        },

        _reHash: function(root) {
                var res = {};
                var childs = root.children(this._options.sortables);
                for (var i = 0, l = childs.length; i < l; i++) {
                    var hash = {};
                    child = $(childs[i]);
                    hash['id'] = child.attr('id');
                    var schilds = child.find(this._options.childPlace + ':first');
                    if (schilds.length > 0) {
                        hash['childs'] = this._reHash($(schilds));
                    }
                    res[i] = hash;
                }
                return res;
            },

        destroy: function() {
            $.widget.prototype.apply(this, arguments);
        }
    });

})(jQuery);