$(function() {
    /* freewall */
    $(".freewallContainer").each(function() {
        var id = $(this).attr('id');
        wall = new freewall("#"+id);
        wall.reset({
            selector: '.cell',
            animate: true,
            cellW: 20,
            cellH: 100,
            gutterX: 5,
            gutterY: 5,
            onResize: function() {
                wall.fitWidth();
            }
        });
        wall.fitWidth();
        $(window).resize(function() {
            wall.fitWidth();
        });

        wall.unFilter();

        /* navigation filter */
        $('#navigationMain li a.filter').click(function() {
            $('#navigationMain li a').parent('li').removeClass('active');
            $(this).parent('li').addClass('active');
            wall.filter($(this).data('filter-class'));
            return false;
        });
    });

    /* navigation text */
    $('#navigationMain li a.text').click(getContent);

});

function getContent() {
    $.ajax({
        type: "GET",
        async: false,
        url: "index.php?article_id=9",
        data: "getArticleData=1&artId="+$(this).data('artId'),
        success: function(data){
            $('#textContentContainer').empty();
            $('#textContentContainer').html(data);
            $('#textContentContainer').animate({
            	height: 'toggle'
            });
        }
    });
}

function filterContent(name) {
    if(!name) {
        var name = $(this).attr('data-filter-class');
    }

    $('.cell').each(function() {
        if(!$(this).hasClass(name)) {
            $(this).hide('slow');
        }
        else {
            $(this).show('slow');
        }
    });
}