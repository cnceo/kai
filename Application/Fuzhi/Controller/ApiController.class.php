<?php
namespace Fuzhi\Controller;

use Think\Controller;
class ApiController extends Controller{


    /**
     * @return string
     * 彩种接口
     */
    public function index(){
       // echo 1111;exit;
        if(empty($_POST)){
            $arr = array(
                'code'=>false,
                'msg'=>'参数为空',
            );
            return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        file_put_contents('lgc.log',date("Y-m-d H:i:s").$_POST."</br>",FILE_APPEND);//日志

        $data = json_decode($_POST,true);
        if(empty($data['name'])){
            $arr = array(
                'code'=>false,
                'msg'=>'彩种为空',
            );
            return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $res = M('lot_type')->where(array('name'=>$data['name']))->find();

        file_put_contents('lgc.log',date("Y-m-d H:i:s").$res."</br>",FILE_APPEND);

        if(empty($res)){
            $arr = array(
                'code'=>false,
                'msg'=>'没有这个彩种',
            );
            return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $where = array(
            'dat_type'=>$res['id'],
            'dat_open_time'=>time(),
            'dat_expect'=>$data['issue'],
            'dat_codes'=>$data['code'],
        );
        $res = M('lot_data')->add($where);

        file_put_contents('lgc.log',date("Y-m-d H:i:s").$res."</br>",FILE_APPEND);
        if($res < 1){
            $arr = array(
                'code'=>false,
                'msg'=>'系统有误',
            );
            return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $arr = array(
            'code'=>true,
            'msg'=>'成功',
        );
        return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * 视频接口
     */
    public function vodie(){
        if(empty(I('get.gamekey'))){
            $arr = array(
                'code'=>false,
                'msg'=>'参数为空',
            );
        return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $data = I('get.gamekey');
        $info = M('lot_type')->where(array('name'=>$data))->find();
        if(empty($info)){
            $arr = array(
                'code'=>false,
                'msg'=>'没有这个彩种',
            );
        return json_encode($arr,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }




    }
}