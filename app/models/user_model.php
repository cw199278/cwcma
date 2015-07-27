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
class UserModel extends CommonModel{

    function do_reg($post)
    {
        $name = trim($post['name']);
        $password = md5(trim($post['password']));
        $token = md5($name.$password.time().rand(0,999999999));
        $this->db->query("insert into user (`name`, `password`, `token`) values ('$name', '$password', '$token')");
    }

    /**
     * 登录
     *
     */
    function do_login($post)
    {
        $name = trim($post['name']);
        $password = md5(trim($post['password']));

        $user = $this->one("select * from user where `name`='$name' and  `password`= '$password'");
        /**
         * 判断帐号密码是否正确，注册session
         */

        if(!$user){
           return false;
        }
        if(isset($post["rem"])){
            setcookie("token", $user['token'], time()+60*60*24*7);
        } else{
            setcookie("token", $user['token']);
        }
        return true;
    }


//    密码修改
    function change($post)
    {
        $user_id = $_SESSION["user"]["id"];
        $old_password = md5(trim($post['old_password']));

        $count = $this->count("select * from user where `id` = '$user_id' and password = '$old_password'");
        //判断是否原始密码错误
        if($count == 0) {
            return false;
        }

//       密码修改成功
        $new_password = md5(trim($post['password']));
        $token = md5($new_password.time().rand(0,999999999));
        $this->db->query("update user set password='$new_password', token='$token' where id = '$user_id'");
        return true;

    }




}