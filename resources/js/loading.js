window.loading = {
    processCount: 0,
    isBusy: false,

    show: function() {
        const loading = $(".loading");

        if ( loading.is(':visible') ) {
            if(this.processCount === undefined) {
                this.processCount = 0;
            }

            this.processCount++;
            return;
        }

        loading.css({ 'opacity' : '0.7' });
        this.isBusy = true;
        loading.fadeIn();
    },

    hide: function() {
        if(this.processCount > 0) {
            this.processCount--;
            return;
        }

        var loading = $(".loading");
        this.isBusy = false;
        loading.fadeOut();
    }
};
