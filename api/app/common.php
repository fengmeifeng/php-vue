<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 密码加密
function makePassword($password='') {
    return md5(md5($password).'_123321');
}
/**
* @author 冯美峰 2020-04-14
* @return [type] [生成token]
*/
function makeToken() {
$str = md5(uniqid(md5(microtime(true)), true)); // 生成一个不会重复的字符串
$str = sha1($str); // 加密
return $str;
}
function is_get() {
   $request = request();
   return  $request->isGet();
}
function is_post() {
   $request = request();
   return  $request->isPost();
}
/**
 * 判断是否是AJAX请求
 * @author 冯美峰 2020-4-13
 * @return boolean
 */
function is_ajax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false;
}
if (!function_exists('result')) {

    /**
     * 请求结果返回
     *
     * "code":200,//成功 200 | 失败 非200
     * "msg":"", //失败提示信息
     * "url":"", //需要跳回的网址
     * "data"://部门数据
     * @author zmc <zmc@ecrrc.com>
     *
     * @return [type] [description]
     */
    function result($data = '', $code = 0, $msg = '', $type = 'json', $url = '') {
        // if (empty($url) && isset($_SERVER["HTTP_REFERER"])) {
        //     $url = $_SERVER["HTTP_REFERER"];
        // }
        $type = $type ?: 'json';
        $result = [
            'code'  => $code,
            'msg'   => $msg,
            'url'   => $url,
            'data'  => $data,
        ];

        //留作后期扩展
        if($type == 'json'){
            $result = json_encode($result);
            if (stripos($_SERVER['HTTP_ACCEPT'], 'text/html') === 0) {
                header('Content-Type:text/html; charset=utf-8');
            } else { // if (stripos($_SERVER['HTTP_ACCEPT'], 'application/json') === 0) {
                header('Content-Type:application/json; charset=utf-8');
            }
            exit($result);
        } elseif ('html' == $type) {
            return $result;
        }

    }
}

if (!function_exists('error')) {

    /**
     * 错误返回
     *
     * @author zmc <zmc@ecrrc.com>
     *
     * @param  string  $msg  [description]
     * @param  integer $code [description]
     * @param  string  $data [description]
     * @return [type]        [description]
     */
    function error($msg = '操作失败', $code = 500, $data = '', $type = '', $url = '') {
        if ($msg instanceof Exception) {
            list($msg, $code) = array($msg->getMessage(), $msg->getCode());
        }
        // if (empty($url) && isset($_SERVER["HTTP_REFERER"])) {
        //     $url = 'javascript:history.back(-1);';
        // }

        return result($data, $code, $msg, $type, $url);
    }
}

if (!function_exists('success')) {

    /**
     * 成功返回
     *
     * @author zmc <zmc@ecrrc.com>
     *
     * @param  array   $data 需要返回的数据
     * @param  string  $msg  提示信息
     * @param  integer $code 状态码
     * @param  string  $type 返回数据格式
     * @param  string  $url  需要跳转的URL
     *
     */
    function success($data = '', $msg = '操作成功', $code = 200, $type = '', $url = '') {
        return result($data, $code, $msg, $type, $url);
    }
}
if ( ! function_exists('force_download')) {
    /**
     * 强制下载文件函数
     *
     * @param   string $filename    文件路径
     * @param   mixed  $path    下载的文件名称
     * @return  void
     */
    function force_download($filename = '', $down_name = '', $data = NULL) {
        if ($filename === '' OR $data === '') {
            return;
        }
        elseif ($data === NULL) {
            if ( ! @is_file($filename) OR ($filesize = @filesize($filename)) === FALSE)
            {
                return;
            }

            $filepath = $filename;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
        } else {
            $filesize = strlen($data);
        }
        // Set the default MIME type to send
        $mime = 'application/octet-stream';
        $x = explode('.', $filename);
        $extension = end($x);
        if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT'])) {
            $x[count($x) - 1] = strtoupper($extension);
            $filename = implode('.', $x);
        }
        if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE) {
            return;
        }
        // Clean output buffer
        if (ob_get_level() !== 0 && @ob_end_clean() === FALSE) {
            @ob_clean();
        }

        // Generate the server headers
        header('Content-Type: '.$mime);
        header('Content-Disposition: attachment; filename="'.$down_name.'"');
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.$filesize);
        header('Cache-Control: private, no-transform, no-store, must-revalidate');

        // If we have raw data - just dump it
        if ($data !== NULL) {
            exit($data);
        }

        // Flush 1MB chunks of data
        while ( ! feof($fp) && ($data = fread($fp, 1048576)) !== FALSE) {
            echo $data;
        }

        fclose($fp);
        exit;
    }
}
if (!function_exists('show_file')) {
    /**
     * 输出文件展示
     * @param string $file
     * @param string $title
     * @param array $ban_type
     * @return void
     * @author zmc
     */
    function show_file($file = '', $title = '', $ban_type = []) {
        $default_ban_type = ['php'];
        $ban_type = array_merge($default_ban_type, $ban_type);
        !file_exists($file) && exception("文件不存在");
        $file_info = file_info($file);

        in_array($file_info['extension'], $ban_type) && exception('该文件无法展示');
        $file_name = ($title ?: $file_info['save_name']);
        !preg_match('/.'.$file_info['extension'].'$/', $file_name) && $file_name .= '.'.$file_info['extension'];

        if (!$file_info['mime']) {
            return download_document($file, $title, $ban_type);
        }
        header('Content-Type:'. $file_info['mime']);

        if (!isset($_SERVER['HTTP_ACCEPT_ENCODING']) OR empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            // don't use length if server using compression
            header('Content-Length: ' . $file_info['bytes']);
        }
        header('Content-disposition: inline;'. sprintf("filename*=utf-8''%s", rawurlencode($file_name)));
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Pragma: public');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 300).' GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        ob_clean();
        flush();
        echo readfile($file);
        return true;
    }
    /**
    * 阿里云OSS上传
    * @access public
    * @param  string   $object 阿里云OSS的存储路径，例如： images/huoduan20180315.jpg
    * @param  string   $Path   服务器本地的文件路径，例如： /home/www/huoduan/tmp/huoduan20180315.jpg
    * @param  string   $bucket   阿里云OSS的bucket名称，例如：huoduan
    * @return bool
    */
    function ossUpload($object, $Path, $bucket='huoduan') {
        //以下配置信息可以放到配置文件里
        $keyId = '88huoduanCOMiiii';//您的Access Key ID
        $keySecret = '6yTerXi8dDJiSghiugrtufuTks2OBX';//Access Key Secret
        $endpoint = 'oss-cn-hangzhou.aliyuncs.com';//阿里云oss外网地址endpoint
        $oss = new \OSS\OssClient($keyId,$keySecret,$endpoint);
            try {
                $oss->uploadFile($bucket, $object, $Path);
            } catch(\Exception $e) {
                return $e->getMessage();//如果出错返回错误
            }
        return true;
    }
}