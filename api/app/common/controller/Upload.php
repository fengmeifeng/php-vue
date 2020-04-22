<?php
namespace app\common\controller;
use think\Controller;
class Upload extends Controller{
	public function index() {

		ossUpload('images');
	}
}
?>