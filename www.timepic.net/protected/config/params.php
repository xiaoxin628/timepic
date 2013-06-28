<?php

return array(
    // this is used in contact page
    'adminEmail' => 'timepic.net@gmail.com',
    'site' => 'http://test.timepic.net',
    //附件url 可以换到cdn显示
    'attachurl' => 'http://test.timepic.net',
    'coffee_category' => array(
        '1' => array(
            'catid' => '1',
            'catname' => '咖啡资讯'
        ),
        '2' => array(
            'catid' => '2',
            'catname' => '咖啡馆资讯'
        ),
        '3' => array(
            'catid' => '3',
            'catname' => '学习咖啡'
        ),
        '4' => array(
            'catid' => '4',
            'catname' => '咖啡产地大全'
        ),
    ),
    'openIds' => array(
        '1' => array(
            'name' => 'sina',
            'akey' => 'xxxxxxxxxx',
            'skey' => 'xxxxxxxxxxxxxx',
            'callback' => 'http://test.timepic.net/TPUser/sinaLogin',
            'url' => 'http://weibo.com/',
        ),
    ),
    'adminUid' => array(
        1
    ),
);
?>
