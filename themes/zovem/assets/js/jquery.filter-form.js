
(function($, window, document, undefined) {
    $.fn.FilterForm = function(options) {
        var args = arguments;
        if (options === undefined || typeof options === 'object') {
            return this.each(function() {
                if ( !$.data(this, 'FilterForm') ) {
                    $.data(this, 'FilterForm', new FilterForm(this, options));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
            if (Array.prototype.slice.call(args, 1).length == 0 && $.inArray(options, $.fn.FilterForm.getters) != -1) {
                var instance = $.data(this[0], 'FilterForm');
                return instance[options].apply(instance, Array.prototype.slice.call(args, 1));
            } else {
                return this.each(function() {
                    var instance = $.data(this, 'FilterForm');
                    if (instance instanceof FilterForm && typeof instance[options] === 'function') {
                        instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                    }
                });
            }
        }
    };
 
    $.fn.FilterForm.defaults = {
    };
 
 
    function FilterForm(element, options) {
        this.el = element;
        this.$el = $(element);
        this.options = $.extend({}, $.fn.FilterForm.defaults, options);
        this.init();
    }
 
    FilterForm.prototype = {
        init: function() {
            $('select', this.$el).select2({
                allowClear: true,
                dropdownAutoWidth: 'false'
            });
        }
    }
 
})(jQuery, window, document);