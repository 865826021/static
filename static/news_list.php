<?php
$conn=mysqli_connect('localhost','root','','static','3306');
if(!$conn){
    die('连接失败');
}
$sql="select * from news";
$res=mysqli_query($conn,$sql);

header("content-type:text/html;charset:utf-8");
echo "<h1>新闻列表</h1>";
echo "<a href='add_news.html'>添加新闻</a><hr/>";
echo "<table>";
echo "<tr><td>id</td><td>标题</td><td>查看详情</td></tr>";
while($row=mysqli_fetch_assoc($res)){
    echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td><a href='news_id{$row['id']}.html'>查看详情</a></td></tr>";
}
echo "</table>";
mysqli_free_result($res);
mysqli_close($conn);