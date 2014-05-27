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
        initFreewallContainerTopSpace();
        $(window).resize(function() {
            wall.fitWidth();
            setTimeout(initFreewallContainerTopSpace, 100);
        });

        /* navigation filter */
        $('#navigationMain li a.filter').click(function() {
            $('#navigationMain li a').parent('li').removeClass('active');
            $(this).parent('li').addClass('active');
            wall.filter($(this).data('filter-class'));
            initFreewallContainerTopSpace();
            return false;
        });
    });

    /* navigation text */
    $('#navigationMain li a.text').click(getContent);

    /* freewallcontainer */
    $('#freewallContainer').niceScroll();
    $('#freewallContainer').hover(fadeOutCells, fadeInCells);

    /* freewallcontainer cells */
    $('#freewallContainer .cell').hover(cellOn, cellOut);

});

function fadeOutCells() {
	$('#freewallContainer .cell').animate({
		'opacity': '0.4'
	}, 100);
}

function fadeInCells() {
	$('#freewallContainer .cell').animate({
		'opacity': '1'
	}, 100);
}

function cellOn() {
	$(this).animate({
		'opacity': '1'
	}, 100);
}

function cellOut() {
	$(this).animate({
		'opacity': '0.4'
	}, 100);
}

function initFreewallContainerTopSpace() {
	var headerHeight = $('#header').outerHeight();
	var cont = $('#freewallContainer');
	var contHeight = $(window).height() - headerHeight;
	cont.animate({
		'margin-top' : headerHeight+'px'
	});
	cont.height(contHeight);
}

function getContent() {
	var id = $(this).data('id');

    $.ajax({
        type: "GET",
        async: false,
        url: "index.php?article_id=9",
        data: "getArticleData=1&artId="+id,
        success: function(data){
        	$('#textContentContainer').empty();
        	if($('#textContentContainer').hasClass('class'+id)) {
        		$('#textContentContainer').removeClass();
        	} else {
        		$('#textContentContainer').hide();
        		$('#textContentContainer').html(data);
        		$('#textContentContainer').removeClass();
        		$('#textContentContainer').addClass('class'+id);
        	}
            $('#textContentContainer').animate({
            	height: 'toggle'
            }, 100, function() {
            	initFreewallContainerTopSpace();
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