<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/11
 * Time: 13:43
 */
class UserController extends CommonController{

    /**
     * 显示注册页面
     */
    function reg()
    {
        $this->display();
    }
    /*
     * 执行注册操作
     */
    function do_reg()
    {
        if($_POST){
            $this->model->do_reg($_POST);
            $this->jump("注册成功", "index.php?c=user&a=login");
        }
    }


    function login()
    {
        $this->display();
    }

    function do_login()
    {
        if($_POST){
            if($this->model->do_login($_POST)){
                $this->jump("登录成功", "index.php?c=admin&a=index");
            } else{
                $this->jump("帐号密码错误，请重新登录", "index.php?c=user&a=login");
            }

        }
    }


    /***
     * 修改密码
     */
    function change_password(){
        $this->display();
    }

    function do_change()
    {
        if($_POST){
            if($this->model->change($_POST)){
                $this->clearSession();
                $this->jump("修改成功", "index.php?c=user&a=login");
            } else {
                $this->jump("原始密码错误", "index.php?c=user&a=change_password");
            }
        }
    }
}