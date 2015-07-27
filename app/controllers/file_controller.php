<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/2
 * Time: 8:59
 */
class FileController extends CommonController{
    private $treeList = array();

    /***
     * 无限分类方法
     * @param $data
     * @param int $pid
     * @param int $count
     * @return array
     */

    public function tree(&$data, $pid = 0, $count = 1)
    {
        foreach ($data as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['count'] = $count;
                $this->treeList [] = $value;
                unset($data[$key]);
                $this->tree($data, $value['id'], $count + 1);
            }
        }
        return $this->treeList;
    }

    function article()
    {
        $cate_id = isset($_GET['cate_id']) ? $_GET['cate_id']:"";

        $articles = $this->model->file($cate_id);


        $this->assign("articles", $articles);

        $this->display();
    }

    /***
     * 查询所有栏目
     */
    function column()
    {
        $columns = $this->model->do_column();
        $this->assign("columns", $this->tree($columns));


//        $pid_cates = $this->model->one_cates();
//        $this->assign("pid_cates", $pid_cates);
        $this->display();
    }

    /**
     * 新增栏目对应的
     */
    function cate()
    {
//        $id = $_GET['id'];
        $top_cate = $this->model->cate();
        $this->assign("top_cate", $this->tree($top_cate));

//        $cate = $this->model->get_cate($id);
//        $this->assign("cate", $cate);

        $this->display();
    }
    function add()
    {
//        $id = $_GET['id'];

        $date = date("Y-m-d", time());
        $this->assign("date", $date);
        $cates = $this->model->all_cates();
        $this->assign("cates", $this->tree($cates));
        $this->display();
    }

    /***
     * 新增文章
     */
    function do_add()
    {
        if($_POST){
            $this->model->add($_POST);
            $this->jump("增加成功", "index.php?c=file&a=add");
        }
    }

    function edit()
    {
        $id = $_GET['id'];
//        $date = date("Y-m-d", time());          //日期是从数据库取出来的！！
//        $this->assign("date", $date);

        $cates = $this->model->all_cates();
        $this->assign("cates", $cates);

        $article = $this->model->edit($id);

        $this->assign("article", $article);
        $this->display();
    }

    /***
     * 修改编辑文章
     */
    function alter()
    {

        $id=$_GET['id'];
        if($_POST){
            $this->model->show($id, $_POST);
            $this->jump("修改成功", "index.php?c=file&a=article");
        }
    }

    /***
     * 删除当前文章
     */
    function del()
    {
        $id = $_GET['id'];
        $this->model->del_article($id);
        $this->jump("删除成功", "index.php?c=file&a=article");
    }


    function sort()
    {

        $this->model->sort($_POST);
        $this->jump("...", "index.php?c=file&a=column");
    }

    /***
     *查询修改栏目对应的名字
     */
    function column_edit()
    {
        $id = $_GET['id'];
        $top_cate = $this->model->cate();
        $this->assign("top_cate", $this->tree($top_cate));          //所有栏目列表

        $cate = $this->model->get_cate($id);
        $this->assign("cate", $cate);

//        $this->model->alter_column($_POST, $id);
//        dump($_POST);

        $this->display();
    }

    /***
     * 修改栏目
     */

    function  column_alter()
    {
        $id = $_GET['id'];
        if($_POST){
//            dump($_POST);
            $this->model->alter_column($_POST, $id);
            $this->jump("...", "index.php?c=file&a=column");
        }

    }


//    function clear_cache(){
//        $this->clearAllCache();
//    }
    function cates_show()
    {
        $cates = $this->model->all_cates();
        $this->assign("cates", $cates);
    }

    /***
     * 删除栏目
     */
    function del_column(){
        $id = $_GET['id'];
        $this->model->del_column($id);
        $this->jump("删除成功", "index.php?c=file&a=column");
    }
    /***
     * 新增栏目
     */

    function add_column()
    {
        if($_POST){
            $this->model->add_column($_POST);
            $this->jump("增加成功", "index.php?c=file&a=column");
        }
    }

//    function article_id()
//    {
//        $cate = $this->model->file();
//        $this->assign("cate", $cate);
//    }
}