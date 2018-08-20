<?php

namespace Admin\Controller;

use User\Api\UserApi;

class PublicController extends \Think\Controller
{
    public function login($username = null, $password = null, $verify = null)
    {
        if (IS_POST) {
            $User = new UserApi;
            $uid = $User->login($username, $password);
            if (0 < $uid) {
                $Member = D('Member');
                if ($Member->login($uid)) {
                    $this->success('登录成功！', U('Index/index'));
                } else {
                    $this->error($Member->getError());
                }
            } else {
                switch ($uid) {
                    case -1:
                        $error = '用户不存在或被禁用！';
                        break;
                    case -2:
                        $error = '密码错误！';
                        break;
                    default:
                        $error = '未知错误！';
                        break;
                }
                $this->error($error);
            }
        } else {
            if (is_login()) {
                $this->redirect('Index/index');
            } else {
                $config = S('DB_CONFIG_DATA');
                if (!$config) {
                    $config = D('Config')->lists();
                    S('DB_CONFIG_DATA', $config);
                }
                C($config);
                $this->display();
            }
        }
    }

    public function logout()
    {
        if (is_login()) {
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify()
    {
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
}