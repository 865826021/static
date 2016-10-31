<?php
header("content-type:text/html;charset:utf-8");

function replace($row,$title,$content){
    //含义是 用 $title的内容替换 $row中的 %title%
    $row=str_replace('%title%',$title,$row);
    $row=str_replace('%content%',$content,$row);
    return $row;
}

//处理添加、修改、删除请求
$oper=$_REQUEST['oper'];

if($oper=='add'){
    $title=$_POST['title'];
    $content=$_POST['content'];

    //1.把数据放入到mysql, 同时创建一个html

    $conn=mysqli_connect('localhost','root','','static','3306');
    if(!$conn){
        die('连接失败');
    }
    $sql="insert into news(title,content) values('$title','$content')";
    if(mysqli_query($conn,$sql)){
        //获取刚刚插入数据的id号
        $id=mysqli_insert_id($conn);
        $html_filename="news_id".$id.".html";

        //创建html文件
        $fp_tmp=fopen('template.tpl','r');
        $fp_html_file=fopen($html_filename,'w');

        //思路->tmp->html 逐行读取template.tpl文件，然后逐行替换
        while(!feof($fp_tmp)){
            //读取一行.
            $row=fgets($fp_tmp);
            //替换(小函数)
            $new_row=replace($row,$title,$content);
            //把替换后的一行写入到html文件
            fwrite($fp_html_file,$new_row);
        }

        //关闭文件流
        fclose($fp_tmp);
        fclose($fp_html_file);

        echo "添加到数据库并成功创建html文件<a href='news_list.php'>返回列表</a>";
    }
    mysqli_close($conn);
}