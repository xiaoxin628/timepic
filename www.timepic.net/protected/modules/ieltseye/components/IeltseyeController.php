<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminController
 *
 * @author lixiaoxin
 */
class IeltseyeController extends Controller {

        public function init() {
            $this->layout = 'application.modules.ieltseye.views.layouts.main';
            Yii::app()->homeUrl = Yii::app()->params['ieltseye']['homeUrl'];
            Yii::app()->name = Yii::app()->params['ieltseye']['name'];
            $this->initCache();
        }
        
        public function initCache(){
            $this->cacheTags();
        }
        
        public function cacheTags(){
            $tags = Yii::app()->cache->get('ieltseyeTags');
            if (empty($tags)) {
                $tags = IeltseyeTag::model()->findAll();              
                Yii::app()->cache->set('ieltseyeTags', CHtml::listData($tags, 'tagid', 'tagname'), 3600);
            }
        }
}

?>
