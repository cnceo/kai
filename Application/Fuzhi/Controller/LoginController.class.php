<?php
namespace Fuzhi\Controller;
use Think\Controller;
class LoginController extends Controller{

    function index(){

        $this->display('Common:login');
    }

}