<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/11
 * Time: 13:43
 */

/**
 * 注册
 */
class SystemModel extends CommonModel{


    function system()
    {
        $system = $this->one("select * from system where id = '1'");
        return $system;
    }


    function do_system($post)
    {
        $first_name = $post['first_name'];

        $this->db->query("update system set first_name='$first_name' where id='1'");
    }

}