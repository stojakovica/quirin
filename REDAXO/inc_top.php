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

if($_GET['cat']) {
    $activeFilterCat = $_GET['cat'];
    $activeFilterCat = substr($activeFilterCat, 6);
}
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
    <link href="<?php echo $libDir."/quirin/css/jquery.mCustomScrollbar.css"; ?>"" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $libDir."/quirin/css/main.css"?>" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="lib/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $libDir."/quirin/js/jquery.masonry.min.js"; ?>"></script>
    <script src="<?php echo $libDir."/quirin/js/imagesloaded.pkgd.min.js"; ?>"></script>
    <script src="<?php echo $libDir."/quirin/js/jquery.mCustomScrollbar.js"; ?>"></script>
    <script src="<?php echo $libDir."/quirin/js/main.js"; ?>"></script>
    <link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Serif+Pro' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="header">
    <div id="logo">
        <a href="<?php echo $ssa->getUrl(); ?>">
            QUIRIN LEPPERT
        </a>
    </div>

    <ul id="navigationMain" class="clearfix">
        <?php
        $class = "";
        if($isSSA) {
            $class = "active";
        }
        ?>
        <li><a href="<?php $ssa->getUrl(); ?>" class="filter <?php echo $class; ?>" data-filter-class="all">All</a></li>
        <?php
        foreach (OOCategory::getRootCategories(true) as $lev1) {
            $class = "";
            if ($lev1->getId() == $path1 || $lev1->getId() == $activeFilterCat) $class = "active";
            ?>
            <li><a href="<?php echo rex_getUrl($lev1->getId(), 0); ?>" class="filter <?php echo $class; ?>" data-filter-class="filter<?php echo $lev1->getId(); ?>"><?php echo $lev1->getName(); ?></a></li>
        <?php
        }
        ?>
    </ul>

    <ul id="navigationService" class="clearfix">
        <?php
        foreach (OOCategory::getCategoryById(5)->getChildren(true) as $lev1) {
            $class = "";
            if ($lev1->getId() == $path1) $class = "active";
            ?>
            <li class="<?php echo $class; ?>" ><a href="#" class="text" data-id="<?php echo $lev1->getId(); ?>"><?php echo $lev1->getName(); ?></a></li>
        <?php
        }
        ?>
    </ul>

    <div id="navigationMainResp">
        <div class="logo">
            <a href="<?php echo $ssa->getUrl(); ?>">
                QUIRIN LEPPERT
            </a>
        </div>

        <div class="headWrapper">
            <div class="head">
                <div class="icon-balken"></div>
                <div class="icon-balken"></div>
                <div class="icon-balken"></div>
            </div>
        </div>
        <div class="list">
            <ul id="navigationResponsive">
                <?php
                $class = "";
                if($isSSA) {
                    $class = "active";
                }
                /* Navigation Main */
                ?>
                <li><a href="<?php $ssa->getUrl(); ?>" class="<?php echo $class; ?>" data-filter-class="all">All</a></li>
                <?php
                foreach (OOCategory::getRootCategories(true) as $lev1) {
                    $class = "";
                    if ($lev1->getId() == $path1 || $lev1->getId() == $activeFilterCat) $class = "active";
                    ?>
                    <li><a href="<?php echo rex_getUrl($lev1->getId()); ?>" class="<?php echo $class; ?>"><?php echo $lev1->getName(); ?></a></li>
                <?php
                }

                /* Navigation Service */
                foreach (OOCategory::getCategoryById(5)->getChildren(true) as $lev1) {
                    $class = "";
                    if ($lev1->getId() == $path1) $class = "active";
                    ?>
                    <li><a href="<?php echo rex_getUrl($lev1->getId()); ?>" class="<?php echo $class; ?>"><?php echo $lev1->getName(); ?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <div id="textContentContainer" class="hidden-xs">
    </div>
</div>
