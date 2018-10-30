// fadeOnScroll jQuery plugin
// by Mark Chitty
// Fades elements in or out as you scroll up or down their container (the window by default)
// Uses requestAnimationFrame (with fallback) for GPU enhanced rendering

// Options        : Default : Explanation
// ---------------------------------------
// - parent       : window  : Parent element to monitor for scroll events
// - elemToWatch  : self    : Element (jQuery object or selector string) to monitor for scroll position relative to parent
// - fadeOutStart : 50      : % distance from top of parent at which element starts fading out
// - fadeOutEnd   : 10      : % distance from top of parent at which element is completely faded out
// - dontFade     : false   : Don't do any opacity changing - useful just for hooking the exitedView and enteredView events
//
// Events
// - enteredView.fadeOnScroll - triggered when elemToWatch enters parent viewport
// - exitedView.fadeOnScroll  - triggered when elemToWatch leaves parent viewport
//
// Notes
// - elements are faded proportionally across the fade out zone
// - fadeOutStart > fadeOutEnd : elem visible at bottom of parent, hidden at top = starts visible, fades out on scroll down
// - fadeOutEnd > fadeOutStart : elem visible at top of parent, hidden at bottom = starts hidden, fades in on scroll down
// - Default behaviour: fading elements are visible when they appear at the bottom of the parent element, start
//   fading when they are half-way up the parent element, and disappear completely when they are 10% from the top.
//
//   ┌ Parent ------------------------┐ 0%
//   |             hidden             |
//   |--------------------------------| 10% - fadeOutEnd
//   |        - fade out zone -       |
//   |       elements are faded       |
//   |       proportionally here      |
//   |--------------------------------| 50% - fadeOutStart
//   |                                |
//   |             visible            |
//   |                                |
//   └--------------------------------┘ 100%

// Usage
// require(['jquery', 'jquery.fadeOnScroll'], function($) {
//     $('.js-fadeOnScroll').fadeOnScroll({
//         parent       : window,
//         fadeOutStart : 50,
//         fadeOutEnd   : 10
//     });
// });

// TODO:
// - Set initial opacity on page load based on element position
// - Plugin removal/clean up methods - unhooking event listeners, etc

// http://www.smashingmagazine.com/2011/10/11/essential-jquery-plugin-patterns/
// http://simonsmith.io/writing-amd-compatible-plugins-for-jquery/

