<?php
 /**
 * ====================================
 * thinkphp5
 * ====================================
 * Author: 1002571
 * Date: 2018/1/9 14:15
 * ====================================
 * File: BaseController.php
 * ====================================
 */

namespace app\index;


use think\Controller;

class BaseController extends Controller{
    /**
     * 设置模版
     * @var string
     */
    protected $template = '';

    /**
     * 是否树状数据
     * @var bool
     */
    protected $isTree = false;
    /**
     * 需求访问的方法（无需权限校验）
     * @var null
     */
    protected $allowAction = null;

    /**
     * 是否开启校验
     * @var bool
     */
    protected $isValidate;

    /**
     * 逻辑层名称
     * @var string
     */
    protected $logicName;
    /**
     * 逻辑层对象
     * @var mixed
     */
    protected $logic;
    /**
     * 无需用户登陆都可以访问的模块
     * @var array
     */
    protected $allow = ['login','logout','verify'];

    public function _initialize()
    {

        parent::_initialize();
        $params = input();
        if (is_null($this->logicName)) {
            $this->logicName = $this->request->controller();
        }
        try {
            $this->logic = logic($this->logicName);
        } catch (\Exception $e) {
            //后台当逻辑层文件不存在，初始化公共逻辑类
            $this->logic = new BaseLogic();
            $this->logic->setModel($this->logicName);
        }
        if (!is_null($this->isValidate)) {
            $this->logic->isValidate = $this->isValidate;
        }
        $this->logic->setData($params);
    }

    /**
     * 列表入口
     * @return mixed
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $data = $this->logic->lists($this->isTree);
            return $data;
        }

//        return $this->fetch($this->template);
    }


    /**
     * 表单入口
     */
    public function form()
    {
        $result = $this->logic->info();
        if ($result) {
            $this->success($this->logic->getInfo(),'',$result);
        } else {
            $this->error($this->logic->getError());
        }
    }

    /**
     *  保存
     */
    public function save()
    {
        $result = $this->logic->save();
        if ($result) {
            $this->success($this->logic->getInfo());
        } else {
            $this->error($this->logic->getError());
        }
    }

    /**
     *  删除
     */
    public function delete()
    {
        $result = $this->logic->delete();
        if ($result) {
            $this->success($this->logic->getInfo());
        } else {
            $this->error($this->logic->getError());
        }
    }

    /**
     *  修改状态
     */
    public function lock()
    {
        $result = $this->logic->lock();
        if ($result) {
            $this->success($this->logic->getInfo());
        } else {
            $this->error($this->logic->getError());
        }
    }

    /**
     * 下拉列表
     * @return mixed
     */
    public function select()
    {
        $data = $this->logic->select();
        return $data;
    }

    //TODO...
}