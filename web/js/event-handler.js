if (typeof usesgraphcrt == "undefined" || !usesgraphcrt) {
    var usesgraphcrt = {};
}

usesgraphcrt.checkprint ={
    init: function() {
        $(document).on('successOrderCreate', function() {
            window.open(usesgraphcrt.checkprint.urlToPrint,'name','height=1,width=1');
        });

        $(document).on('click','[data-role=main-session]', function() {
            var self = $(this);
            if (self.hasClass('worksess-stop')) {
                window.open(usesgraphcrt.checkprint.urlToCloseSession,'name','height=1,width=1');
            } else {
                window.open(usesgraphcrt.checkprint.urlToOpenSession,'name','height=1,width=1');
            }
        });
    },
    
    urlToPrint: null,
    urlToOpenSession: null,
    urlToCloseSession: null
};

usesgraphcrt.checkprint.init();