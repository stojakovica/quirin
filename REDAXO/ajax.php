<?php
ob_clean();
header('Content-Type: text/html; charset=utf-8');
if($_GET['artId'] != "") $id = $_GET['artId'];

if ($_GET['getArticleData'] == 1) {
    $result = "<br/><br/>";
    $article = new article($id);
    $result .= $article->getArticle(1);
    echo $result;
    exit;
}

// if ($_GET['getGallery'] == 1) {
//     $previewText = htmlspecialchars_decode($_GET['previewText']);
//     $previewText = str_replace("<br />","",$previewText);
//     $previewText = rex_a79_textile($previewText);
//     $previewText = str_replace("###","&#x20;",$previewText);

//     $previewImg = '<img src="'.$REX['HTDOCS_PATH'].'index.php?rex_img_type=galleryBoxPreview&rex_img_file='.$_GET['previewImg'].'" /><br/><br/>';

//     $images = explode(',', $_GET['galleryList']);

//     $galleryImgBig = '<div class="galleryBoxImgBig"><img src="'.$REX['HTDOCS_PATH'].'index.php?rex_img_type=galleryBoxImgBig&rex_img_file='.$images[0].'" /></div>';
//     $imagesHtml = '';
//     foreach ($images as $img) {
//         $imagesHtml .= '<img class="galleryBox" data-imgname="'.$img.'" src="'.$REX['HTDOCS_PATH'].'index.php?rex_img_type=galleryBoxListSmall&rex_img_file='.$img.'" />';
//     }
//     $galleryList = '<div class="galleryBoxList">'.$imagesHtml.'</div>';

//     $html = '<div class="previewBox">'.$previewImg.'<div>'.$previewText.'</div></div><div class="galleryShowBox">'.$galleryImgBig.$galleryList.'</div>';
//     echo $html;
//     exit;
// }
?>