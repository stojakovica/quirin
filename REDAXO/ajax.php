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

    $result = '<div class="par" style="height: 475px;">';
    $result .= '<div class="imgBig">';
    $result .= '<img src="index.php?rex_img_type=previewBig&rex_img_file='.$media->getFilename().'" />';
    $result .= '</div>';
    $result .= '<div class="imgSmall">';
    $result .= '<img data-filename="'.$media->getFilename().'" src="index.php?rex_img_type=previewSmall&rex_img_file='.$media->getFilename().'" />';
    $i=1;
    foreach($serie as $img) {
    	if($i%4 == 0) {
    		$result .= '</div><div class="imgSmall">';
    	}
	    $result .= '<img data-filename="'.$img.'" src="index.php?rex_img_type=previewSmall&rex_img_file='.$img.'" />';
    	$i++;
    }
    $result .= '</div>';
    $result .= '<div class="close">';
    $result .= 'X';
    $result .= '</div>';
    $result .= '</div>';

    echo $result;
    exit;
}
?>