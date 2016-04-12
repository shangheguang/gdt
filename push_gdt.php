<?php
/**
 * 移动App激活统计 【APP来源打开上报广点通接口（APP首次安装请求，相当于引导页做处理）】
 * @desc 广点通 - (IOS|ANDROID调用此接口)
 * @author shangheguang@yeah.net
 * @date 2016-4-12
 */

//@todo 引入数据库操作和db配置
include_once 'medoo.php';
include_once 'config.php';

//db
try {
    $database = new medoo($db);
} catch (Exception $e) {
    $errorCode = -100;
    $errorMsg = 'Database connection error!';
    echoResult($errorCode, $errorMsg);
}
//表名
$tablename = 'ad_gdt';

$idfa = (isset($_REQUEST['idfa']) && $_REQUEST['idfa']) ? $_REQUEST['idfa'] : '';

if (empty($idfa)) {
    $errorCode = -1;
    $errorMsg = 'idfa empty!';
    echoResult($errorCode, $errorMsg);
}

$muid = md5($idfa);
$join = array('id','muid','app_type','advertiser_id','click_id');

$columns = array(
    "AND" => array(
        'muid' => $muid,
     ),
    'ORDER' => array('id DESC'),
);
$row = $database->get($tablename, $join, $columns);

if (empty($row)) {
    $errorCode = -2;
    $errorMsg = 'idfa is not from gdt!';
    echoResult($errorCode, $errorMsg);
}
$columns = array(
    "AND" => array(
        'muid' => $muid,
        'report_status' => 1,
    ),
);
$report_row = $database->get($tablename, $join, $columns);

if (empty($report_row)) {//@todo 没有上报过

    
    $app_type = $row['app_type'];//ios|android
    $advertiser_id = $row['advertiser_id'];//广告主ID
     
    //@todo 请求的参数
    $data = array(
        'muid' => $muid,
        'conv_time' => time(),
        'click_id' => $row['click_id'],
    );

    $query_string = http_build_query($data);
    
    $encode_page = 'http://t.gdt.qq.com/conv/app/'.$appid.'/conv?'.$query_string;
    $property = $sign_key.'&GET&'.urlencode($encode_page);
    $signature = md5($property);
    $base_data = $query_string.'&sign='.$signature;
    $data = base64_encode(SimpleXor($base_data, $encrypt_key));
     
    //@todo 最终得到拼接的URL， 请求发送广点通
    $url = 'http://t.gdt.qq.com/conv/app/'.$appid.'/conv?v='.$data.'&conv_type=MOBILEAPP_ACTIVITE&app_type='.strtoupper($app_type).'&advertiser_id='.$advertiser_id;
    $ret = curlGet($url);
    $ret = json_decode($ret, true);

    if (isset($ret['ret']) && $ret['ret'] == 0) {
         
        //@todo 更改数据库已上报状态
        $where = array(
            "AND" => array(
                'id' => $row['id'],
                'report_status' => 0,
            ),
        );
        $database->update($tablename, array('report_status'=>1), $where);

        $errorCode = 0;
        $errorMsg = 'success';
        echoResult($errorCode, $errorMsg);

    }else {
        $errorCode = $ret['ret'];
        $errorMsg = 'idfa上报失败!';
        echoResult($errorCode, $errorMsg);
    }
     
} else {
    $errorCode = -3;
    $errorMsg = 'idfa已经上报过!';
    echoResult($errorCode, $errorMsg);
}

// 接口输出
function echoResult($errorCode = 0, $errorMsg = 'success') {
    $arr = array(
        'ret' => $errorCode,
        'msg' => $errorMsg,
    );
    exit(json_encode($arr));
}

// 使用curl模拟get
function curlGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

function SimpleXor($source,$key){
    $retval = '';
    $j = 0;
    $sourcelen = strlen($source);
    $keylen = strlen($key);
    for($i=0;$i<$sourcelen;$i++){
        $retval .= chr(ord($source[$i])^ord($key[$j]));
        $j = $j + 1;
        $j = $j % $keylen;
    }
    return $retval;
}