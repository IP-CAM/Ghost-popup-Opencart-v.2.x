
(function($) {
var popup_manager = {
    iterator : 0,
    entities : $([]),
    global_config : {
        type: "html",
        content: "",
        overlay: {
            block: void 0,
            tpl: '<div class="ghostpopup-overlay"></div>',
            css: {
                backgroundColor: "#000",
                opacity: 0.6
            }
        },
        container: {
            block: void 0,
            tpl: '<div class="ghostpopup-container"><table class="ghostpopup-table"><tr><td class="ghostpopup-body"></td></tr></table></div>'
        },
        wrap: void 0,
        body: void 0,
        errors: {
            tpl: '<div class="ghostpopup-error ghostpopup-close"></div>',
            autoclose_delay: 2E3,
            ajax_unsuccessful_load: "Error"
        },
        transitionSpeed: 400,
        beforeOpen: $.noop,
        afterOpen: $.noop,
        beforeClose: $.noop,
        afterClose: $.noop,
    },

    getPopup: function(parameters) {
        // console.log(parameters)
        var $this = popup_manager;

        config = $.extend(!0, {}, $this.global_config, parameters);

        if ($.isFunction(this)) {
            var b = $this.config.content;
            parameters.content = "";
            return $this.initPopup($(b), config);
        } else {
            return this.each(function() {
                $this.initPopup($(this), config)
            })
        }
    },
    initPopup: function(element, config) {
        var $this = popup_manager;
        var ghostpopup = element.data("ghostpopup");
        
        if (!ghostpopup) {

            $this.iterator++;
            config.modalID = $this.iterator;
            element.before('<div id="ghostpopupReserve' + config.modalID + '" style="display: none" />');

            $this.buildPopup(element, config);

            $this.entities = $.merge($this.entities, element);

            $.proxy($this.show, element)();

            return element;
        }
    },
    buildPopup: function(element, config) {
        var $this = popup_manager;

        config.overlay.block = $(config.overlay.tpl);
        config.overlay.block.css(config.overlay.css);

        config.container.block = $(config.container.tpl);
        config.body = $(".ghostpopup-body", config.container.block);

        config.body.html(element);

        $this.bindEvents(element, config);
        $this.injectData(element, config);
    },
    bindEvents: function(element, config) {  
        var $this = popup_manager;

        config.overlay.block.add(config.container.block).click(function(event) {
            $this.isClickOut($(">*", config.body), event) && element.ghostpopup("close");
        });

        $(".ghostpopup-close", config.body).bind("click", function() {
            element.ghostpopup("close");
            return !1
        })
    },
    injectData: function(element, config) {
                config.container.block.data("ghostpopupParentEl", element);
                element.data("ghostpopup", config);
    },
    getParentEl: function(a) {
                var b = $(a);
                return b.data("ghostpopup") ? b : (b =
                    $(a).closest(".ghostpopup-container").data("ghostpopupParentEl")) ? b : !1
    },
    transition: function(object, command, speed, e) {
                e = void 0 == e ? $.noop : e;
                "show" == command ? object.fadeIn(speed, e) : object.fadeOut(speed, e);
    },
    isClickOut: function(elements, event) {
                var c = !0;
                console.log( $(event.target) )
                $(elements).each(function() {
                    $(event.target).get(0) == $(this).get(0) && (c = !1);
                    0 == $(event.target).closest("HTML", $(this).get(0)).length && (c = !1)
                });
                return c
    },
        show: function() {
                var $this = popup_manager;
                var $entity = $this.getParentEl(this);

                if (!1 === $entity) 
                {
                    $.error("jquery.ghostpopup: Uncorrect call");
                } else {
                    var object_data = $entity.data("ghostpopup");
                    
                    object_data.overlay.block.hide();
                    object_data.container.block.hide();

                    object_data.wrap.append(object_data.overlay.block);
                    object_data.wrap.append(object_data.container.block);

                    object_data.beforeOpen(object_data, $entity); 
                    $entity.trigger("beforeOpen");

                    object_data.wrap.data("ghostpopupOverflow", object_data.wrap.css("overflow"));
                    object_data.wrap.css("overflow", "hidden");

                    $this.entities.not($entity).each(function() {
                        $(this).data("ghostpopup").overlay.block.hide()
                    });

                    $this.transition(object_data.overlay.block, "show", object_data.transitionSpeed);
                    $this.transition(object_data.container.block, "show", object_data.transitionSpeed, function() {
                        object_data.afterOpen(object_data, $entity);
                        $entity.trigger("afterOpen")
                    });

                    return $entity
                }
        },
        close: function() {
                var $this = popup_manager;

                if ($.isFunction(this)){ 
                    $this.entities.each(function() {
                        $(this).ghostpopup("close")
                    });
                } else {

                    return this.each(function() {
                        var $entity = $this.getParentEl(this);
                        if (!1 === $entity) 
                        {
                            $.error("jquery.ghostpopup: Uncorrect call");
                        } else {
                            var object_data = $entity.data("ghostpopup");
                            console.log(object_data)
                            !1 !== object_data.beforeClose(object_data, $entity) && 
                            (
                                $entity.trigger("beforeClose"), 

                                $this.entities.not($entity).last().each(function() {
                                    $(this).data("ghostpopup").overlay.block.show()
                                }), 

                                $this.transition(object_data.overlay.block, "hide", object_data.transitionSpeed), 
                                $this.transition(object_data.container.block, "hide", object_data.transitionSpeed, function() {
                                    object_data.afterClose(object_data, $entity);
                                    $entity.trigger("afterClose");

                                    $("#ghostpopupReserve" + object_data.modalID).replaceWith(object_data.body.find(">*"));

                                    object_data.overlay.block.remove();
                                    object_data.container.block.remove();

                                    $entity.data("ghostpopup", null);

                                    $(".ghostpopup-container").length || (object_data.wrap.data("ghostpopupOverflow") && object_data.wrap.css("overflow", object_data.wrap.data("ghostpopupOverflow")), object_data.wrap.css("marginRight", 0))
                                }),
                                $this.entities = $this.entities.not($entity)
                            )
                        }
                    })
                }
        },
        init : function () {
            var $this = this;

            $this.global_config.wrap = $("body");

            $(document).bind("keyup.ghostpopup", function(event) {
                var last_popup = $this.entities.last();
                last_popup.length && 27 === event.keyCode && last_popup.ghostpopup("close")
            });

            $.ghostpopup = $.fn.ghostpopup = function(parameters) {

                if ($this[parameters]) {
                    return $this[parameters].apply(this, Array.prototype.slice.call(arguments, 1));
                }
                    
                if ("object" === typeof parameters || !parameters) {
                    return $this.getPopup.apply(this, arguments);
                }

                $.error("jquery.ghostpopup: Method " + parameters + " does not exist")
            }
        }
}
popup_manager.init()
})(jQuery);