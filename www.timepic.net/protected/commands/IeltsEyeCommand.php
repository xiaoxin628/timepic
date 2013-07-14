<?php
/**
 * this is a command for searching IELST oral test memories from Sina weibo and release them to ieltseye weibo and websit.
 * crontab
 * #timepic crontab
 * *\/5 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye 1>/var/log/ieltseyeCron.log 2>&1 &
 * *\/4 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye searchFromUID 1>/var/log/ieltseyeCron.log 2>&1 &
 * *\/3 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye mentions 1>/var/log/ieltseyeCron.log 2>&1 &
 * *\/2 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye checkWeibo 1>/var/log/ieltseyeCron.log 2>&1 &
 */
Yii::import('ext.openID.SDK.sina.SaeTOAuthV2');
Yii::import('ext.openID.SDK.sina.SaeTClientV2');
set_time_limit(0);
$_SERVER['REMOTE_ADDR'] = '106.187.55.225';
class IeltsEyeCommand extends CConsoleCommand{
    public $akey = '2323547071';
    public $skey='16ed80cc77fea11f7f7e96eca178ada3';
    public $appKeys = array(
        'weicoPro' => array('akey' => '2323547071','skey'=>'16ed80cc77fea11f7f7e96eca178ada3'),
        'weicoAndroid' => array('akey' => '211160679','skey'=>'63b64d531b98c2dbff2443816f274dd3'),
        'weicoIphone' => array('akey' => '82966982','skey'=>'72d4545a28a46a6f329c4f2b1e949e6a'),
        'weigeIphone' => array('akey' => '2027761570','skey'=>'5042214816d14b2d9e8ae8255f96180d'),
    );
    public $app = 'weicoPro';
    public $username = 'ieltseye@gmail.com';
    public $password = 'ieltseye#@!#@!';
    public $openService = '';
    public $openClient = '';
    public $accessToken = '';
    public $tokenFile = '/runtime/ielts.token';
    public $wbInterval = 40;//second
    //关键字
    public $keywords = array("room", "rm", "p1", 'part1', 'p2', 'part2', 'p', 'rom', '人人网雅思哥', 'part');
    //famous 过滤关键字
    public $retweetedKeywords = array("room", "rm", "p1", 'part1', 'p2', 'part2', 'rom', 'part');
    //搜多久之前的微博 3600 一个小时 86400 一天
    public $startTime = 3600;
    //每页微博数量
    public $pageCount = 40;
    public $errorTryTimes = 0;
    //微博名人
    //人人网雅思哥 2060127212
    public $famousUids = '2060127212';


    public function init() {
        parent::init();
		Yii::app()->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $app = array_rand($this->appKeys);
        $this->app = $app;
        $this->akey = $this->appKeys[$app]['akey'];
        $this->skey = $this->appKeys[$app]['skey'];
        $tokenFile = Yii::app()->getBasePath(true).$this->tokenFile.'.'.$this->app;
        $this->accessToken = @file_get_contents(Yii::app()->getBasePath(true).$this->tokenFile.'.'.$this->app);

        if (file_exists($tokenFile)) {
             $filetime = filemtime($tokenFile);
            //two month
            if ($filetime < (time() - 5184000) || empty($this->accessToken)) {
                $this->getToken();
            }
        }else{
            $this->getToken();
        }


        
        $openClient = new SaeTClientV2($this->akey, $this->skey, $this->accessToken);
        $this->openClient = $openClient;
        $uid = $this->openClient->get_uid();
        
        if (isset($uid['error']) && $this->errorTryTimes<=3) {
            $this->getToken();
            $this->init();
            echo $this->errorTryTimes;
        }
    }
    


    public function run($args) {
		parent::run($args);
	}
    
    public function actionIndex(){
        $this->actionSearch("人人网雅思哥 p");
        sleep(60);
        $this->actionSearch("room p1 p2");
        sleep(60);
        $this->actionSearch("room part1 part2");
        sleep(60);
        $this->actionSearch("rm p1 p2");
        sleep(60);
        $this->actionSearch("rm part1 part2");
        Yii::app()->end();
    }
    
    //@我的微博采集
    public function actionMentions(){
        $weibos = $data= array();
        $keywords = '';
        $page = 1;
        $count = 100;
        $since_id = 0;
        $since_id = Yii::app()->db->createCommand()->select('wbid')->from('{{ieltseye_weibo}}')->where('source=:source', array(':source'=>'1'))->order("wbid DESC")->queryScalar();
        $weibos = $this->openClient->mentions( $page, $count, intval($since_id), 0, 0, 0, 1 );
        if ($weibos['statuses']) {
           $totalPages = @ceil($weibos['total_number']/$count);
           for($page=1;$page<=$totalPages;$page++){
                $weibos = $this->openClient->mentions( $page, $count, intval($since_id), 0, 0, 0, 1 );
                $formatWeibos = $this->recordWeibo($weibos, $keywords, '1');
                foreach ($formatWeibos as $weibo){
                    echo $weibo['wbid']."\r\n";
                }
           }
        }else{
            echo "none\r\n";
        }
    }
    
