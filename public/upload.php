<?php
//require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../constants.php';
//
//(new Zend_Application(
//    APPLICATION_ENV,
//    APPLICATION_PATH . '/configs/application.ini'
//))->bootstrap();

// $uploadTmpPath = Zend_Registry::get('config')->files->upload->tempPath;


define('UPLOAD_PATH', __DIR__ . '/../data/temp/');

function response(array $result, $errCode = 0, $errMsg = null) {
    $data = [ 'OK' => 1, 'info' => $result ];
    if ($errCode) {
        $data = [ 'OK' => 0, 'error' => [ 'code' => $errCode, 'message' => $errMsg ] ];
    }
    die(json_encode($data));
}

require __DIR__ . '/../vendor/zfbase/zfe/library/ZFE/File/PluploadHandler.php';

$ph = new ZFE_File_PluploadHandler([
    'target_dir' => UPLOAD_PATH,
    //'allow_extensions' => 'jpg,jpeg,png'
]);
$ph->sendNoCacheHeaders();
// $ph->sendCORSHeaders();
$result = $ph->handleUpload();

if ($result) {

    if (!key_exists('chunk', $result)) {
        $modelName = (key_exists('m', $_REQUEST)) ? $_REQUEST['m'] : null;
        $itemId = (key_exists('id', $_REQUEST)) ? $_REQUEST['id'] : null;
        if (empty($modelName) || empty($itemId)) {
            @unlink($result['path']);
            response(null, 400, 'Missed obligatory params: `m `or `id`. Cant move uploaded file!');
        } else {
            // TODO emit data somehow

            require_once __DIR__ . '/../vendor/autoload.php';
            require_once __DIR__ . '/../constants.php';

            (new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
            ))->bootstrap();

            $item = $modelName::find($itemId);
            $result['item'] = $item->toArray();

            response($result);
        }
    }
    response($result);
}

response(null, $ph->getErrorCode(), $ph->getErrorMessage());