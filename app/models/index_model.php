<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/11
 * Time: 14:03
 */
class IndexModel extends CommonModel{

    function index()
    {
        $articles = $this->all("select * from article  where cate_id='7' order by date desc limit 6 ");

        return $articles;
    }

    function down_index()
    {
        $down_articles = $this->all("select * from article where cate_id='8' order by date desc limit 2");
        return $down_articles;
    }

//    function tour()
//    {
//        $articles = $this->all("select * from article where cate_id='' order by desc limit 9");
//        return $articles;
//    }

    function gallery()
    {
        $articles = $this->all("select * from article where cate_id='3' order by date desc limit 10");
        return $articles;
    }
}