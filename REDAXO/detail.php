REX_TEMPLATE[5]
<div class="container containerDetail">
    <?php
    $media = OOMedia::getMediaById($_GET['mId']);
    if(!$media) {
        header("Location: /");
        exit;
    }

    $imgBig = $media->getFilename();
    $serie = array_filter(explode(',', $media->getValue('med_series')));
    $textile = htmlspecialchars_decode($media->getDescription());
    $textile = str_replace("<br />","",$textile);
    $textile = rex_a79_textile($textile);
    $textile = str_replace("###","&#x20;",$textile);
    ?>

    <?php if($serie) { ?>
        <div class="rightArrow">
            <div class="arrowContent">
                <img src="files/pfeil_1.png" />
            </div>
        </div>
        <div class="leftArrow">
            <div class="arrowContent">
                <img src="files/pfeil_2.png" />
            </div>
        </div>
    <?php } ?>

    <?php if($textile) { ?>
        <div class="description">
            <?php
            $imgArr = explode('.', $imgBig);
            $imgBigId = $imgArr[0];
            ?>
            <div id="desc_<?php echo $imgBigId; ?>" class="descriptionContent active">
                <?php echo $textile; ?>
            </div>

            <?php foreach($serie as $k=>$img) {
                $textileSerie = "";
                $mediaSerie = OOMedia::getMediaByFileName($img);
                if($mediaSerie->getDescription()) {
                    $textileSerie = htmlspecialchars_decode($mediaSerie->getDescription());
                    $textileSerie = str_replace("<br />","",$textileSerie);
                    $textileSerie = rex_a79_textile($textileSerie);
                    $textileSerie = str_replace("###","&#x20;",$textileSerie);
                }
                $descId = "desc_media".$k;
                ?>
                <div id="<?php echo $descId; ?>" class="descriptionContent">
                    <?php echo $textileSerie; ?>
                </div>
            <?php } ?>

            <div class="close hidden-lg" onclick="history.back();">
                X
            </div>
        </div>
    <?php } ?>

    <div class="imgBig">
        <div class="close visible-lg" onclick="history.back();">
            X
        </div>

        <?php
        $imgArr = explode('.', $imgBig);
        $imgBigId = $imgArr[0];
        ?>
        <img id="<?php echo $imgBigId; ?>" class="active" src="index.php?rex_img_type=previewBig&rex_img_file=<?php echo $imgBig; ?>" />

        <?php
        foreach($serie as $k=>$img) {
            $imgId = "media".$k;
            ?>
            <img id="<?php echo $imgId; ?>" src="index.php?rex_img_type=previewBig&rex_img_file=<?php echo $img; ?>" />
        <?php
        } ?>
    </div>

    <div class="imgNav">
        <div class="dot active <?php echo $imgBigId; ?>" data-filename="<?php echo $imgBigId; ?>"></div>

        <?php foreach($serie as $k=>$img) {
            $imgId = "media".$k;
            ?>
            <div class="dot <?php echo $imgId; ?>" data-filename="<?php echo $imgId; ?>"></div>
        <?php } ?>
    </div>
</div>
REX_TEMPLATE[6]