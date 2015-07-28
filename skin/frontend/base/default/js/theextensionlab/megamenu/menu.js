var bp = {
    xsmall: 479,
    small: 599,
    medium: 770,
    large: 979,
    xlarge: 1199
};

var megaMenuManager = new Class.create();
megaMenuManager.prototype = {
    initialize : function(navId){
        this.navId = navId;
        this.nav = $(this.navId);
        this.settings = {
            show_delay                    :   0,
            hide_delay                    :   0,
            window_resize_delay           :   350,
            timeout                       :   false
        };
        this.windowSize = {};
        this.initWindowSize();
        this.initMenu();
    },
    initWindowSize : function(){
        this.windowSize.height = document.viewport.getHeight();
        this.windowSize.width = document.viewport.getWidth();
    },
    initMenu : function(){
        this.initDelayedResizingEvent();
        this.lists = this.nav.childElements();
        this.lists.each(this.handleNavElement.bind(this));
    },
    initDelayedResizingEvent : function(){
        menu = this;
        Event.observe(window, "resize", function() {
            rtime = new Date();
            if(menu.settings.timeout === false) {
                menu.settings.timeout = true;
                setTimeout(this.resizeEnd,menu.settings.window_resize_delay)
            }
        });
    },
    resizeEnd : function(){
        if(new Date() - rtime < this.settings.window_resize_delay) {
            setTimeout(this.resizeEnd, this.settings.window_resize_delay);
        } else{
            this.settings.timeout = false;
            Event.fire(window,"delayed:resize");
        }
    },
    handleNavEventBubbling : function(child){
        child.onclick = function(e){
            e.stopPropagation();
        }
    },

    handleNavElement : function(list){

        newChildren = list.select('div,ul,section');
        newChildren.each(this.handleNavEventBubbling.bind(this));

        menu = this;

        if(list !== undefined){
            list.on('touchstart',function(){
                list.writeAttribute('was-touch',true);
            });

            list.on('mouseover', function(){
                if(menu.windowSize.width < bp.medium && menu.nav.hasClassName('responsive')) {

                }else{
                    menu.fireNavEvent(this, true);
                }
            });

            list.on('mouseout', function(){
                if(menu.windowSize.width < bp.medium && menu.nav.hasClassName('responsive')) {

                }else{
                    menu.fireNavEvent(this, false);
                }
            });

            list.onclick = function(e){
                if(menu.windowSize.width < bp.medium || list.readAttribute('was-touch')) {
                    if(this.hasClassName('parent') && menu.nav.hasClassName('responsive')) {
                        e.stop();
                        menu.fireNavEvent(this, 'toggle');
                    }
                }

                //cleanup
                menu.cleanUpTouchData(list);
            }
        }
    },

    cleanUpTouchData : function(element){
        element.writeAttribute('was-touch',false);
    },

    fireNavEvent : function(element,active){
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

document.observe("dom:loaded", function() {
    new megaMenuManager("megamenu-nav-main");
});