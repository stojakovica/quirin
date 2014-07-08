<?php
ob_clean();
header('Content-Type: text/html; charset=utf-8');
if($_GET['artId'] != "") $id = $_GET['artId'];

if ($_GET['getArticleData'] == 1) {
    $result = '<div class="par" style="width:1170px;">';
    $article = new article($id);
    $result .= $article->getArticle(1);
    $result .= '<div class="close">';
    $result .= 'X';
    $result .= '</div>';
    $result .= '</div>';
    echo $result;
    exit;
}

if ($_GET['getMediaData'] == 1) {
    $media = OOMedia::getMediaById($id);
    $serie = array_filter(explode(',', $media->getValue('med_series')));

    $result = '<div id="slideshowWrapper">';
    $result .= 	'<div class="rightArrow">';
    $result .= 		'<div class="arrowContent" style="display:none">';
    $result .= 			'<img src="files/pfeil_1.png" />';
    $result .= 		'</div>';
    $result .= 	'</div>';
    $result .= 	'<div class="leftArrow">';
    $result .= 		'<div class="arrowContent" style="display:none">';
    $result .= 			'<img src="files/pfeil_2.png" />';
    $result .= 		'</div>';
    $result .= 	'</div>';
    $result .= 	'<div class="closeSlideshow">';
    $result .= 	'X';
    $result .= 	'</div>';
    $result .= 	'<div class="description">';
				    $textile = htmlspecialchars_decode($media->getDescription());
				    $textile = str_replace("<br />","",$textile);
				    $textile = rex_a79_textile($textile);
				    $textile = str_replace("###","&#x20;",$textile);
    $result .= 		$textile;
    $result .= '</div>';
    $result .= 	'<div class="imgBig">';
    $result .= 		'<img src="index.php?rex_img_type=previewBig&rex_img_file='.$media->getFilename().'" />';
    $result .= 	'</div>';
    $result .= 	'<div class="imgSmall">';
    foreach($serie as $img) {
	    $result .= 		'<img data-filename="'.$img.'" src="index.php?rex_img_type=previewSmall&rex_img_file='.$img.'" />';
    }
    $result .= 	'</div>';
    $result .= '</div>';

    echo $result;
    exit;
}
?>