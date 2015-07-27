<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/24
 * Time: 10:41
 */
class FlinkController extends CommonController
{
//    循环查询内容
    function index()
    {
        $flinks = $this->model->all_flink();
        $this->assign("flinks", $flinks);
        $this->display();
    }
//    新增
    function add()
    {
        if($_POST){
            $this->model->add($_POST);
            $this->jump("恭喜您，增加成功", "index.php?c=flink");
        }
    }

//删除
    function flink_del()
    {
        $id= $_GET['id'];
        $this->model->del($id);
        $this->jump("删除成功", "index.php?c=flink&a=index");
    }

//编辑修改
    function edit()
    {
        $id = $_POST['id'];
        if($_POST){
            $this->model->edit($_POST, $id);
            $this->jump("编辑成功", "index.php?c=flink&a=index");
        }
    }

    function del_all()
    {

        $this->model->all_del($_POST);

        $this->jump("删除成功", "index.php?c=flink&a=index");

    }

    function sort()
    {
        $this->model->sort($_POST);
        $this->jump("...", "index.php?c=flink&a=index");
    }
}