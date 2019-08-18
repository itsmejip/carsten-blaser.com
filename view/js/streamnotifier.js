function initStreamNotifier() {
    const notifier = $('.stream-notifier');
    // Do not show it again
    $('.info-close a', notifier).click(function (e) {
        setCookie('jip_streamnotifier', "0");
        console.log(getCookie('jip_streamnotifier'));
        hideStreamNotifier();
        return false;
    });

    $('a.goto-link', notifier).click(function (e) {
        hideStreamNotifier();
        return true;
    });
}

function hideStreamNotifier() {
    const notifier = $('.stream-notifier');
    notifier.fadeOut(300, function(e) {
        $('.timeline', notifier).removeClass("run");
    });
}

function showStreamNotifier() {
    const notifier = $('.stream-notifier');
    notifier.fadeIn(300);
    window.clearTimeout($.data(notifier, "fadeOutTimer"));
    $('.timeline', notifier).addClass("run");
    $.data(notifier, "fadeOutTimer", setTimeout(hideStreamNotifier, 9200));
}

/**
 * Function calls AJAX and let server check if stream is live
 */
function checkStreamNotifier() {
    // If user do not want to see the notifier
    var canShow  = getCookie('jip_streamnotifier');
    if (canShow == "0") {
        return;
    }

    const notifier = $('.stream-notifier');
    // Ajax implementation
    $.ajax({ 
		type: 'post', 
		url: '/ajax.php', 
		dataType: 'json',
		data: { key: 'check_livestream'}, 
		success: function (data) {
            if (data.isLive) {
                $('.display-name', notifier).html(data.display_name);
                $('.goto-link', notifier).attr('href', "https://www.twitch.tv/" + data.channel_name);
                showStreamNotifier();
            }
		},
		error: function (xhr, status, error) {
            // Do nothing. It is not that important that the stream info is shown.
		}
	});
}