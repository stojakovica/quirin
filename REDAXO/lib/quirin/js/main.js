$(function() {
    /* navigation text */
    $('#navigationService li a.text').click(getContent);

    /* navigation filter */
    $('#navigationMain li a.filter').click(filterContent);

    var $container = $('#containerMasonry');
    if($container.length) {
        $('body').mCustomScrollbar({
            scrollInertia: 100
        });
    }
    $container.imagesLoaded(function(){
        $container.masonry({
            itemSelector: '.cell',
            isAnimated: true,
            isFitWidth: true
        });
    });

    var options = {
        $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$,
            $ChanceToShow: 2
        }
    };
    var jssor_slider1 = new $JssorSlider$('slider1_container', options);
});

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

function closeTextContainer() {
	$('#textContentContainer').animate({
		height: 'toggle'
	}, 300, function() {
		$('#textContentContainer').empty();
	});
}

function closeSlideshow() {
	$('#slideshowWrapper').fadeOut(250, function() {
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

function getMediaContent(mediaId, nextId, prevId) {
	var id = mediaId;

	$.ajax({
		type: "GET",
		async: false,
		url: "index.php?article_id=9",
		data: "getMediaData=1&artId="+id+"&nextId="+nextId+"&prevId="+prevId,
		success: function(data){
			$('body').append(data);
			$('#slideshowWrapper').fadeIn(300);
		    $('.closeSlideshow').click(closeSlideshow);
		    $('.imgSmall img').click(changeImgPrev);
		    $('.arrowContent img').click(changeMediaContent);

		    $('#slideshowWrapper').imagesLoaded( function() {
				$('#slideshowWrapper img').animate({
					'opacity': '1'
				}, 250);
			});
		}
	});

	return false;
}

function changeMediaContent() {
	var id = $(this).data('media-id');
	var nextId = 0;
	var prevId = 0;

	$('.cell').each(function() {
		if($(this).data('media-id') == id) {
			nextId = $(this).data('next-media');
			prevId = $(this).data('prev-media');
		}
	});

	$('#slideshowWrapper').fadeOut(250, function() {
		$('#slideshowWrapper').remove();
		getMediaContent(id, nextId, prevId);
	});
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