<?php
namespace app\member\controller;
use app\member\controller\Base;
use app\member\model\User;
class Index extends Base {
  /**
   * 模型实例
   * @var obj
   */
  protected static $model;
  /**
   * 构造方法
   * @author 冯美峰 2020-04-11
   */
  public function __construct() {
      parent::__construct();
      self::$model = new User;
  }
  public function index() {
    return json(success(self::$model->getList()));
  }
}
?>