  //微博特定采集
    public function actionSearchFromUID(){
        $weibos = $data= $query = $retweeted = array();
        $totalPages = 1;
        $count = 150;
        $page = 1;
        $weibos = $this->openClient->timeline_batch_by_id($this->famousUids, $page, $count, 0, 0);
        //首页 入库
        if ($weibos['statuses']) {
            foreach($weibos['statuses'] as $weibo){
                //必须是转发且转发时间不超过1个小时
                if (isset($weibo['retweeted_status']) && strtotime($weibo['created_at'])> time()-3600 ) {
                    $retweeted['statuses'][] = $weibo['retweeted_status'];
                }
            }
            if (!empty($retweeted)) {
                $formatWeibos = $this->recordWeibo($retweeted, '', 2);
                foreach ($formatWeibos as $weibo){
                    echo $weibo['wbid']."\r\n";
                }
            }else{
                echo "none\r\n";
            }

        }else{
            echo "none\r\n";
        }
        /*
        //分页 入库
        if ($weibos['statuses']) {
           $totalPages = @ceil($weibos['total_number']/$count);

           for($page=1;$page<=$totalPages;$page++){
                $weibos = $this->openClient->timeline_batch_by_id($this->famousUids, $page, $count, 0, 0);
                foreach($weibos['statuses'] as $weibo){
                    //必须是转发且时间不超过6个小时
                    if ($weibo['retweeted_status'] && strtotime($weibo['retweeted_status']['created_at'])> time()-43200 ) {
                        $Retweeted['statuses'][] = $weibo['retweeted_status'];
                    }
                }
                $formatWeibos = $this->recordWeibo($Retweeted, '', 2);
                foreach ($formatWeibos as $weibo){
                    echo $weibo['wbid']."\r\n";
                }
           }
        }else{
            echo "none\r\n";
        }
         */
    }
    //微博搜索采集
    public function actionSearch($keywords){
        $weibos = $data= array();
        $count = $this->pageCount;
        $page = 1;
        $query = array(
            'q'=>$keywords,
            'filter_ori' => 1,
            'starttime' => time()-$this->startTime,
            'endtime'=>time(),
            'count'=>$count,
            'page'=>$page,
        );
        
        $weibos = $this->openClient->search_statuses_high($query);
        //分页 入库
        if ($weibos['statuses']) {
           $totalPages = @ceil($weibos['total_number']/$count);

           for($page=1;$page<=$totalPages;$page++){
                $query = array(
                    'q'=>$keywords,
                    'filter_ori' => 1,
                    'starttime' => time()-$this->startTime,
                    'endtime'=>time(),
                    'count'=>$count,
                    'page'=>$page,
                );
                $weibos = $this->openClient->search_statuses_high($query);
                $formatWeibos = $this->recordWeibo($weibos, $keywords);
                foreach ($formatWeibos as $weibo){
                    echo $weibo['wbid']."\r\n";
                }
           }
        }else{
            echo "none\r\n";
        }
    }
    
