document.observe('dom:loaded', function() {
    $$('.relative-center').each(function (item, index) {
        var parentLi = $(item).up('li');
        var parentLiWidth = parentLi.getWidth();
        var itemWidth = $(item).getWidth();
        var requiredRightMargin = ((itemWidth - parentLiWidth) / 2) * -1;
        $(item).setStyle({
            'margin-left': requiredRightMargin + 'px'
        });
    });

    $$('.hang-left').each(function (item,index) {
        var parentLi = $(item).up('li');
        var parentLiWidth = parentLi.getWidth();
        var itemWidth = $(item).getWidth();
        var requiredRightMargin = (itemWidth - parentLiWidth) * -1;
        $(item).setStyle({
            'margin-left': requiredRightMargin + 'px'
        });
    });
});