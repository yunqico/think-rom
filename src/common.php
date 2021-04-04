<?php
declare (strict_types=1);

if(!function_exists("phone_format")){
    /**
     * 手机号码、固机号码隐藏中间
     * @param $number string 手机号码或固机号码
     * @return string
     *
     */
    function phone_format($number){
        $isTel = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$number); //固定电话
        if($isTel == 1){
            return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$number);
        }
        return  preg_replace('/(1[3456789]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$number);
    }
}

if(!function_exists("number2arr")){
    /**
     * 数字拆分为数组
     * @param $number string 数字字符串
     * @return array
     */
    function number2arr($number){
        $arr = preg_split('//', $number, -1, PREG_SPLIT_NO_EMPTY);
        return $arr;
    }
}
if(!function_exists("array_psort")){
    /**
     * @param $array array 要排序的数组
     * @param $row string 排序依据列
     * @param $type string 排序类型[asc or desc]
     * @return array
     */
    function array_psort($array,$row,$type){
        $array_temp = array();
        foreach($array as $v){
            $array_temp[$v[$row]] = $v;
        }
        if($type == 'asc'){
            ksort($array_temp);
        }elseif($type='desc'){
            krsort($array_temp);
        }else{
        }
        return $array_temp;
    }
}
if(!function_exists("base64_image_content")){

    /**
     * base64 存储为图片
     * @param $base64
     * @param $path string 存储路径（相对路径）
     * @return bool|string
     */
    function base64_image_content($base64,$path){
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
            $type = $result[2];
            $new_file = app()->getRootPath()."public/".$path;
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $picname=mt_rand(0,99).time().".{$type}";
            $new_file = $new_file.$picname;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64)))){
                return $path.$picname;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}

if(!function_exists("curPageURL")){
    /**
     * 获取当前页面url 不带参数
     * @return string
     */
    function curPageURL(){
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        $this_page = $_SERVER["REQUEST_URI"];
        // 只取 ? 前面的内容
        if (strpos($this_page, "?") !== false) {
            $this_pages = explode("?", $this_page);
            $this_page = reset($this_pages);
        }

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
        }
        return $pageURL;
    }
}
