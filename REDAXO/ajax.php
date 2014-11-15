<?php
ob_clean();
header('Content-Type: text/html; charset=utf-8');
if($_GET['artId'] != "") $id = $_GET['artId'];
if($_GET['nextId'] != "") $nextId = $_GET['nextId'];
if($_GET['prevId'] != "") $prevId = $_GET['prevId'];

if ($_GET['getArticleData'] == 1) {
    $result = '<div class="container par">';
    $article = new article($id);
    $result .= $article->getArticle(1);
    $result .= '<div class="close">';
    $result .= 'X';
    $result .= '</div>';
    $result .= '</div>';
    echo $result;
    exit;
}
?>