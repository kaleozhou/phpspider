<?php
/**
 * Created by PhpStorm.
 * User: brady
 * Date: 2016/12/9
 * Time: 17:32
 */
ini_set("memory_limit", "1024M");
require dirname(__FILE__).'/../core/init.php';
$url='http://www.niuke.cn/nkzx?cat=cjkx';
$html = requests::get($url);
$count=0;
for ($i = 1; $i < 7; $i++) {
    $a=7-$i;
    // code...
    $selector = "/html/body/div[2]/div/div[1]/div/div/ul/li[$a]/text()";
    $title= selector::select($html, $selector);
    // 抽取发布时间
    $selector = "/html/body/div[2]/div/div[1]/div/div/ul/li[$a]/div/span";
    $time= selector::select($html, $selector);
    // 检查是否抽取到内容
    $maxrow=db::get_one("select * from zb_todaydata order by id desc limit 1");
    $maxid= $maxrow['id'];
    $time=substr($time,-5);
    $date=date('Y-m-d');
    $datetime=$date." ".$time;
    $time=strtotime($datetime);
    $data = array(
        'id'=>$maxid+1,
        'title' => $title,
        'create_time' => $time,
        'status'=>1,
        'sort'=>$maxid+1,
    );
    $rows=db::get_all("select * from zb_todaydata where title='".$title."'");
    if($rows==null)
    {
        $res = db::insert("zb_todaydata", $data);
        $count++;
        echo "插入了".$time."消息\n";
    }else
    {
            //echo $title."已经存在未插入\n";
    }
}
echo "本次更新了".$count."条资讯\n";