// UMD dance - https://github.com/umdjs/umd
!function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    }
    else {
        factory(root.jQuery);
    }
}(this, function ($) {
    'use strict';

    // Default options
    var defaults = {
        parent        : window,
        elemToWatch   : "",
        fadeOutStart  : 50,
        fadeOutEnd    : 10,
        dontFade      : false    // set to true when you just want to use event triggers
    };

    // Polyfill for requestAnimationFrame and cancelAnimationFrame.
    // https://github.com/darius/requestAnimationFrame
    if (!Date.now) Date.now = function() { return new Date().getTime(); };
    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = window['webkitRequestAnimationFrame'];
        window.cancelAnimationFrame  = window['webkitCancelAnimationFrame']
                                    || window['webkitCancelRequestAnimationFrame'];
    }
    if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
    || !window.requestAnimationFrame || !window.cancelAnimationFrame) {
        var lastTime = 0;
        window.requestAnimationFrame = function(callback) {
            var now      = Date.now();
            var nextTime = Math.max(lastTime + 16, now);
            return setTimeout(function() { callback(lastTime = nextTime); }, nextTime - now);
        };
        window.cancelAnimationFrame = clearTimeout;
    }

    // Constructor
    var FadeOnScroll = function($element, options) {

        // Set up the parent element as a FadeOnScrollParent object
        var $parent   = $(options.parent);
        var fosParent = $parent.data('fadeOnScrollParent');
        if (fosParent === undefined) {
            $parent.data('fadeOnScrollParent', fosParent = new FadeOnScrollParent($parent));
        }
        fosParent.addChild(this);

        // Set the elemToWatch - default to self if user defined option doesn't match anything
        var $elemToWatch = $(options.elemToWatch).length > 0 ? $(options.elemToWatch).first() : $element;

        this.element     = $element;
        this.parent      = $parent;
        this.elemToWatch = $elemToWatch;
        this.options     = options;

        // Returns true (and sets inView property) when any part of elemToWatch is within the (vertical) bounds of parent
        this.isInView = function() {
            var elemDims   = $elemToWatch[0].getBoundingClientRect();
            var parentDims = options.parent == window
                           ? { top: 0, bottom: $parent.height() }
                           : $parent[0].getBoundingClientRect();
            this.inView = (elemDims.bottom > parentDims.top && elemDims.top < parentDims.bottom);
            return this.inView;
        };

        this.setFadeLimits = function() {
            this.parentHeight = $parent.outerHeight();
            this.parentTop    = options.parent == window ? 0 : $parent.offset().top;
            this.fadeOutStart = this.parentHeight * parseInt(options.fadeOutStart)/100;
            this.fadeOutEnd   = this.parentHeight * parseInt(options.fadeOutEnd)/100;
        }

        this.isInView();
        this.setFadeLimits();

        // Update the fade points if the window resizes (debounced)
        var resizeTimeout;
        $parent.on('resize.fadeOnScroll', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(this.setFadeLimits, 100);
        });

    };

    // Parent constructor
    // Animation best practice - http://www.html5rocks.com/en/tutorials/speed/animations/
    var FadeOnScrollParent = function($element) {

        var $parent = $element, fadingChildren = [], parentScrollY = 0, drawing = false;
        this.addChild = function(fos) { fadingChildren.push(fos); };

        // Register the onscroll event handler
        // Very lightweight - only stores the scroll position and then calls the animation manager
        $parent.on('scroll.fadeOnScroll', function(e) {
            parentScrollY = $parent.scrollTop();
            requestAnimationTick();
        });

        // Animation manager
        // requestAnimationFrame calls the animating method fadeElems() max once every 16ms (~=60fps)
        // 'drawing' check means next animation is only called when current one has finished
        var requestAnimationTick = function() {
            if (!drawing) window.requestAnimationFrame(fadeElems);
            drawing = true;
        };
     
        // The actual animation function - controls element opacity based on parent scroll position
        var fadeElems = function() {
            for (var i = 0, l = fadingChildren.length; i < l; i++) {
                var fos = fadingChildren[i], $elem = fos.element;
                var wasInView = fos.inView, checkIsInViewNow = fos.isInView();

                // Trigger events when $elem enters or leaves the $parent viewport
                if ( wasInView && !checkIsInViewNow) $elem.trigger('exitedView.fadeOnScroll');
                if (!wasInView &&  checkIsInViewNow) $elem.trigger('enteredView.fadeOnScroll');

                // Do nothing if $elem is not in $parent viewport or it's set to not fade
                if (fos.options.dontFade || (!wasInView && !checkIsInViewNow)) continue;

                // Set opacity value based on vertical offset of elemToWatch
                var posRelToParent = fos.elemToWatch.offset().top - fos.parentTop;
                var opacity        = (posRelToParent - (parentScrollY + fos.fadeOutEnd)) / (fos.fadeOutStart - fos.fadeOutEnd);
                var opacityBounded = Math.min(Math.max(opacity, 0), 1);
                $elem.css({ 'opacity' : opacityBounded, 'visibility' : (opacityBounded ? 'visible' : 'hidden') });
            }
            drawing = false;    // Set drawing to false so next animation call will run
        };
        
    };

    // Plugin methods and shared properties
    // Plugin.prototype = {
    //     someMethod: function() { }
    // }
 
    // Register the plugin with jQuery
    $.fn.fadeOnScroll = function(options) {
        options = $.extend(true, {}, defaults, options);

        // Ceate a new FadeOnScroll instance for each matched jQuery element
        return this.each(function() {
            var $this = $(this);
            $this.data('fadeOnScroll', new FadeOnScroll($this, options));
        });
    };

    // Like most jQuery plugins, this extends the jQuery global object
    // so there's nothing to return to AMD-module-land

});
