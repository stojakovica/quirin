<?php
header('Content-Type: text/html; charset=utf-8');

// global vars
$path = explode("|", $this->getValue("path") . $this->getValue("article_id") . "|");
$path1 = $path[1];
$path2 = $path[2];
$path3 = $path[3];

$ssa = OOArticle::getSiteStartArticle();
$article = OOArticle::getArticleById($this->getValue("article_id"));
$isSSA = $ssa->getId() == $article->getId();

// add less support
$libDir = $REX['HTDOCS_PATH'] . "lib";
require $libDir . "/vendor/leafo/lessphp/lessc.inc.php";
$less = new lessc();
$less->checkedCompile($libDir . "/quirin/css/main.less", $libDir . "/quirin/css/main.css");

// prepare content images
foreach (OOCategory::getRootCategories(true) as $lev1) {
    $filterClass = 'filter'.$lev1->getId();
    $mediaFiles = $lev1->getValue('art_freewall_images');
    $mediaFiles = array_filter(explode(',', $mediaFiles));

    $i = 0;
    foreach($mediaFiles as $mf) {
        if($i > 5) continue;
        $medias[] = array(
                "filterClass" => $filterClass,
                "filename" => $mf,
        );
        $i++;
    }
}
shuffle($medias);

$columnCount = rand(3, 5);
$columnWidth = 100/$columnCount;
$columnMargin = (($columnCount-1)/$columnCount)/2;
$columnWidth = $columnWidth - $columnMargin;

$columnWidthTemp = 1/$columnCount;
// for($i=1; $i<1; $i++) {
	$columnWidthTemp = $columnWidthTemp/$columnCount;
// }
$columnWidth+= $columnWidthTemp;

$modulo = ceil(count($medias)/$columnCount);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <base href="/snow/" />
    <title>Quirin Leppert - <?php echo $article->getName(); ?></title>
    <link rel="shortcut icon" href="files/favicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="lib/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/vendor/slimbox/css/slimbox2.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $libDir."/quirin/css/main.css"?>" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script src="lib/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $libDir."/quirin/js/masonry.pkgd.min.js"; ?>"></script>
    <script src="<?php echo $libDir."/quirin/js/imagesloaded.pkgd.min.js"; ?>"></script>
    <script src="<?php echo $libDir."/quirin/js/main.js"; ?>"></script>
    <style type="text/css" media="screen">
    	.column {
    		width: <?php echo $columnWidth; ?>%;
    		margin-right: <?php echo $columnMargin; ?>%;
    	}

    	.column:nth-child(<?php echo $columnCount; ?>n) {
    		margin-right: 0;
    	}
	</style>
</head>
<body>
    <div id="header">
        <div id="logo">
            <a href="<?php echo $ssa->getUrl(); ?>">
                QUIRIN LEPPERT
            </a>
        </div>

        <ul id="navigationMain" class="clearfix">
        	<li><a href="#" class="filter active" data-filter-class="all">All</a></li>
	        <?php
	        foreach (OOCategory::getRootCategories(true) as $lev1) {
	            $class = "";
	            if ($lev1->getId() == $path1) $class = "active";
	            ?>
	            <li class="<?php echo $class; ?>" ><a href="#" class="filter" data-filter-class="filter<?php echo $lev1->getId(); ?>"><?php echo $lev1->getName(); ?></a></li>
	            <?php
	        }
	        foreach (OOCategory::getCategoryById(5)->getChildren(true) as $lev1) {
	            $class = "";
	            if ($lev1->getId() == $path1) $class = "active";
	            ?>
	            <li class="<?php echo $class; ?>" ><a href="#" class="text" data-id="<?php echo $lev1->getId(); ?>"><?php echo $lev1->getName(); ?></a></li>
	            <?php
	        }
	        ?>
        </ul>

	    <div id="textContentContainer">
	    </div>
    </div>
    <div id="container">
    	<div class="column">
        <?php
        $i = 1;
        foreach($medias as $mediaFile) {
			if($i % $modulo == 0) {
				echo '</div><div class="column">';
			}
			$i++;
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
            	<img src="index.php?rex_img_type=freewallImage&rex_img_file=<?php echo $media->getFileName(); ?>" />
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
    </div>
</body>
</html>