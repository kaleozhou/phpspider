# phpspider -- PHP蜘蛛爬虫框架
向开发者：owner888致敬，准备开发这个项目。

```
$configs = array(
    'name' => '糗事百科',
    'domains' => array(
        'qiushibaike.com',
        'www.qiushibaike.com'
    ),
    'scan_urls' => array(
        'http://www.qiushibaike.com/'
    ),
    'content_url_regexes' => array(
        "http://www.qiushibaike.com/article/\d+"
    ),
    'list_url_regexes' => array(
        "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
    ),
    'fields' => array(
        array(
            // 抽取内容页的文章内容
            'name' => "article_content",
            'selector' => "//*[@id='single-next-link']",
            'required' => true
        ),
        array(
            // 抽取内容页的文章作者
            'name' => "article_author",
            'selector' => "//div[contains(@class,'author')]//h2",
            'required' => true
        ),
    ),
);
$spider = new phpspider($configs);
$spider->start();
```
爬虫的整体框架就是这样, 首先定义了一个$configs数组, 里面设置了待爬网站的一些信息, 然后通过调用```$spider = new phpspider($configs);```和```$spider->start();```来配置并启动爬虫.

#### 运行界面如下:      

![](http://www.epooll.com/zhihu/pachong.gif)

更多详细内容，移步到：

[开发文档](http://doc.phpspider.org)
