<?php
class IeltseyeHelper{
    
    static public function formatTags($tags, $href=""){
        $tagsStr = '';
        if ($tags) {
            $tagarray_all = explode('\t', $tags);
            if($tagarray_all) {
                foreach($tagarray_all as $var) {
                    if($var) {
                        $array_temp = explode(',', $var);
                        $threadtag_array[$array_temp['0']] = $array_temp['1'];
                    }
                }
            }
            if ($href) {
                foreach ($threadtag_array as $tagid=>$tagname){
                    $tagsStr .= CHtml::link(ucwords($tagname), Yii::app()->createUrl('/topic/tag/'.$tagid)).", "; 
                }

            }else{
                $tagsStr = ucwords(implode(',', $threadtag_array));                
            }

            return ucwords($tagsStr);
        }
        
        return false;
    }
    
    static public function textToTags($text) {
        $tags = Yii::app()->cache->get('ieltseyeTags');
        if (!empty($tags)) {
            foreach ($tags as $tagid=>$tagname) {
                $text = str_ireplace($tagname, CHtml::link($tagname, Yii::app()->createUrl('/topic/tag/' . $tagid)), $text);
            }
        }
        
        return $text;
    }
}
?>
