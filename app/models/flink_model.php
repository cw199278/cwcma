<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/24
 * Time: 10:41
 */
class FlinkModel extends CommonModel
{
//    新增友情链接网址内容
    function add($post)
    {
        $title = $post['title'];
        $url = $post['url'];
        $this->db->query("insert into flink (`title`, `url`) values ('$title', '$url')");
    }

//    查询友情链接内容
    function all_flink()
    {
        $links = $this->all("select * from flink order by `sort` asc, `id` asc ");
        return $links;
    }

//    删除
    function del($id)
    {
        $this->db->query("delete from flink where `id`='$id'");
    }
//编辑修改友情连链接内容
    function edit($post, $id)
    {

        $title = $post['title'];
        $url = $post['url'];
        $this->db->query("update flink set `title`='$title', `url`='$url' where id='$id'");
    }

//    多个删除
    function all_del($post)
    {
        foreach($post['item'] as $k=>$v){
            $this->db->query("delete from flink where `id`='$v'");
        }
    }
//排序
    function sort($post)
    {
        $all_id = $post['id'];
        $all_sort = $post['sort'];
        foreach($all_id  as $k=>$v){
            $this->db->query("update flink set `sort`='$all_sort[$k]' where id = '$all_id[$k]'");
        }
    }

}