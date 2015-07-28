/*
 * This file extends from ../menu-original.js which is Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com) under http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

var bp = {
    xsmall: 479,
    small: 599,
    medium: 770,
    large: 979,
    xlarge: 1199
};

var windowSize = {};

var rtime;

var getWindowSize = function() {
    windowSize.height = document.viewport.getHeight();
    windowSize.width = document.viewport.getWidth();
};


Event.observe(window, "delayed:resize", function() {
    getWindowSize();
});

var mainNav = function() {

    getWindowSize();

    var main = {
        obj_nav :   $(arguments[0]) || $("megamenu-nav-main"),

        settings :  {
            show_delay                    :   0,
            hide_delay                    :   0,
            window_resize_delay           :   350,
            timeout                       :   false
        },

        init :  function(obj, level) {
            main.initDelayedResizingEvent();
            obj.lists = obj.childElements();
            obj.lists.each(function(el,ind){
                newchildren = el.select('div,ul,section');
                newchildren.each(function(childel,ind){
                    main.handlNavElementBubbling(childel);
                });
                main.handlNavElement(el);
            });
        },

        initDelayedResizingEvent : function()
        {
            Event.observe(window, "resize", function() {
                rtime = new Date();
                if (main.settings.timeout === false) {
                    main.settings.timeout = true;
                    setTimeout(main.resizeend, main.settings.window_resize_delay);
                }
            });

        },

        resizeend : function()
        {
            if (new Date() - rtime < main.settings.window_resize_delay) {
                setTimeout(main.resizeend, main.settings.window_resize_delay);
            } else {
                main.settings.timeout = false;
                Event.fire(window,"delayed:resize");
            }
        },

        handlNavElementBubbling :   function(child) {
            child.onclick = function(e){
                e.stopPropagation();
            }
        },

        handlNavElement :   function(list) {
            if(list !== undefined){

                list.on('touchstart',function(e){
                    list.writeAttribute('was-touch',true);
                });

                list.onmouseover = function(){
                    if(windowSize.width < bp.medium && main.obj_nav.hasClassName('responsive')) {

                    }else{
                        main.fireNavEvent(this, true);
                    }

                };
                list.onmouseout = function(){
                    if(windowSize.width < bp.medium && main.obj_nav.hasClassName('responsive')) {

                    }else{
                        main.fireNavEvent(this, false);
                    }
                };

                list.onclick = function(e){

                    if(windowSize.width < bp.medium || list.readAttribute('was-touch')) {
                        if(this.hasClassName('parent') && main.obj_nav.hasClassName('responsive')) {
                            e.stop();
                            main.fireNavEvent(this, 'toggle');
                        }
                    }

                    list.writeAttribute('was-touch',false);//cleanup
                }
            }
        },


        fireNavEvent :  function(element,active) {
            if(active == true){
                element.addClassName("menu-active");
                element.down("a").addClassName("menu-active");
            } else if(active == false) {
                element.removeClassName("menu-active");
                element.down("a").removeClassName("menu-active");
            } else if(active == "toggle"){
                element.toggleClassName("menu-active");
                element.down("a").toggleClassName("menu-active");
            }
        }
    };
    if (arguments[1]) {
        main.settings = Object.extend(main.settings, arguments[1]);
    }
    if (main.obj_nav) {
        main.init(main.obj_nav, false);
    }
};

document.observe("dom:loaded", function() {
    mainNav("nav", {"show_delay":"100","hide_delay":"100"});
});