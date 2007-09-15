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

var mzzRegistry = {
     _registry: $H(),

     get: function(name) {
         return this.has(name) ? this._registry[name] : null;
     },

     set: function(name, value) {
         this._registry[name] = value;
     },

     has: function(name) {
         return $A(this._registry.keys()).indexOf(name) != -1;
     }
}