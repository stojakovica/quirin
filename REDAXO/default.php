REX_TEMPLATE[5]
<div class="container" id="containerMasonry">
<?php
function cmp($a, $b) {
	if ($a['createDate'] == $b['createDate']) {
		return 0;
	}
	return ($a['createDate'] > $b['createDate']) ? -1 : 1;
}

$article = OOArticle::getArticleById($this->getValue("article_id"));
$isSSA = $ssa->getId() == $article->getId();

// prepare content images
$medias = array();
if($isSSA) {
	foreach (OOCategory::getRootCategories(true) as $lev1) {
	    $filterClass = 'filter'.$lev1->getId();
	    $mediaFiles = $lev1->getValue('art_freewall_images');
	    $mediaFiles = array_filter(explode(',', $mediaFiles));

	    $i = 0;
	    foreach($mediaFiles as $mf) {
	    	$media = OOMedia::getMediaByFilename($mf);
	        $medias[] = array(
	                "id" => $media->getId(),
	                "filterClass" => $filterClass,
	                "filename" => $mf,
	                "createDate" => $media->getCreateDate(),
	        );
	        $i++;
	    }
	}
}
else {
    $filterClass = 'filter'.$article->getId();
    $mediaFiles = $article->getValue('art_freewall_images');
    $mediaFiles = array_filter(explode(',', $mediaFiles));

    $i = 0;
    foreach($mediaFiles as $mf) {
    	$media = OOMedia::getMediaByFilename($mf);
        $medias[] = array(
                "id" => $media->getId(),
                "filterClass" => $filterClass,
                "filename" => $mf,
                "createDate" => $media->getCreateDate(),
        );
        $i++;
    }
}

usort($medias, "cmp");

foreach($medias as $k=>$mediaFile) {
    $filterClass = $mediaFile['filterClass'];
    $media = OOMedia::getMediaByFileName($mediaFile['filename']);
    if (!$media) {
        continue;
    }

    // Title
    $title = $media->getTitle();

    // Description
    $mediaDesc = htmlspecialchars_decode($media->getDescription());
    $mediaDesc = str_replace("<br />","",$mediaDesc);
    $mediaDesc = OOAddon::isAvailable('textile')?rex_a79_textile($mediaDesc):$mediaDesc;
    $mediaDesc = str_replace("###","&#x20;",$mediaDesc);

    // related series images
    $relatedImages = $media->getValue('med_series');
    $relatedImages = array_filter(explode(',', $relatedImages));
    ?>
    <div class="cell <?php echo $filterClass; ?>" data-media-id="<?php echo $media->getId(); ?>">
        <a href="<?php echo rex_getUrl(10, 0, array("mId"=>$media->getId(), "cat"=>$filterClass))?>">
            <img src="index.php?rex_img_type=freewallImage&rex_img_file=<?php echo $media->getFileName(); ?>" />
        </a>
        <div class="descriptionWrapper">
            <div class="description">
                <h2><?php echo $title; ?></h2>
                <?php echo $mediaDesc; ?>
            </div>
        </div>
    </div>
    <?php
}
?>
</div>
REX_TEMPLATE[6]