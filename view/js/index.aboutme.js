
function initAboutMe() {
    /**
     * Set year in aboutme.js
     */
    $('.lifetime').html(new Date().getFullYear() - 1983 + 1); 
}

function aboutMeLazyImageLoader() {
    $('.section.aboutme .image-slider > .lazy-load').lazy({
        effect: 'show',
        onFinishedAll: function() {
            $('.section.aboutme .image-slider .lazy-load').removeAttr("style");
            
            aboutMeChangeImage();
        }
    });
}

function aboutMeChangeImage() {
    const currentPos = parseInt($('.image-slider img.active').data("pos"));
    $('.image-slider img[data-pos="' + (currentPos) + '"]').removeClass("active");
    $('.image-slider img[data-pos="' + (currentPos) + '"]').fadeOut(500, function(e) {
        var ele = null;
        if ($('.image-slider img[data-pos="' + (currentPos + 1) + '"]').length > 0) {
            ele = $('.image-slider img[data-pos="' + (currentPos + 1) + '"]');
        } else {
            ele = $('.image-slider img[data-pos="1"]');
        }
        ele.addClass("active").fadeIn(500);
    });
    $('.section.aboutme .image-slider').data("imageSlideTimer", window.setTimeout(aboutMeChangeImage,Math.ceil(3000 + (Math.random() * 3000))));
}