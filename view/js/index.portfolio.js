function initPortfolio() {

    $('a.portfolio-item').click(function (e) {
        initPortfolioModal();
        $('#portfolio-detail-modal').data("scroll-top", $('.section.portfolio').scrollTop());
        $('.section.portfolio').animate({scrollTop:0}, 300, 'swing');
        $('#portfolio-detail-modal').modal({
            backdrop: false,
            focus: true,
            keyboard: true,
            show: true
        });
        requestPortfolioData($(this).attr("id"));
        return false;
    });

    $('#portfolio-detail-modal').click(function (e) {
        if ($(e.target).attr("id") == "portfolio-detail-modal" && $(this).hasClass("show")) {
            $('#portfolio-detail-modal').modal('toggle');
        }
    });

    $('#portfolio-detail-modal').on('show.bs.modal	', function (e) {
        $('.portfolio-container').addClass("hide-entries");
    });

    $('#portfolio-detail-modal').on('hide.bs.modal	', function (e) {
        $('.section.portfolio').animate({scrollTop:$('#portfolio-detail-modal').data("scroll-top")}, 300, 'swing');
    });

    $('#portfolio-detail-modal').on('hidden.bs.modal', function (e) {
        loading(false, true);
        $('.portfolio-container').removeClass("hide-entries");
    });
}

function initPortfolioModal() {
    // Empty lists
    $('#portfolio-detail-modal .list.dev').empty();
    $('#portfolio-detail-modal .list.tools').empty();
    $('#portfolio-detail-modal .list.media').empty();
    $('#portfolio-detail-modal .list.links').empty();

    // Remove title
    $('#portfolio-detail-modal .pf-title').empty();
    $('#portfolio-detail-modal .pf-subtitle').empty();

    // Remove cover
    $('#portfolio-detail-modal .cover img').attr("src", "");
    $('#portfolio-detail-modal .cover img').attr("alt", "");

    // Remove text content
    $('#portfolio-detail-modal .text-content').empty();

    loading(true, false);
    loading(true, true);
}

function loading(show, textContent) {
    if (show) {
        if (textContent) {
            addLoadingSpinner($('#portfolio-detail-modal .text-content'), 3, "#fff");
        } else {
            addLoadingSpinner($('#portfolio-detail-modal .pf-header'), 3, "#fff");
        }
    } else {
        if (textContent) {
            removeLoadingSpinner($('#portfolio-detail-modal .text-content'));
        } else {
            removeLoadingSpinner($('#portfolio-detail-modal .pf-header'));
        }
    }
}

function addLoadingSpinner(container, amount, bgColor) {
    let loadingScreen = $('<div class="loading-screen" style="background-color:' + bgColor + '"></div>');
    $(container).addClass("loading-screen-container");

    for(let i=0;i<amount;i++) {
        let colorName = "text-primary";
        if (i % 6 == 0) {
            colorName = "text-secondary";
        } else if (i % 5 == 0) {
            colorName = "text-success";
        } else if (i % 4 == 0) {
            colorName = "text-info";
        } else if (i % 3 == 0) {
            colorName = "text-info";
        } else if (i % 2 == 0) {
            colorName = "text-danger";
        }
        let spinner = $('<div class="spinner-grow ' + colorName + '" role="status"></div>');
        loadingScreen.append(spinner);
        $(container).append(loadingScreen);
    }
}

function removeLoadingSpinner(container) {
    $('.loading-screen', container).remove();
    $(container).removeClass("loading-screen-container");
}

