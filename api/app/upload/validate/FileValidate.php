<?php
namespace app\upload\validate;
use think\Validate;
class FileValidate extends Validate {
	$rule = [
		'type' => 'in:pfd,mp4',
	];
	$message = [
		'type.in' => '文件类型不对',
	];
}
?>