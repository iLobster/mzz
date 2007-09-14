Event.__observe = Event.observe;
Event.observe = function(element, name, observer, useCapture, observe){
    observe = (typeof(observe) == 'undefined' ? true : observe);
    return new Event.Observer(element, name, observer, useCapture, observe);
};
Event.Observer = function (element, name, observer, useCapture, observe){
    this.element = element;
    this.name = name;
    this.observer = observer;
    this.useCapture = useCapture;

    observe ? this.start() : this.stop();

    /* prevent memory leaks in IE */
    if (Prototype.Browser.IE){
        Event.__observe(window, 'unload', Event.unloadObserver.bindAsEventListener(Event, this));
    }
};

Event.unloadObserver = function(observer){
    observer.element = null;
    observer.observer = null;
};

Event.Observer.prototype = new function(){
    this.stop = function(){
        if (!this.observe){
            return;
        }
        Event.stopObserving(this.element, this.name, this.observer, this.useCapture);
        this.observe = false;
    };
    this.start = function(){
        if (this.observe){
            return;
        }
        Event.__observe(this.element, this.name, this.observer, this.useCapture);
        this.observe = true;
    };
};


// 1.6.0 features:
document.viewport = {
  getDimensions: function() {
    var dimensions = { };
    $w('width height').each(function(d) {
      var D = d.capitalize();
      dimensions[d] = self['inner' + D] ||
       (document.documentElement['client' + D] || document.body['client' + D]);
    });
    return dimensions;
  },

  getWidth: function() {
    return this.getDimensions().width;
  },

  getHeight: function() {
    return this.getDimensions().height;
  },

  getScrollOffsets: function() {
    return Element._returnOffset(
      window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
      window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop);
  }
};