<?php
/**
 * 移动App激活统计（在移动转换跟踪设置URL，广点通推送过来的数据）
 * @desc 广点通 - API方案一 （Feedback URL）
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

$requestArr = isset($_REQUEST) ? $_REQUEST : '';
$resuest = '';
if (is_array($requestArr) && count($requestArr)>0 ) {
    $resuest = var_export($requestArr, true);
}

//设备加密码
$muid = isset($requestArr['muid']) ? $requestArr['muid'] : '';
//点击时间
$click_time = isset($requestArr['click_time']) ? $requestArr['click_time'] : '';
//APPID
$appid = isset($requestArr['appid']) ? $requestArr['appid'] : '';
//点击的ID
$click_id = isset($requestArr['click_id']) ? $requestArr['click_id'] : '';
//设备类型(IOS|ANDROID)
$app_type = isset($requestArr['app_type']) ? $requestArr['app_type'] : '';
//广告ID
$advertiser_id = isset($requestArr['advertiser_id']) ? $requestArr['advertiser_id'] : '';

if (!empty($muid) && !empty($appid) && !empty($click_id) && !empty($app_type)) {
     
    //@todo 插入数据
    $arr_input = array(
        'muid' => $muid,
        'click_time' => $click_time,
        'appid' => $appid,
        'click_id' => $click_id,
        'app_type' => $app_type,
        'advertiser_id' => $advertiser_id,
        'content' => $resuest,
    );
    $lastId = $database->insert($tablename, $arr_input);
    if ($lastId) {

        $errorCode = 0;
        $errorMsg = 'success';
        echoResult($errorCode, $errorMsg);
        
    } else {
        $errorCode = -2;
        $errorMsg = 'Insert db error!';
        echoResult($errorCode, $errorMsg); 
    }
         
} else {
    
    $errorCode = -1;
    $errorMsg = 'Request parameter error!';
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