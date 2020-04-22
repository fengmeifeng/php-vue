<?php
namespace app\common\toole;
use think\Config;
use think\File;
use think\Image;
// 调用
// Upload::instance()->uploadPictures($this->request->file($name));
class Upload
{
	protected static $instance;
	protected static $rootPath = ROOT_PATH . DS;
	protected static $savePath = [
			'temp'  => 'uploads/temp',
			'adImg' => 'uploads/adImg'
	];
	public static function instance() {
    if(!self::$instance instanceof self) {
      self::$instance = new self();
    }
    return self::$instance;
	}
	/**
 * 获取文件的保存路径
 * @param string $path 路径
 * @param boole $absolute  是否生成绝对路径
 * @param array  $date 路径生成的规则 tp自带date 默认为false
 * @access static protected
 * @return string
 */
	protected static function getSavePath($path, $absolute = TRUE, $date = FALSE) {
    if (empty($path) || !isset(self::$savePath[$path])) {
      return self::joinPath(self::$savePath['default'], $absolute, $date);
    }
    if (isset(self::$savePath[$path])) {
      return self::joinPath(self::$savePath[$path], $absolute, $date);
    }
	}
	/**
	* 拼接文件保存路径
	* @param string $path 路径
	* @param boole $absolute  
	* @param boole  $date 路径生成的规则 tp自带date 默认为false
	* @access static protected
	* @return string
	*/
	protected static function joinPath($path, $absolute, $date) {
    $root_path = $absolute ? self::$rootPath : "";
    $save_path = $root_path . $path;
    if ($date) {
      $save_path = $save_path . DS . date("Ymd", time());
    }
    return $save_path;
	}
	/**
	 * 上传图片文件
	 * @param object $file 上传的图片对象
	 * @param string $save_path  保存的路径
	 * @param array  $validate 验证规则
	 * @access public
	 * @return array
	 * @author xiaojiawei <721001522@qq.com>
 	*/
	public function uploadPictures(File $file, $save_path = "", $validate = [], $rule = 'date') {
    $validate = $validate ? $validate : Config::get("upload.upload_images_validate");
    $path = self::getSavePath($save_path);
    if ($file) {
      $info = $file->validate($validate)->rule($rule)->move($path);
      if ($info) {
        $absolute_path = $this->formatPath($info->getPathname());
        $return_path = $this->formatPath(self::getSavePath($save_path, false) . DS . $info->getSaveName());
        return ['status' => 1, 'absolute_path' => $absolute_path, 'save_path' => $return_path];
      } else {
      return ['status' => 0, 'msg' => $file->getError()];
      }
    }
	}
}
?>