    public function actionCheckWeibo(){
        $message = '';
        $lockFile = Yii::app()->getBasePath(true).'/runtime/ielts.lock';
        $res = $resUpdate = array();
        if (file_exists($lockFile)) {
            if (filemtime($lockFile) < (time()-1800)) {
                //删除锁文件
                @unlink($lockFile);
            }else{
                echo "Command is running!\r\n";
                Yii::app()->end(); 
            }
        }else{
             //创建锁文件
            @touch($lockFile);
        }
        
        $count = Yii::app()->db->createCommand()->select('count(eid)')->from('{{ieltseye_weibo}}')->where('status!=:status', array(':status'=>'1'))->queryScalar();
        if ($count) {
            $query = Yii::app()->db->createCommand()->select('wbid, text, created_at')->from('{{ieltseye_weibo}}')->where('status!=:status', array(':status'=>'1'))->order("eid DESC")->query();
            while ($row = $query->read()) {
                //加上时间
                $message = $row['text'];
                $topic = '#IELTSEYE'.date("ymd", $row['created_at']).'# ';
                //去掉@某人
                $message = preg_replace("/@[\\x{4e00}-\\x{9fa5}\\w\\-]+/u", "", $message);
                //保证长度
                $length = 140 - ceil(strlen( urlencode($topic) ) * 0.5) ;   //2个字母为1个字
                $message = $this->sina_weibo_substr($message, $length);
                //加上话题
                $row['text'] = $topic.$message;
                //多久发一条微博。
                sleep($this->wbInterval);
                
                $res = $this->openClient->repost($row['wbid'], $row['text'], 1);
                if (isset($res['error'])) {
                    //target weibo does not exist!
                    if ($res['error_code'] == '20101') {
                            $resUpdate = $this->openClient->update($row['text']);
                            if (isset($resUpdate['error'])) {
                                Yii::log("IeltsEyeCommand.updateWeibo:id:".$row['wbid'].',errorCode:'.$resUpdate['error_code'].',error:'.$resUpdate['error'], 'info', 'ieltseye.log.weibo');
                                Yii::app()->db->createCommand()->update('{{ieltseye_weibo}}', array('status'=>-1), "wbid=:wbid", array(':wbid'=>$row['wbid']));
                            }else{
                                Yii::app()->db->createCommand()->update('{{ieltseye_weibo}}', array('status'=>1), "wbid=:wbid", array(':wbid'=>$row['wbid']));
                            }
                    }else{
                        Yii::log("IeltsEyeCommand.reposeWeibo:id:".$row['wbid'].',errorCode:'.$res['error_code'].',error:'.$res['error'], 'info', 'ieltseye.log.weibo');
                        Yii::app()->db->createCommand()->update('{{ieltseye_weibo}}', array('status'=>-1), "wbid=:wbid", array(':wbid'=>$row['wbid']));
                    }
                }else{
                    Yii::app()->db->createCommand()->update('{{ieltseye_weibo}}', array('status'=>1), "wbid=:wbid", array(':wbid'=>$row['wbid']));
                }
            }
        }else{
            echo "No weibos to be send!\r\n";
        }

        //删除锁文件
        @unlink($lockFile);
    }
    
    
    /***********lib*****************/
    /**
     * $length = 140 - ceil(strlen( urlencode($link) ) * 0.5) ;   //2个字母为1个字
	 * $content = sina_weibo_substr($content, $length);
     * @param type $str
     * @param type $length
     * @return type
     */
    public function sina_weibo_substr($str, $length) {
        $str = trim(strip_tags($str));
            if( strlen($str) > $length + 600 ){
            $str = substr($str, 0, $length + 600);
        }

        $p = '/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/';
        preg_match_all($p,$str,$o);
        $size = sizeof($o[0]);
        $count = 0;
        for ($i=0; $i<$size; $i++) {
            if (strlen($o[0][$i]) > 1) {
                $count += 1;
            } else {
                $count += 0.5;
            }

            if ($count  > $length) {
                $i-=1;
                break;
            }

        }
        return implode('', array_slice($o[0],0, $i));
    }
    public function getToken(){
        $serviceBack = array();
        $this->openService = new SaeTOAuthV2($this->akey, $this->skey);
        try {
            $serviceBack = $this->openService->getAccessToken('password', array('username'=>$this->username, 'password'=>$this->password));
        } catch (Exception $exc) {
//            echo 'error';
        }
        $this->accessToken = $serviceBack['access_token'];
        file_put_contents(Yii::app()->getBasePath(true).$this->tokenFile.'.'.$this->app, $this->accessToken);
        $this->errorTryTimes++;
    }
    
    /**
     * 
     * @param type $weibos
     * @param type $keywords
     * @param type $source 0 搜索 1@我的微博 2从名人微博
     * @return type $data 入库微博
     */
    function recordWeibo($weibos, $keywords='', $source='0'){
        $data = array();
        if ($weibos['statuses']) {
            foreach($weibos['statuses'] as $weibo){
                $item['created_at'] = strtotime($weibo['created_at']);
                $item['wbid'] = $weibo['id'];
                $item['wbmid'] = $weibo['mid'];
                $item['text'] = $weibo['text'];
                $item['uid'] = $weibo['user']['id'];
                $item['uidstr'] = $weibo['user']['idstr'];
                $item['screen_name'] = $weibo['user']['screen_name'];
                $item['dateline'] = time();
                $item['keywords'] = $keywords;
                $item['status'] = '0';
                $item['source'] = $source;
                //repose weibo
                if ($this->checkKeywords($item['text'], $source)) {
                    $isExist = Yii::app()->db->createCommand()->select('count(wbid)')->from('{{ieltseye_weibo}}')->where('wbid=:wbid', array(':wbid'=>$item['wbid']))->queryScalar();
                    if (!$isExist) {
                        try {
                            Yii::app()->db->createCommand()->insert("{{ieltseye_weibo}}",$item);
                        } catch (Exception $exc) {
                            Yii::log("IeltsEyeCommand.recordWeibo:".$exc->getMessage(), 'info', 'ieltseye.log.sql');
                        }
                    }
                    $data[] = $item;
                }

            }
        }
        return $data;
    }
    
    /**
     * 检查 关键字 如果没有关键字 就收录
     * @param type $text
     * @param type $type 0 搜索 1@我的微博 2从名人微博
     * @return boolean
     */
    function checkKeywords($text, $source='0'){
        $keywords = $this->keywords;
        if ($source == '2') {
            $keywords = $this->retweetedKeywords;            
        }
        
        if ($text) {
            foreach ($keywords as $word) {
                if (strpos(strtolower($text), $word) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}
?>
