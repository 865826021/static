<?php
$id=$_GET['id'];
$html_filename='news_id'.$id.'.html';
echo file_get_contents($html_filename);