<?php
namespace app\member\controller;
use app\member\controller\Base;
use app\member\model\User as userModel;
use app\common\validate\LoginValidate;
use think\Request as qu;
class User extends Base {
	/**
   * 模型实例
   * @var obj
   */
  protected $model;
  /**
   * 请求实例
   * @var obj
   */
  protected $request;
  /**
   * 构造方法
   * @author 冯美峰 2020-04-11
   */
  public function __construct() {
      parent::__construct();
      $this->model = new userModel;
      $this->request = new qu;
  }
  public function index() {
    return json(success($this->model->getRs(['id'=>session('uid')])));
  }
  /**
   * @author 冯美峰 2020-04-15
   * @return 添加
   */
  public function add() {
  	if (!is_post()) return error("请用POST方式提交");
    $data = $this->check();
    $res = $this->model->save($data);
    if (!$res) return error("添加失败");
    return success([], '添加成功');
  }
  /**
   * @author 冯美峰 2020-04-15
   * @return data
   */
  public function check($isEdit = false) {
    $data = input();
    $validate = new LoginValidate;
    if (!$validate->check($data)) {          
      return error($validate->getError());
    }
    $data['password'] = makePassword($data['password']);

    if (!$isEdit) $data['add_time'] = time();
    return $data;
  }
  /**
   * 修改用户基本信息
   * @author 冯美峰 2020-04-28
   * @return 
   */
  public function updateInfo() {
    if (!is_post()) return error("请用POST方式提交");
    $data = $this->check(true);
    $res = $this->model->updateData($data, ['id'=>$data['id']]);
    if (!$res) return error("修改失败");
    return success([], '修改成功');
  }
}
?>