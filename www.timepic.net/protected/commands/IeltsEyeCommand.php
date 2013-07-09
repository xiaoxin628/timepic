<?php
/**
 * this is a command for searching IELST oral test memories from Sina weibo and release them to ieltseye weibo and websit.
 * crontab
 * #timepic crontab
 * *\/5 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye 1>/var/log/ieltseyeCron.log 2>&1 &
 * *\/3 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye mentions 1>/var/log/ieltseyeCron.log 2>&1 &
 * *\/5 7-23 * * * /usr/local/php/bin/php /home/wwwroot/www.timepic.net/protected/yiic ieltseye checkWeibo 1>/var/log/ieltseyeCron.log 2>&1 &
 */
Yii::import('ext.openID.SDK.sina.SaeTOAuthV2');
Yii::import('ext.openID.SDK.sina.SaeTClientV2');
set_time_limit(0);
$_SERVER['REMOTE_ADDR'] = '106.187.55.225';
class IeltsEyeCommand extends CConsoleCommand{
    public $akey = '211160679';
    public $skey='63b64d531b98c2dbff2443816f274dd3';
    public $username = 'ieltseye@gmail.com';
    public $password = 'ieltseye#@!#@!';
    public $openService = '';
    public $openClient = '';
    public $accessToken = '';
    public $tokenFile = '/runtime/IeltsEyeToken.cache';
    public $wbInterval = 31;//second
    //关键字
    public $keywords = array("room", "rm", "p1", 'part1', 'p2', 'part2');
    //搜多久之前的微博 3600 一个小时 86400 一天
    public $startTime = 3600;
    //每页微博数量
    public $pageCount = 40;
    public $errorTryTimes = 0;


    public function init() {
        parent::init();
		Yii::app()->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tokenFile = Yii::app()->getBasePath(true).$this->tokenFile;
        if (file_exists($tokenFile)) {
             $filetime = filemtime($tokenFile);
            //two month
            if ($filetime < time() - 5184000 || empty($this->accessToken)) {
                $this->getToken();
            }
        }else{
            $this->getToken();
        }

        $this->accessToken = file_get_contents(Yii::app()->getBasePath(true).$this->tokenFile);
        
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
        
//        Yii::app()->end();
    }
    
    public function actionCheckWeibo(){
        $lockFile = Yii::app()->getBasePath(true).'/runtime/ielts.lock';
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
//                $row['text'] = '#'.date("ymd", $row['created_at']).'IELTS# '. $row['text'];
                //多久发一条微博。
                sleep($this->wbInterval);
                $res = $this->openClient->repost($row['wbid'], $row['text'], 1);
                if (isset($res['error'])) {
                    Yii::log("IeltsEyeCommand.reposeWeibo:id:".$row['wbid'].',error:'.$res['error'], 'info', 'ieltseye.log.weibo');
                    Yii::app()->db->createCommand()->update('{{ieltseye_weibo}}', array('status'=>-1), "wbid=:wbid", array(':wbid'=>$row['wbid']));
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
    public function getToken(){
        $serviceBack = array();
        $this->openService = new SaeTOAuthV2($this->akey, $this->skey);
        try {
            $serviceBack = $this->openService->getAccessToken('password', array('username'=>$this->username, 'password'=>$this->password));
        } catch (Exception $exc) {
//            echo 'error';
        }
        $this->accessToken = $serviceBack['access_token'];
        file_put_contents(Yii::app()->getBasePath(true).$this->tokenFile, $this->accessToken);
        $this->errorTryTimes++;
    }
    
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
                if ($this->checkKeywords($item['text'])) {
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
    
    //检查 关键字 如果没有关键字 就收录
    function checkKeywords($text){
        if ($text) {
            foreach ($this->keywords as $word) {
                if (strpos(strtolower($text), $word) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}
?>
