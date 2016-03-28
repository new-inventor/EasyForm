/**
 * Created by George Ionov on 23.03.2016.
 */
(function ($) {
    function RepeatContainer(element, options){
        this.element = $(element);
        this.options = $.extend({
            containerSelector: '',
            blockSelector: '',
            actionsSelector: '',
            addSelector: '',
            deleteSelector: '',
            dummyObject: '',
            fullActionsBlock: '',
            addButton: '',
            deleteButton: ''
        }, options);
        var self = this;

        $(document).on('click.repeat', this.options.actionsSelector + ' ' + this.options.addSelector, function(e){
            self.addBlock(e, self, this);
        });
        $(document).on('click.repeat', this.options.actionsSelector + ' ' + this.options.deleteSelector, function(e){
            self.deleteBlock(e, self, this);
        });
    }

    RepeatContainer.prototype.addBlock = function (e, self, button) {
        e.preventDefault();
        var $button = $(button);
        var $container = $button.closest(self.options.containerSelector);
        var $block = $button.closest(self.options.blockSelector);
        var index = $container.find(self.options.blockSelector).length;
        var $dummy = $(self.options.dummyObject.replace(/#IND#/g, index));
        if ($block.find(self.options.deleteSelector).length == 0) {
            $block.find(self.options.blockSelector).append(self.options.deleteButton);
        }
        $dummy.find(self.options.actionsSelector).remove();
        $dummy.append(self.options.fullActionsBlock);
        $container.append($dummy);
        $button.remove();
    };

    RepeatContainer.prototype.deleteBlock = function (e, self, button) {
        e.preventDefault();
        var $button = $(button);
        var $container = $button.closest(self.options.containerSelector);
        if($container.find(self.options.blockSelector).length < 1){
            return;
        }
        var $block = $button.closest(self.options.blockSelector);
        if($block.find(self.options.addSelector).length > 0){
            $block.prev().find(self.options.actionsSelector).append(self.options.addButton);
        }
        $block.remove();
        if($container.find(self.options.blockSelector).length == 1){
            $container.find(self.options.blockSelector + ":first " + self.options.deleteSelector).remove();
        }
    };

    $.fn.repeatContainer = function (options) {
        this.each(function () {

            var element = $(this);
            if (element.data('repeatContainer')){
                return
            }
            var instance = new RepeatContainer(this, options);

            element.data('repeatContainer', instance);
        });
    };
})(jQuery);
