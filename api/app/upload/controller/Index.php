<?php
namespace app\upload\controller;
use app\upload\controller\Base;
use app\common\toole\Upload as UploadFile;
use think\Request;
class Index extends Base{
	protected $request;
	public function __construct() {
		$this->request = new Request;
	}
	public function index() {
		$file = $this->request->file('name');
		// print_r($file);
		$info = $file->getInfo();
		// print_r($info);
		// 本地上传
		UploadFile::instance()->uploadPictures($info['tmp_name']);
		// 阿里云上传
		// ossUpload('images', $info['tmp_name']);
	}
}
?>