$.ajaxSetup({
    headers : {
        'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

$.fn.isInHorViewport = function(top = 1, partially = false){

    var win = $(window);

    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height() * top;

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
    return ((viewport.bottom >= bounds.top && partially) || (viewport.bottom >= bounds.bottom)) && ((viewport.top <= bounds.bottom && partially) || viewport.top <= bounds.top);
};

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
    
    /**
     * Every form needs the csrf_token
     */
    $.each(document.forms, function(index, ele) {
        $(this).append($('<input type="hidden" name="csrf_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" />'));
    });
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}