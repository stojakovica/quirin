$(function() {
	if($('#container').length > 0) {
		$('#container').imagesLoaded( function() {
			$('#container').animate({
				'opacity': '1'
			}, 250);
		});
	}

	setCellMargin();
	$(window).resize(setCellMargin);

    /* navigation text */
    $('#navigationService li a.text').click(getContent);

    /* navigation filter */
    $('#navigationMain li a.filter').click(filterContent);

    /* container */
    $('#container').hover(fadeOutCells, fadeInCells);

    /* container cells */
    $('#container .cell').hover(cellOn, cellOut);
    $('#container .cell').click(getMediaContent);

});

function setCellMargin() {
	var columnMargin = $('.column').first().css('margin-right');
	$('.cell').css('margin-bottom', columnMargin);
}

function changeImgPrev() {
	var img = $(this).data('filename');
	var imgBig = $('.imgBig');
	imgBig.children('img').fadeOut('slow', function() {
		imgBig.html('<img src="index.php?rex_img_type=previewBig&rex_img_file='+img+'" />');
		imgBig.imagesLoaded( function() {
			imgBig.children('img').animate({
				'opacity': '1'
			});
		});
	});
}

function fadeOutCells() {
	//	No Handling
}

function fadeInCells() {
	$('#container .cell').animate({
		'opacity': '1'
	}, 100);
}

function cellOn() {
	var id = $(this).data('media-id');
	$('#container .cell').each(function() {
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

function closeTextContainer() {
	$('#textContentContainer').animate({
		height: 'toggle'
	}, 300, function() {
		$('#textContentContainer').empty();
	});
}

function closeSlideshow() {
	$('#slideshowWrapper').fadeOut('slow', function() {
		$('#slideshowWrapper').remove();
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
			$('body').append(data);
			$('#slideshowWrapper').fadeIn('slow');
		    $('.closeSlideshow').click(closeSlideshow);
		    $('.imgSmall img').click(changeImgPrev);

		    $('#slideshowWrapper').imagesLoaded( function() {
				$('#slideshowWrapper img').animate({
					'opacity': '1'
				});
			});
		}
	});

	return false;
}

function filterContent() {
	var link = $(this);
    var name = $(this).attr('data-filter-class');
    $('#header #navigationMain li a').removeClass('active');
    $(this).addClass('active');

    $.when( $('.cell').fadeOut(250) ).done(function() {
    	window.location = link.attr('href');
    	return true;
    });


    return false;
}