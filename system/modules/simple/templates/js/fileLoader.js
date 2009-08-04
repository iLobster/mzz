/**
 * CSS and Javascript loader
 *
 *
 */
(function ($){

    MZZ.fileLoader = DUI.Class.create({
        init: function() {
            this.head = document.getElementsByTagName("head")[0];
            this.scripts = [];
            this.queue   = [];
            this.loading = false;
            this.callCSS = [];
            this.callJS  = [];
            this.call    = [];
        },

        /**
         * load JS file
         * url {String} - of the script
         * onLoadEnd {Function} - to call on load end
         * onLoadStart {Function} - to call on before load (fired only if not cached)
         * cache {Boolean} - cache control, default - true
         *
         * NOTE: cache control don't work yet
         */
        loadJS: function(url, cb_end, cb_start, cache) {

            url = url || false;

            if (url) {
                //cache = cache || false;
                if (typeof cb_start == 'boolean') {
                    cache = cb_start;
                } else {
                    cache = cache || true;
                }

                if (cache && ( $('script[src=' + url + ']').length > 0 || $.inArray(url, this.scripts) >= 0) ) {
                    this._loaded('js', url, cb_end, 0);
                } else {
                    this.queue.push({'url': url, 'start': cb_start, 'end': cb_end, 'cache': cache});
                    this._check();
                }
            }

        },

        _check: function() {
            if (this.queue.length > 0 && this.loading == false) {
                var self = this;
                var elm = this.queue.shift();
                if (elm.cache && ( $('script[src=' + elm.url + ']').length > 0 || $.inArray(elm.url, this.scripts) >= 0) ) {
                    this._loaded('js', elm.url, elm.start, 0);
                    this._check();
                } else {
                    this.loading = true;
                    $.ajax({ 'type':     'GET',
                         'dataType': 'script',
                         'url':      elm.url,
                         'cache':    elm.cache,
                         'beforeSend': function() {
                             if($.isFunction(elm.start)) {
                                 elms.start(elm.url);
                             }
                         },
//                         'success': function (data, textStatus) {
//                            var w = window;
//
//                            // Evaluate script
//                            if (!w.execScript) {
//                                try {
//                                    eval.call(w, data);
//                                } catch (ex) {
//                                    eval(data, w); // Firefox 3.0a8
//                                }
//                            } else {
//                                w.execScript(data); // IE
//                            }
//                         },
                         'complete':  function(transport, status){
                             if (elm.cache) {
                                 self.scripts.push(elm.url);
                             }
                             self._loaded('js', elm.url, elm.end, status, transport);
                         }
                    });
                }
            }
        },

        /**
         * load CSS file
         * url {String} - of the script
         * callback {Function} - to call on load-success
         *
         */
        loadCSS: function(url, callback) {
            if ($('link[type="text/css"][href=' + url + ']').length > 0) {
                return;
            }
            var self = this;

            var link = $('<link rel="stylesheet" type="text/css" media="all" href="' + url + '"></link>')[0];

			if (MZZ.browser.msie) {
				link.onreadystatechange = function ()	{
                    /loaded|complete/.test(link.readyState) && self._loaded('css', url, callback);
				};
            } else if (MZZ.browser.opera) {
				link.onload = function() {
                    self._loaded('css', url, callback);
                };
            } else {
				(function(){
					try {
						link.sheet.cssRule;
					} catch(e){
						setTimeout(arguments.callee, 20);
						return;
					}
                    self._loaded('css', url, callback);
				})();
            }
            
			this.head.appendChild(link);

        },

        /**
         * callback {Function} - to call
         * type {String} - js | css or everything
         */
        onLoad: function(callback, type) {
            if ($.isFunction(callback)) {
                if (type == 'js') {
                    this.callJS.push(callback);
                } else if (type == 'css') {
                    this.callCSS.push(callback);
                } else {
                    this.call.push(callback);
                }
            }
        },

        /**
         * private event pusher
         */
        _loaded: function(type, url, callback, status, transport) {

            if ($.isFunction(callback)) {
                callback(url, type, status, transport);
            }
            
            if (type == 'css') {
                jQuery.each(this.callCSS, function() {this(url, type, status, transport)});
            } else if (type == 'js') {
                jQuery.each(this.callJS, function() {this(url, type, status, transport)});
                this.loading = false;
                this._check();
            }

            jQuery.each(this.call, function() {this(url, type, status, transport)});
        }
    });

    MZZ.fileLoader = new MZZ.fileLoader;
})(jQuery);

var fileLoader = MZZ.fileLoader;
