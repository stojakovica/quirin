$(function() {
    /* navigation text */
    $('#navigationService li a.text').click(getContent);

    /* navigation filter */
    $('#navigationMain li a.filter').click(filterContent);

    var $containerMasonry = $('#containerMasonry');
    if($containerMasonry.length) {
        $('body').mCustomScrollbar({
            scrollInertia: 100
        });
    }
    $containerMasonry.imagesLoaded(function(){
        $containerMasonry.masonry({
            itemSelector: '.cell',
            isAnimated: true
        });
        $(window).trigger("resize");
    });
    $(window).resize(function() {
        if($(window).width() <= 845) {
            $containerMasonry.masonry('destroy')
        }
        setHeightImgBig();
    });

    //var $container = $('.container');
    //$container.imagesLoaded(function() {
    //    $container.animate({
    //        "opacity": "1"
    //    });
    //});

    /* Detail - Change image */
    $('.leftArrow .arrowContent img').click(function() {
        changeImgDetail("", "left");
        changeImgDetailDescription("", "left");
    });
    $('.rightArrow .arrowContent img').click(function() {
        changeImgDetail("", "right");
        changeImgDetailDescription("", "right");
    });
    $('.imgNav .dot').click(function() {
        var filename = $(this).data("filename");
        changeImgDetail(filename, 0);
        changeImgDetailDescription(filename, 0);
    });

    /* Navigation Responsive */
    $('#navigationMainResp .head').click(toggleNavigationResp);
});

function setHeightImgBig() {
    var $imgBig = $('.imgBig');
    var $rightArrow = $('.rightArrow');
    var $leftArrow = $('.leftArrow');
    var height = $(window).height();
    var $containerDetail = $('.containerDetail');
    var $description = $containerDetail.children('.description');
    var $imgNav = $containerDetail.children('.imgNav');

    if($(window).width() <= 845) {
        height-= $('#header').outerHeight();
    }
    $rightArrow.height(height);
    $leftArrow.height(height);
    height-= parseInt($containerDetail.css('padding-top'));
    height-= parseInt($containerDetail.css('padding-bottom'));
    height-= 10;

    if($description.css('position') == 'static') {
        height-= $description.outerHeight();
        height-= parseInt($description.css('padding-top'));
        height-= parseInt($description.css('padding-bottom'));
    }
    if($imgNav.css('position') == 'static') {
        height-= $imgNav.outerHeight();
        height-= parseInt($imgNav.css('padding-top'));
        height-= parseInt($imgNav.css('padding-bottom'));
    }
    $imgBig.height(height);
}

function toggleNavigationResp() {
    $('#navigationMainResp .list').animate({
        height : "toggle"
    }, 500);
}

function changeImgDetail(filename, direction) {
    $activeImg = $('.imgBig .active');
    if(filename != "") {
        $nextImg = $('#'+filename);
    }
    else {
        switch (direction) {
            case "left":
                $nextImg = $activeImg.prev();
                if($nextImg.length == 0) {
                    $nextImg = $('.imgBig img').last();
                }
                break;
            case "right":
                $nextImg = $activeImg.next();
                if($nextImg.length == 0) {
                    $nextImg = $('.imgBig img').first();
                }
                break;
        }
    }

    $activeImg.fadeOut( "slow", function() {
        $(this).removeClass('active');
        $nextImg.fadeIn("slow");
        $nextImg.addClass('active');
        setActiveImgNavDot();
    });
}

function changeImgDetailDescription(filename, direction) {
    $activeDesc = $('.description .active');
    if(filename != "") {
        $nextDesc = $('#desc_'+filename);
    }
    else {
        switch (direction) {
            case "left":
                $nextDesc = $activeDesc.prev('.description .descriptionContent');
                if($nextDesc.length == 0) {
                    $nextDesc = $('.description .descriptionContent').last();
                }
                break;
            case "right":
                $nextDesc = $activeDesc.next('.description .descriptionContent');
                if($nextDesc.length == 0) {
                    $nextDesc = $('.description .descriptionContent').first();
                }
                break;
        }
    }

    $activeDesc.fadeOut( "slow", function() {
        $(this).removeClass('active');
        $nextDesc.fadeIn("slow");
        $nextDesc.addClass('active');
    });
}

function setActiveImgNavDot() {
    var activeImg = $('.imgBig .active').attr('id');

    $('.imgNav .dot').removeClass('active');
    $('.imgNav .'+activeImg).addClass('active');
}

function closeTextContainer() {
	$('#textContentContainer').animate({
		height: 'toggle'
	}, 300, function() {
		$('#textContentContainer').empty();
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