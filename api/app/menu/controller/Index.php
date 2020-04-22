<?php
namespace app\menu\controller;
use app\menu\model\MenuModel;
use think\Request;
use app\menu\validate\MenuValidate;
class Index extends Base {
	protected $model;
	protected $request;
	protected $validate;
	public function __construct() {
		$this->model = new MenuModel;
		$this->request = new Request;
		$this->validate = new MenuValidate;
	}
	public function index() {
		$this->getList();
	}
	/**
	 * @author 冯美峰 2020-04-16
	 * @param int $pageSize 每页显示条数
	 * @param int $page 条数
	 * @param string $keyword 关键词
	 * @param int $pid 父ID
	 * @return array
	 */
	public function getList() {
		$where = [
			'is_delete' => 0,
			'pid'       =>  input('pid')?:0,
		];
		$keyword = input('keyword');
		if (!empty($keyword)) {
			$where['name'] = ['like', $keyword.'%'];
		}
		$pageSize = input('pageSize');
		$page = input('page');
		$total = $this->model->getTotal($where);
		$list = $this->model->getList($where, 'name,pid', $pageSize, $page);
		$info = [
			'list'  => $list,
			'total' => $total,
		];
		return success($info);
	}
	public function check($isEdit = false) {
		$data = $this->request->param();
    if (!$this->validate->check($data)) {          
      return error($this->validate->getError());
    }
		if( !$isEdit ) {
			$data['add_time'] = time();
		}
		return $data;
	}
	/**
	 * 添加栏目
	 * @author 冯美峰 2020-04-16
	 * @param string $name 栏目名称
	 * @param int $pid 父ID
	 * @param string $path 栏目地址
	 * @param string $icon icon
	 * @param string $yingwen 英文名称
	 */
	public function add() {
		if(!is_post()) return error("不是POST提交");
		$data = $this->check();
		$res = $this->model->add($data);
		if (!$res) return error("添加失败");
		return success([], "添加成功");

	}
	/**
	 * 修改栏目
	 * @author 冯美峰 2020-04-16
	 * @param int $id ID
	 * @param string $name 栏目名称
	 * @param int $pid 父ID
	 * @param string $path 栏目地址
	 * @param string $icon icon
	 * @param string $yingwen 英文名称
	 * @return 
	 */
	public function update() {
		if(!is_post()) return error("不是POST提交");
		$data = $this->check(true);
		if (empty($data['id'])) return error("ID不能为空");
		$res = $this->model->edit($data, ['cid'=>$data['id']]);
		if (!$res) return error("编辑失败");
		return success([], "编辑成功");
	}
	/**
	 * 详情
	 * @author 冯美峰 2020-04-16
	 * @param int $id ID
	 * @return
	 */
	public function detail() {
		$id = input('id');
		if(empty($id)) return error("请传ID");
		$where = [
			'is_delete' => 0,
			'cid'       => $id,
		];
		$field = 'pid,name,path,icon,add_time';
		$info = $this->model->getRs($where, $field);
		$info['add_time'] = date('Y-m-d H:i:s', $info['add_time']);
		return success($info);
	}
	/**
	 * 删除
	 * @author 冯美峰 2020-04-16
	 * @param int $id ID
	 * @return
	 */
	public function del() {
		if(!is_post()) return error("不是POST提交");
		$id = input('id');
		if (empty($id)) return error("ID不能为空");
		$where = [
			'cid' => $id
		];
		$res = $this->model->edit(['is_delete'=>time()], $where);
		if(!$res) return error("删除失败");
		return success([], "删除成功");
	}
	/**
	 * 栏目递归
	 * @author 冯美峰 2020-04-22
	 * @return 
	 */
	public function page() {
		$where = ['is_delete'=>0];
		$list = $this->model->getPage($where);
		$newList = $this->getSonCategory($list);
		return success($newList);
	}
	/**
	 * 获得子分类
	 * @param $category
	 * @param int $pid
	 * @return array
	 */
	public function getSonCategory($category, $pid=0){
    $arr  = array();
    foreach ($category as $key=>$value){
    	$value['index'] = (string)$value['cid'];
      if ($value['pid'] == $pid){
					// $arr[] = $value;
					// $this->getSonCategory($category,$value['cid']);
          $value['children'] = $this->getSonCategory($category,$value['cid']);
          $arr[] = $value;
      }
    }
    return $arr;
	}
}
?>