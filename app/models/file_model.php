<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/2
 * Time: 8:58
 */
class FileModel extends CommonModel{
    function file($cate_id="")
    {
        /***
         * 查询栏目对应的文章列表
         */
        if($cate_id == ""){
            $articles = $this->all("select * from article");
        }else{
            $articles = $this->all("select * from article where cate_id='$cate_id'");
        }

        foreach($articles as $key=>$value){
            $cate = $this->one("select * from cate where `id`='$value[cate_id]'");
            $articles["$key"]['cate_name'] = $cate['name'];
        }
        return $articles;
    }
    function do_column()
    {
//     查询所有栏目
        $columns = $this->all("select * from `cate` order by `pid` asc, `sort` asc, id asc ");
//        foreach($columns as $k=>$v){
//            $child = $this->all("select * from cate where pid='$v[id]'");
//            $columns["$k"]["child"] = $child;
//        }
//        dump($columns);
        return $columns;
    }

    function add($post)
    {
//把时间值转换成时间戳
        $date = strtotime($post['date']);
//把多条附件索引值转换成同一行
        $files = array();
        $post_files = $post["files"];
        foreach($post_files as $file){
            if($file !== ""){
                $files[] = $file;
            }
        }
        $files = join(",", $files);
//        新增文章
        $cate_id = $post['cate_id'];
        $title = $post['title'];
        $color = $post['color'];
        $thumb = $post['thumb'];
        $content = $post['content'];
        $this->db->query("insert into article (`cate_id`, `title`, `color`, `date`, `thumb`, `files`, `content`) values ('$cate_id', '$title', '$color', '$date', '$thumb', '$files', '$content')");
    }

    /***
     * 查询所有栏目
     */
    function all_cates()
    {
        $cates= $this->all("select * from cate ");
        return $cates;
    }
//    function one_cates($id)
//    {
//        $pid_cate = $this->all("select * from cate where pid='$id'");
//        dump($pid_cate);
//        return $pid_cate;
//    }


    /***
     *查询编辑文章的栏目
     */
    function edit($id)
    {
        $article = $this->one("select * from article where `id`='$id'");
        $article["files"] = explode(',', $article["files"]);

        return $article;

//        $lamp = $this->all ("select `files` from article order by `files`");
//        $files = explode(',', $lamp);
//        dump($lamp);
//        $edits = $this->all("select * from article where `id`='$id' ");
//        return $edits;
    }

    /***
     * 编辑修改栏目文章
     */
    function show($id, $post)
    {
        $date = strtotime($post['date']);
        $files = array();
        $post_files = $post["files"];
        foreach($post_files as $file){
            if($file !== ""){
                $files[] = $file;
            }
        }
        $files = join(",", $files);
//        编辑文章
        $cate_id = $post['cate_id'];
        $title = $post['title'];
        $color = $post['color'];
        $thumb = $post['thumb'];
        $content = $post['content'];
        $this->db->query("update article set `cate_id`='$cate_id',  `title`='$title', `color`='$color', `date`='$date',
                          `thumb`='$thumb', `files`='$files', `content`='$content' where `id`='$id'");
    }

    /***
     *删除
     */
    function del_article($id)
    {
        $this->db->query("delete from article where `id`='$id'");
    }

    /***
     *
     */

    function cate()
    {
        $top_cate = $this->all("select * from cate order by `pid` asc, `sort` asc, id asc");
        return $top_cate;
    }

    /***
     * 编辑排序
     */
    function sort($post)
    {
        $all_id = $post['id'];
        $all_sort = $post['sort'];
        foreach($all_id  as $k=>$v){
            $this->db->query("update cate set `sort`='$all_sort[$k]' where id = '$all_id[$k]'");
        }

    }

    /***
     *查询对应的内容
     */
    function get_cate($id){
        $cate =  $this->one("select * from cate where id = '$id'");
        return $cate;
    }

    /***
     * @param $post
     * 修改栏目
     */
    function alter_column($post, $id)
    {
        $pid = $post['pid'];
        $name = $post['name'];
        $type = $post['type'];
        $site = $post['site'];
        $show = $post['show'];
        $content = $post['editor1'];
        $this->db->query("update cate set `name`='$name', pid = '$pid', `type`= '$type', `site`='$site', `show`='$show'
                          , `content`= '$content' where id = '$id'");
    }

    function del_column($id)
    {
        $this->db->query("delete from cate where id = '$id'");
    }

    /***
     * 新增栏目
     */
    function add_column($post)
    {
        $pid = $post['pid'];
        $name = $post['name'];
        $type = $post['type'];
        $site = $post['site'];
        $show = $post['show'];
        $content = $post['editor1'];
        $this->db->query("insert into cate (`pid`, `name`, `type`, `site`, `show`, `content`) values ('$pid', '$name',
                          '$type', '$site', '$show', '$content')");
    }






}