<?php
/**
 * Created by PhpStorm.
 * User: brady
 * Date: 2016/12/9
 * Time: 17:32
 */
ini_set("memory_limit", "1024M");
require dirname(__FILE__).'/../core/init.php';
// 登录请求url
$login_url='http://61.139.76.140/weixinpay/admin/?OrderNumber=&userTel=&OrderStatus=100&PATH=list&page=2';
// 提交的参数
$params = array(
    "user" => "1262415201@1262415201",
    "pwd" => "936761",
);
// 发送登录请求
requests::post($login_url, $params);
// 登录成功后本框架会把Cookie保存到www.waduanzi.com域名下，我们可以看看是否是已经收集到Cookie了
$cookies = requests::get_cookies("www.waduanzi.com");
print_r($cookies);  // 可以看到已经输出Cookie数组结构
//// 模拟登录
//$cookies = "PHPSESSID=8gqq2j9q26if066g1j9p0r5717;enveesoft_session=gpj5e8m0shaj4i0a39btol8dc4";
//requests::set_cookies($cookies,'61.139.176.140');
//print_r($cookies);  // 可以看到已经输出Cookie数组结构
$count=0;
for ($page = 1; $page <=1580 ; $page++) {
    $url='http://61.139.76.140/weixinpay/admin/?OrderNumber=&userTel=&OrderStatus=100&PATH=list&page='.$page;
    $html = requests::get($url);
    //echo $html;
    // 抽取电话号码
    for ($i = 1; $i < 16; $i++) {
        // code...
        $selector = "//*[@id=\"content\"]/div/div/div/div/div[3]/div/table/tbody/tr[$i]/td[1]";
        $phone= selector::select($html, $selector);
        // 抽取发布时间
        $selector = "//*[@id=\"content\"]/div/div/div/div/div[3]/div/table/tbody/tr[$i]/td[7]";
        $time= selector::select($html, $selector);
        // 检查是否抽取到内容
        $data = array(
            'phone' => $phone,
            'time' => $time,
        );
        $row=db::get_one('select * from customer where phone='.$phone);
        if($row==null)
        {
            //        echo $phone."已经插入\n";
            $res = db::insert("customer", $data);
            $count++;
        }else
        {
            //      echo $phone."已经存在未插入\n";
        }
    }
    echo "已经插入了".$page."页共".$count."条\n";
}
