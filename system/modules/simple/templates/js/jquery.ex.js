/* 
 * Сахарный довесок для jQuery из Prototype
 */

var $j = jQuery.noConflict();

/**
 * Cookie tools
 * Made by Vinnie Garcia
 */
var Cookie = {
    set: function(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    },

    get: function(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);
        if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
        } else {
            begin += 2;
        }
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
        return unescape(dc.substring(begin + prefix.length, end));
    },

    remove: function(name, path, domain) {
        if (Cookie.get(name)) {
            document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        }
    }
};

(function ($){

    $.isString = function(object) {
        return typeof object == "string";
    };

    $.isNumber = function(object) {
        return typeof object == "number";
    };

    $.isObject = function(object) {
        return typeof object == "object";
    };
    
    $.isUndefined = function(object) {
        return typeof object == "undefined";
    };

    Array.prototype.remove = function(from, to) {
      var rest = this.slice((to || from) + 1 || this.length);
      this.length = from < 0 ? this.length + from : from;
      return this.push.apply(this, rest);
    };

    MZZ = { /* MZZ top-level namespace */ };

    MZZ.tools = {
        AUTO_ID: 1000,

        getId: function() {
            return ++MZZ.tools.AUTO_ID;
        }
    }
    
    MZZ.browser = DUI.Class.create({

      init: function() {
            this.msie = false;
            this.ie6 = false;
            this.ie7 = false;
            this.ie8 = false;
            this.opera = false;
            this.webkit = false;
            this.konqueror = false;
            this.chrome = false;
            this.safari = false;
            this.gecko = false;
            this.ff = false;

            this.userAgent = navigator.userAgent.toLowerCase();

            if (false /*@cc_on || @_jscript_version < 5.7 @*/) {
                this.msie = this.ie6 = true;
            } else if (false /*@cc_on || @_jscript_version == 5.7 @*/) {
                this.msie = this.ie7 = true;
            } else if (false /*@cc_on || @_jscript_version > 5.7 @*/) {
                this.msie = this.ie8 = true;
            } else if (!!window.opera) {
                this.opera = true;
            } else if (document.childNodes && ( !document.all || navigator.accentColorName ) && !navigator.taintEnabled) {
                this.webkit = true;
                this.konqueror = (navigator.vendor == 'KDE');
                this.chrome = /chrome/.test( this.userAgent );
                this.safari = !this.chrome && /safari/.test( this.userAgent );
            } else if (navigator.product == 'Gecko' && !navigator.savePreferences) {
                this.gecko = true;
                this.ff = /firefox/.test( this.userAgent );
            }
      }

    });

    MZZ.browser = new MZZ.browser;


    MZZ.eventManager = DUI.Class.create({
        _events: [],
        _binds: {},
        _gbind: [],
        _allowAnyEvent: false,
        
        init: function(events) {
            var events = $.isArray(events) ? events : Array.prototype.slice.call(arguments, 0);
            this._events = this._events.concat(events);
            this._bind = {};
            this._gbind = [];
        },

        bind: function(event, cb, once, context) {
            if ($.isFunction(event)) {
                context = once || undefined;
                once = cb || false;
                this._gbind.push({'cb': event, 'once': once, 'context': context});
            } else if ($.isString(event) && $.isFunction(cb)) {
                var t = this;
                once = once || false;
                $.each(event.split(/\s+/), function(i, type) {
                    if ($.inArray(type, t._events) != -1 || this._allowAnyEvent == true) {
                        if (!t._binds[type]) {
                            t._binds[type] = [];
                        }
                        t._binds[type].push({
                            'cb': cb,
                            'once': once,
                            'context': context
                        });
                    }
                });
            }

            return this;
        },

        unbind: function(event, cb) {
            var t = this;
            if ($.isString(event)) {
                $.each(event.split(/\s+/), function(i, type) {
                    if(t._binds[type]) {
                        if ($.isFunction(cb)) {
                            $.each(t._binds[type], function(i) {
                                if (this.cb == cb) {
                                    t._binds[type].remove(i);
                                }
                            });
                            if (t._binds[type].length == 0) {
                                delete t._binds[type];
                            }
                        } else {
                            delete t._binds[type];
                        }
                    }
                });
            } else if ($.isFunction(event)) {
                $.each(this._binds, function(type) {t.unbind(type, event);});
            }

            return this;
        },

        fire: function(event, context, originaltarget) {
            var t = this;
            context = context || this;
            originaltarget = originaltarget || this;
            var args = Array.prototype.slice.call(arguments, 0);
            var push = [{'type': event, 'once': false, 'target': this, 'originaltarget': originaltarget, 'result': undefined, 'originalcontext': context}].concat(args.slice(2));
            
            if(this._binds[event]) {
                $.each(this._binds[event], function(i) {
                    var ccontext = this.context || context;
                    push[0].once = this.once;
                    push[0].result = this.cb.apply(ccontext, push);
                    if (this.cb.once) {
                        t._binds[event].remove(i);
                    }
                });
             
            }

            $.each(this._gbind, function(i) {
                    var cccontext = this.context || context;
                    push[0].once = this.once;
                    push[0].result = this.cb.apply(cccontext, push);
                    if (this.cb.once) {
                        t._gbind.remove(i);
                    }
            });

            return push[0].result;
        }
    });
})(jQuery);

/* IE && Opera`s console.log fix */
if (!window.console) {
	window.console = {
        log: function() {
           if (window.opera) {
               opera.postError(arguments); //use of native opera postError
           } else {
 //              alert(arguments); //other`s ???
           }
        }
    };
}