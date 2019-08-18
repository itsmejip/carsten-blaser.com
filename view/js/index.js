$(function() {
    $('.page-pilling-sections').pagepiling({
        menu: '#anchor-menu',
        direction: 'vertical',
        verticalCentered: true,
        sectionsColor: [],
        anchors: ['start','about-me', 'work', 'portfolio', 'skills', 'contact'],
        scrollingSpeed: 700,
        easing: 'swing',
        loopBottom: false,
        loopTop: false,
        css3: true,
        navigation: null,
        normalScrollElements: '#portfolio-detail-modal',
        normalScrollElementTouchThreshold: 10,
        touchSensitivity: 15,
        keyboardScrolling: true,
        sectionSelector: '.section',
        animateAnchor: false,

        //events
        onLeave: function(index, nextIndex, direction){
            if (index == 4) {
                $('.section.work').scrollTop(0);
            } else if (index == 5) {
                $('.section.portfolio').scrollTop(0);
            } else if (index == 6) {
                $('.skill-list').removeClass("animate");
            }
            displayScrollFooter();
        },
        afterLoad: function(anchorLink, index) {
            if (anchorLink == "work") {
                scrollWorkTimer = window.setTimeout(onScrollSectionWork(0.05), 10);
            } else if (anchorLink == "skills") {
                $('.skill-list').addClass("animate");
            } 
        },
        afterRender: function() {
            
        },
    });
});

$(document).ready(function(){
    /**
     * Manual scroll to location hash since we use jquery 3+
     * and it does not work with pagePiling.js
     * 
     * https://github.com/alvarotrigo/pagePiling.js/issues/165
     */
    const locationHash = (location.href.split("#")[1] || "");
    $('.section.portfolio').scrollTop(0);
    $('.section.work').scrollTop(0);
    if (locationHash.length > 0) {
        $('.section.work').scrollTop(0);
        $.fn.pagepiling.moveTo(locationHash);
    }

    /**
     * Langauge selection change
     */
    $('.lang-selection a.lang-item').click(function (e) {
        $('#lang-change-form').attr("action", window.location.href);
        $('#lang-change-form input[name="lang"]').val($(this).data("lang"));
        $('#lang-change-form').submit();
    });

    initAboutMe();

    aboutMeLazyImageLoader();

    createWorkConnections();

    initPortfolio();

    skillsGenerateAnimationDelay();

    skillsInitHighlight();

    initContactForm();

    initStreamNotifier();

    checkStreamNotifier();
});

function displayScrollFooter(length = 2000) {
    $('.scroll-footer').fadeIn(1000);
    clearTimeout($.data($('.scroll-footer'), 'scrollTimer'));
    $.data($('.scroll-footer'), 'scrollTimer', setTimeout(function() {
        $('.scroll-footer').fadeOut(1500);
    }, length));
}