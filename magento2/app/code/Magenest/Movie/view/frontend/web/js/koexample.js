define(['uiComponent'], function(Component) {
 
    return Component.extend({
        initialize: function () {
            this._super();
            this.time = Date();
            this.ve = 'VE';
            //time is defined as observable
            this.observe(['time']);
            this.observe(['ve']);
            //periodically updater every second
            setInterval(this.flush.bind(this), 1000);
        },

        testClick: function(){
            this.ve('xxxVEx');
        },

        flush: function(){
            this.time('xxxx');
        }
    });
});