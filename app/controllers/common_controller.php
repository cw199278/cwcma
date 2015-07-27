<?php
// smarty 配置
require(VENDOR_PATH.'/smarty/Smarty.class.php');

class CommonController extends Smarty
{

    //当前方法对应的模板
    var $template;
    var $action;
    var $controller;
    protected $model;

    function __construct(){
        global $a, $c;
        $this->action = $a;
        $this->controller = $c;
        //$c="user";

        //smarty配置
        parent::__construct();
        //模板的路径
        $this->setTemplateDir(APP_PATH.'/views/'.$c);

        //编译模板位置
        $this->setCompileDir(APP_PATH.'/views/smarty/templates_c/');

        //配置文件路径
        $this->setConfigDir(APP_PATH.'/views/smarty/configs/');

        //缓存路径
        $this->setCacheDir(APP_PATH.'/views/smarty/cache/');

        $this->left_delimiter = "{{";
        $this->right_delimiter = "}}";

        //index.html
        $this->template = $a.".html";
        $this->assign("assets", "/app/assets");
        //检查登录
        $this->check_login();

        $this->model = D();
    }


   // $s->display();
    /***
     * 重载smarty的display方法
     * @param null $template
     * @param null $cache_id
     * @param null $compile_id
     * @param null $parent
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $template = $template=="" ? $this->template : $template;
        parent::display($template, $cache_id = null, $compile_id = null, $parent = null);
    }


    /***
     * 清除session方法
     */
    function clearSession(){
        $_SESSION=array();
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time()-3600, "/");
        }
        setcookie("token", "", time()-3600, "/");
    }

    //成功信息
    function jump($info, $url){
        echo "<script>alert('".$info."');location.href='".$url."'</script>";
    }

    private function check_login(){
        if(isset($_SESSION['user'])){
            $this->assign("user", $_SESSION['user']);
            return;
        }
        $allow = array("reg", "do_reg", "login", "do_login");

        if($this->controller == "user" and in_array($this->action, $allow)){
            return;

        }

        if(!isset($_COOKIE["token"])){
            $this->jump("您还没有登录", "index.php?c=user&a=login");
            exit;
        }


        $user_model=M();
        $token = $_COOKIE["token"];
        $user = $user_model->one("select * from user where token = '$token'");
        if(!$user){
            $this->jump("非法操作", "index.php?c=user&a=login");
        }

        $_SESSION['user'] = $user;
        $this->assign("user", $_SESSION['user']);
    }
    /**
     * 判断是否登录
     */
//    private function check_login(){
//      $allow = array("reg", "do_reg", "login", "do_login");   //允许登录的方法
//
//      if($this->controller == "user" and in_array($this->action, $allow)) {   //in_array判断是否在数组中
//        return;
//      }
//
//      if(!isset($_SESSION["isLogin"])) {
//        $this->jump("您还没有登录!", "index.php?c=user&a=login");
//      }
//
//      $this->assign("user", $_SESSION["user"]);
//
//    }


    /***
     * 判断是否登录
     */
    /*
    function check_login(){
        if(isset($_SESSION["user"])) {
            $this->assign("user", $_SESSION["user"]);
            return true;
        }

        $allow = array("reg", "do_reg", "login", "do_login");
        if($this->controller == 'user' and in_array($this->action, $allow)) {
            return true;
        }

        if(!isset($_COOKIE["token"])) {
            $this->jump("您还没有登录", "index.php?c=user&a=login");
            exit();
        }

        $token = $_COOKIE["token"];
        $user_model = M();
        $user = $user_model->one("select * from user where token = '$token'");
        if(!$user) {
            $this->jump("请不要非法伪造登录信息", "index.php?c=user&a=login");
            exit();
        }
        $_SESSION["user"] = $user;
        $this->assign("user", $user);
    }
    */

}
