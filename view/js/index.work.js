var workLoaded = false;

function createWorkConnections() {
    // If resize occurs we need to redraw work connections
    $(window).resize(function() {
        if ($('.section.work').data("resizeWorkTimer")) {
            window.clearTimeout($('.section.work').data("resizeWorkTimer"));
        }
        $('.section.work').data("resizeWorkTimer", window.setTimeout(function (e) {createWorkConnections(); onScrollSectionWork(0.01); },500));
    });

    var ele0 = $('.work-entry[data-way="0"]');
    var ele1 = $('.work-entry[data-way="1"]');
    var ele2 = $('.work-entry[data-way="2"]');
    var ele3 = $('.work-entry[data-way="3"]');
    var ele4 = $('.work-entry[data-way="4"]');
    var ele5 = $('.work-entry[data-way="5"]');
    var ele6 = $('.work-entry[data-way="6"]');
    var ele7 = $('.work-entry[data-way="7"]');

    const workItemOffset = 20;
    const workItemStepSize = 100;
    // Remove connection and steps
    $('.work-connection').remove();

    drawWorkEntryBeziers(workItemOffset, workItemStepSize);

    $('.section.work').scroll(function() {
        if ($('.section.work').data("scrollWorkTimer")) {
            window.clearTimeout($('.section.work').data("scrollWorkTimer"));
        }
        $('.section.work').data("scrollWorkTimer", window.setTimeout(onScrollSectionWork(0.01), 10));
    });

    let switchLeft = false;
    $('.work-table-bg-wrapper .work-table-bg').each(function (index) {
        $(this).css('animation-duration', (15 + Math.ceil(Math.random() * 12)) +  "s");
        if (switchLeft) {
            $(this).css('animation-direction', 'reverse');
        }
        switchLeft = !switchLeft;
    });
}

var scrollWorkTimer = null;

function onScrollSectionWork(delay = 0.2) {
    var viewIndex = 0;
    $('.section.work .step').each (function (index) {
        var isVisible = $(this).isInHorViewport(0.65, true);
        if (isVisible && !$(this).hasClass("step-visible")) {
            $(this).css("transition-delay", (viewIndex * delay) + "s");
            $(this).addClass("step-visible");
            viewIndex++;
        } else if (!isVisible && $(this).hasClass("step-visible")) {
            $(this).removeClass("step-visible");
        }
    });

    $('.work-table-bg-wrapper .work-table-bg').css('animation-play-state', 'running');

    clearTimeout($.data($('.work-table-bg-wrapper'), 'workBgTimer'));
    $.data($('.work-table-bg-wrapper'), 'workBgTimer', setTimeout(function() {
        $('.work-table-bg-wrapper .work-table-bg').css('animation-play-state', 'paused');
    }, 2500));
}

function drawWorkEntryBezier(ele1, ele1Connector, ele1factor, ele2, ele2Connector, ele2factor, offset, stepSize) {
    var ele1Coords = getWorkEntryBezierCoords(ele1, ele1Connector, offset);
    var ele2Coords = getWorkEntryBezierCoords(ele2, ele2Connector, offset);
    
    let bezierCurve = new BezierCurve([
        ele1Coords,
        getWorkEntryBezierHelpCoords(ele1Coords, ele2Coords, ele1factor),
        getWorkEntryBezierHelpCoords(ele2Coords, ele1Coords, ele2factor),
        ele2Coords
    ]);

    const diffX = Math.max(ele1Coords.x, ele2Coords.x) - Math.min(ele1Coords.x, ele2Coords.x);
    const diffY = Math.max(ele1Coords.y, ele2Coords.y) - Math.min(ele1Coords.y, ele2Coords.y);

    bezierCurve.drawPointCount = Math.round((diffX / stepSize) + (diffY / stepSize));
    bezierCurve.calcDrawPoints();

    var connection = $('<div class="work-connection" data-from="' + ele1.data("way") + '" data-to="' + ele2.data("way") +'"></div>');
    $('.work-table').append(connection)
    for (var i=0; i<bezierCurve.drawingPoints.length;i++) {
        var p = bezierCurve.drawingPoints[i];
        connection.append($('<div class="d-none d-xl-block d-lg-block step" style="left:' + Math.round(p.x) + 'px;top:' + Math.round(p.y) + 'px"></div>'))
    }
}

function getWorkEntryBezierCoords(ele, connector, offset) {
    var calcOffset = ele.position();
    calcOffset.top += ele.parent().position().top;
    calcOffset.left +=  ele.parent().position().left;
        
    let y,x = 0;
    if (connector == 'left' || connector == 'right')
         y = calcOffset.top + (ele.height() / 2);
    else if (connector == 'top') {
        y = calcOffset.top - offset * 2;
    } else {
        y = calcOffset.top + ele.height() + offset;
    }
    
    if (connector == 'top' || connector == 'bottom')
        x = calcOffset.left + (ele.width() / 2);
    else if (connector == 'right') {
        x = calcOffset.left + ele.width() + offset;
    } else {
        x = calcOffset.left - offset * 2;
    }

    return new Point(x,y);
}

function getWorkEntryBezierHelpCoords(p1,p2, factor) {
    let factX = (Math.max(p1.x, p2.x) - Math.min(p1.x, p2.x)) * factor.x;
    let factY = (Math.max(p1.y, p2.y) - Math.min(p1.y, p2.y)) * factor.y;

    if (p1.x >= p2.x) 
        factX *= -1;
    
    if (p1.y >= p2.y) 
        factY *= -1;

    return new Point(p1.x + factX, p1.y + factY);
}
