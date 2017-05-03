

$(document).on('clearServiceOrder', function() {
    var host = window.location.hostname;
    window.open(host+'/check-print/kkm/print','name','height=1,width=1');
});

$(document).on('click','[data-role=main-session]', function() {
    var self = $(this),
        host = window.location.hostname;
    if (self.hasClass('worksess-stop')) {
        window.open(host+'/check-print/kkm/close-session','name','height=1,width=1');
    } else {
        window.open(host+'/check-print/kkm/open-session','name','height=1,width=1');
    }
});