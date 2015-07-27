<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/11
 * Time: 14:00
 */
class IndexController extends CommonController
{
    function index()
    {
        $articles=$this->model->index();
        $this->assign("articles", $articles);
        $down_articles = $this->model->down_index();
        $this->assign("down_articles", $down_articles);
        $this->display();
    }

    function blog()
    {
        $this->display();
    }

    function contact()
    {
        $this->display();
    }

    function gallery()
    {
        $articles = $this->model->gallery();
//        dump($articles);
        $this->assign("articles", $articles);
        $this->display();
    }

    function tour()
    {
        $this->display();
    }
}