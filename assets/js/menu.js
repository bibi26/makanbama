// jQuery material design tabs
$.fn.mdtabs = function(options){
    var defaults = {
        height: 5,
        color: "#FD0",
        duration: 200,
        onClick: null,
        onIndicaterMoved: null,
    }
    $.extend(defaults, options);

    var tabBox = $(this);
    var tabItems = tabBox.children();

    tabBox.find(".indicater").remove();
    var indicater = $("<span class='indicater'></span>").css({
        "position": "absolute",
        "bottom": "0px",
        "height": defaults.height + "px",
        "background-color": defaults.color,
        "left": 20,
        "right": "100%"
    }).appendTo(tabBox);

    function moveIndicater(item, click, moved){
        var left = item ? item.position().left : 0;
        var right = item ? (tabBox.innerWidth() - item.outerWidth() - left) : tabBox.innerWidth();

        if(click){
            indicater.animate({
                left: left+20,
                right: right-20
            }, defaults.duration, function(){
                if(moved)
                    moved.call(item);
            });
        }
        else{
            indicater.css({
                left: left+20,
                right: right-20
            });
        }
    }

    var selectedItem = tabBox.find(">a.selected").length ? tabBox.find(">a.selected") : null;
    moveIndicater(selectedItem, false, defaults.onIndicaterMoved);

    tabItems.on("click", function(){

        moveIndicater($(this), true, defaults.onIndicaterMoved);
    })
}