<?php
$id=$_GET['id'];

$html_filename="news_id".$id.".html";

//这里我们可以判断该新闻对应的html文件是否存在了
//这里还有一个问题.如何保持html页面和数据库信息的同步问题
//1. 在更新时，同时修改->这里涉及到模板替换
//2.如果对及时性要求不高，通常可以这样处理 30s
//3.这样还有一个问题，就是我们的网页地址，仍然不是静态网址,-》这里涉及到伪静态
//4.还有就是静态页面和数据库的及时同步问题?->涉及到真静态的模板替换
if(file_exists($html_filename)&&time()-filemtime($html_filename)<30){
    //如果该静态html页面存在我们就直接输出.
    echo file_get_contents($html_filename);
    exit();
}

$conn=mysqli_connect('localhost','root','','static','3306');
if(!$conn){
    die('连接失败');
}
$sql="select * from news where is=$id";
$res=mysqli_query($conn,$sql);
if($row=mysqli_fetch_assoc($res)){
    ob_start();
    header("content-type:text/html;charset:utf-8");
}