$(function() {
    /* freewall */
    $(".freewallContainer").each(function() {
        var id = $(this).attr('id');
        wall = new freewall("#"+id);
        wall.reset({
            selector: '.cell',
            animate: true,
            cellW: 50,
            cellH: 20,
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
    $('#container').lionbars();
    $('#freewallContainer').hover(fadeOutCells, fadeInCells);

    /* freewallcontainer cells */
    $('#freewallContainer .cell').hover(cellOn, cellOut);
    $('#freewallContainer .cell').click(getMediaContent);

});

function changeImgPrev() {
	var img = $(this).data('filename');
	var imgBig = $('.par .imgBig');
	imgBig.children('img').fadeOut('slow', function() {
		imgBig.html('<img style="display:none;" src="index.php?rex_img_type=previewBig&rex_img_file='+img+'" />');
		imgBig.children('img').fadeIn('slow');
	});
}

function fadeOutCells() {
	//	No Handling
}

function fadeInCells() {
	$('#freewallContainer .cell').animate({
		'opacity': '1'
	}, 100);
}

function cellOn() {
	var id = $(this).data('media-id');
	$('#freewallContainer .cell').each(function() {
		if($(this).data('media-id') != id) {
			$(this).animate({
				'opacity': '0.4'
			}, 100);
		}
		else {
			$(this).animate({
				'opacity': '1'
			}, 100);
		}
	})
}

function cellOut() {
	//	No Handling
}

function initFreewallContainerTopSpace() {
	var headerHeight = $('#header').outerHeight();
	var cont = $('#container');
	var contHeight = $(window).height() - headerHeight;
	if(contHeight < 400) {
		$('body').css('overflow-y', 'scroll');
		$('#header').css('position', 'relative');
		$('#container').css('position', 'relative');
		contHeight = $('.freewallContainer').height();
	} else {
		$('body').css('overflow-y', 'hidden');
		$('#header').css('position', 'fixed');
		$('#container').css('position', 'fixed');
		cont.animate({
			'margin-top' : headerHeight+'px'
		});
	}
	$('#lb-wrap-0-container').height(contHeight);
	cont.height(contHeight);
}

function closeTextContainer() {
	$('#textContentContainer').children('.par').fadeOut(200, function() {
		$('#textContentContainer').empty();
		$('#textContentContainer').animate({
			height: 'toggle'
		}, 250, function() {
			initFreewallContainerTopSpace();
		});
	});

}

function changeTextContainer(data, id) {
	$('#textContentContainer').children('.par').fadeOut(250, function() {
		$('#textContentContainer').empty();
		$('#textContentContainer').html(data);
		$('#textContentContainer').removeClass();
		$('#textContentContainer').addClass('class'+id);
		$('#textContentContainer').children('.par').fadeIn(250, function() {
			$('#textContentContainer .par .close').click(closeTextContainer);
			$('.par .imgSmall img').click(changeImgPrev);
		});
	});
}

function fillTextContainer(data, id) {
	$('#textContentContainer').empty();
	$('#textContentContainer').html(data);
	$('#textContentContainer').removeClass();
	$('#textContentContainer').addClass('class'+id);
	$('#textContentContainer').animate({
		height: 'toggle'
	}, 250, function() {
		initFreewallContainerTopSpace();
	});
}

function getContent() {
	var id = $(this).data('id');

    $.ajax({
        type: "GET",
        async: false,
        url: "index.php?article_id=9",
        data: "getArticleData=1&artId="+id,
        success: function(data){
        	if($('#textContentContainer').children('.par').length > 0) {
				changeTextContainer(data, id);
			}
			else {
				fillTextContainer(data, id);
			}
		    $('#textContentContainer .par .close').click(closeTextContainer);
        }
    });

    return false;
}

function getMediaContent() {
	var id = $(this).data('media-id');

	$.ajax({
		type: "GET",
		async: false,
		url: "index.php?article_id=9",
		data: "getMediaData=1&artId="+id,
		success: function(data){
			if($('#textContentContainer').children('.par').length > 0) {
				changeTextContainer(data, id);
			}
			else {
				fillTextContainer(data, id);
			}
		    $('#textContentContainer .par .close').click(closeTextContainer);
		    $('.par .imgSmall img').click(changeImgPrev);
		}
	});

	return false;
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