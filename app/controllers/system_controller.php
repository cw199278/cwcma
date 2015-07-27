<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/12
 * Time: 14:57
 */
class SystemController extends CommonController
{
    /***
     * 站点信息
     */
    function site_info()
    {

        $system= $this->model->system();
        $this->assign("system", $system);
        $this->display();
    }

    function change_site_info()
    {
        if($_POST){
            $this->model->do_system($_POST);

            $this->jump(".....", "index.php?c=system&a=site_info");
        }
    }



}