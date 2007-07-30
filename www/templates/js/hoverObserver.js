Object.extend(Function.prototype, {
    delay: function() {
        var __method = this, args = $A(arguments), timeout = args.shift() * 1000;
        return window.setTimeout(function() {
            return __method.apply(__method, args);
        }, timeout);
    }
});

Element.addMethods({
    upwards: function(element, iterator) {
        while (element = $(element)) {
            if (iterator(element)) return element;
            element = element.parentNode;
        }
    }
});

var HoverObserver = Class.create();
HoverObserver.prototype = {
    initialize: function(element, options) {
        this.element = $(element);
        this.options = Object.extend({
            activationDelay: 0,
            deactivationDelay:  0.5,
            activeClassName:    "hover",
            targetClassName:    "hover_target",
            containerClassName: "hover_container"
        }, arguments[1] || {});
        this.start();
    },

    start: function() {
        if (!this.observers) {
            this.observers = (['mouseover', 'mouseout']).map(function (name) {
                var handler = this['on' + name.capitalize()].bind(this);
                Event.observe(this.element, name, handler, true);
                return {eventName: name, handler: handler};
            }.bind(this));
        }
    },

    stop: function() {
        if (this.observers) {
            this.observers.each(function(observerInfo) {
                Event.stopObserving(this.element, observerInfo.eventName, observerInfo.handler, true);
            }.bind(this));
            delete this.observers;
        }
    },

    onMouseover: function(event) {
        this.activeElement = Element.extend(Event.element(event));

        var container = this.getElementContainer(this.activeElement);

        if (container) {
            if (this.activeContainer) {
                this.activateContainer(container);
            } else {
                this.startDelayedActivation(container);
            }
        } else {
            this.startDelayedDeactivation();
        }
    },

    onMouseout: function(event) {
        delete this.activeElement;
        this.startDelayedDeactivation();
    },

    activateContainer: function(container) {
        this.stopDelayedDeactivation();

        if (this.activeContainer) {
            if (this.activeContainer == container) {
                return;
            }
            this.deactivateContainer();
        }

        this.activeContainer = container;
        this.activeContainer.addClassName(this.options.activeClassName);
    },

    deactivateContainer: function() {
        if (this.activeContainer) {
            this.activeContainer.removeClassName(this.options.activeClassName);
            delete this.activeContainer;
        }
    },

    startDelayedActivation: function(container) {
        if (this.options.activationDelay) {
        (function() {
            if (container == this.getElementContainer(this.activeElement)) {
                this.activateContainer(container);
            }
        }).bind(this).delay(this.options.activationDelay);
        } else {
            this.activateContainer(container);
        }
    },

    startDelayedDeactivation: function() {
        if (this.options.deactivationDelay) {
            this.deactivationTimeout = this.deactivationTimeout || function() {
                var container = this.getElementContainer(this.activeElement);
                if (!container || container != this.activeContainer) {
                    this.deactivateContainer();
                }
            }.bind(this).delay(this.options.deactivationDelay);
        } else {
            this.deactivateContainer();
        }
    },

    stopDelayedDeactivation: function() {
        if (this.deactivationTimeout) {
            window.clearTimeout(this.deactivationTimeout);
            delete this.deactivationTimeout;
        }
    },

    getElementContainer: function(element) {
        if (!element) return;

        if (element.hasAttribute && !element.hasAttribute("hover_container")) {
            var target = this.getTarget(element, true);
            var container = this.getTarget(target);

            if (container && target) {
                if (!container.id) {
                    container.id = "hover_container_" + new Date().getTime();
                }
                element.upwards(function(e) {
                    // @todo writeAttribute
                    e.setAttribute("hover_container", container.id);
                    if (e == target) {
                        return true;
                    }
                });
            }
        }

        return $(element.readAttribute("hover_container"));
    },

    getTarget: function(element, forElement) {
        if (!element) return;
        forElement = forElement || false;

        var className = forElement ? this.options.targetClassName : this.options.containerClassName;
        return element.upwards(function(e) {
            if (e.hasClassName) {
                return e.hasClassName(className);
            }
        });
    }
};
