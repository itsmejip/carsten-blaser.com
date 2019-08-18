function skillsGenerateAnimationDelay() {
    $('.skill-list').each(function (index) {
        if (index > 0) {
            $(this).css("animation-delay", (300 + Math.ceil(Math.random() * 1000)) + "ms");
        }
    });
}

function skillsInitHighlight() {
    $('.word-part').click(function (e) {return false;});
    
    $('.word-part').on("mouseenter", function (e) {
        skillsHighlightSkills($(this).data("keys").split(','), true);
    });

    $('.word-part').on("mouseleave", function (e) {
        skillsHighlightSkills($(this).data("keys").split(','), false);
    });
}

function skillsHighlightSkills(keyArray, highlight) {
    keyArray.forEach(function (item, index)  {
        if (highlight) {
            $('.skill-line[data-key="' + item + '"]').addClass("active");
        } else {
            $('.skill-line[data-key="' + item + '"]').removeClass("active");
        }
    });
}