function requestPortfolioData(id) {
    /**
     * Get details (no text)
     */
    $.ajax({ 
		type: 'post', 
		url: '/ajax.php', 
		dataType: 'json',
		data: { key: 'get_portfolio_details', id: id}, 
		success: function (data) {
            if (data.cover.url.length == 0) {
                data.cover.url = "/shared/portfolio/no-image.png";
            }
            $('#portfolio-detail-modal .cover').data("orig", data.cover.url);
            $('#portfolio-detail-modal .cover img').attr("src", data.cover.url);
            $('#portfolio-detail-modal .cover img').attr("alt", data.cover.alt);
            $('#portfolio-detail-modal .pf-title').html(data.title);
            $('#portfolio-detail-modal .pf-subtitle').html(data.subtitle);

            let container = $('#portfolio-detail-modal .list.dev');
            if (data.dev.length > 0) {
                container.closest('.details').show();
                $.each(data.dev, function (index, value) {
                    container.append($('<div class="entry line">' + value  + '</div>'));
                }); 
            } else {
                container.closest('.details').hide();
            }

            container = $('#portfolio-detail-modal .list.tools');
            if (data.tools.length > 0) {
                container.closest('.details').show();
                $.each(data.tools, function (index, value) {
                    container.append($('<div class="entry line">' + value  + '</div>'));
                }); 
            } else {
                container.closest('.details').hide();
            }

            container = $('#portfolio-detail-modal .list.links');
            if (data.link.length > 0) {
                container.closest('.details').show();
                $.each(data.link, function (index, value) {
                    let link = $('<div class="entry line"></div>');
                    if (value.icon != null) {
                        link.append($('<i class="' + value.icon + '"></i>'));
                    }

                    let a = $('<a href="' + value.url + '">' + value.caption + '</a>');
                    link.append(a);
                    if (value.external) {
                        a.attr('target', '_blank');
                        link.append($('<i class="fas fa-external-link-alt"></i>'));
                    }
                    
                    container.append(link);
                }); 
            } else {
                container.closest('.details').hide();
            }

            container = $('#portfolio-detail-modal .list.media');
            if (data.media.length > 0) {
                container.closest('.details').show();
                $.each(data.media, function (index, value) {
                    let entry = $('<a class="entry media" data-toogle="tooltip" data-placement="bottom" title="' + value.caption + '" data-type="' + value.type + '"></a>');
                    entry.attr("href", value.url);
                    entry.attr("rel", "noreferrer");
                    if (value.url.charAt(0) != "#") {
                        entry.attr("target", '_blank');  
                    }
                    let symbol = "";
                    switch(value.type) {
                        case "pdf":
                            symbol = "fas fa-file-pdf";
                            break;
                        case "image":
                            symbol = "fas fa-images";
                            break;
                        case "json": 
                        case "log":
                            symbol = "fas fa-file-code";
                            break;
                        case "video":
                            if (value.external) {
                                symbol = "fab fa-youtube";
                            } else {
                                symbol = "far fa-file-video";
                            }
                            break;
                        default:
                            symbol = "fas fa-question-circle"
                            break;
                    }

                    entry.append($('<i class="fa-2x ' + symbol + '"></i>'));
                    container.append(entry);
                }); 

                $('.entry.media', container).tooltip({trigger : 'hover'});

                $('.entry.media[data-type="image"]', container).mouseenter(function (e) {
                    const src = $(this).attr("href");
                    $('#portfolio-detail-modal .cover img').fadeOut(200, function(e) {
                        $(this).attr("src", src);
                        $(this).fadeIn(200);
                    });
                });

                $('.entry.media[data-type="image"]', container).mouseleave(function (e) {
                    const src =  $('#portfolio-detail-modal .cover').data("orig");
                    $('#portfolio-detail-modal .cover img').fadeOut(200, function(e) {
                        $(this).attr("src", src);
                        $(this).fadeIn(200);
                    });
                });
            } else {
                container.closest('.details').hide();
            }

            loading(false, false);
		},
		error: function (xhr, status, error) {
            console.log(xhr);
            loading(false, false);
		}
    });
    
    /**
     * Get detail text
     */
    $.ajax({ 
		type: 'post', 
		url: '/ajax.php', 
		dataType: 'html',
		data: { key: 'get_portfolio_text', id: id}, 
		success: function (data) {
            $('#portfolio-detail-modal .text-content').append(data);
            loading(false, true);
		},
		error: function (xhr, status, error) {
            console.log(xhr);
            $('#portfolio-detail-modal .text-content').append($(xhr.responseText));
            loading(false, true);
		}
	});
}
