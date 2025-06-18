<?php
include('confing/common.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');
switch($act){
  case 'kmlist': // 卡密列表
    if($userrow['uid']!=1){
      jsonReturn(-1,"您暂无此权限");
    }
    $a=$DB->query("select * from qingka_wangke_km order by id desc");
    while($row=$DB->fetch($a)){
      $data[]=array(
        'id'=>$row['id'],
        'content'=>$row['content'],
        'money'=>$row['money'],
        'status'=>$row['status'],
        'uid'=>$row['uid'],
        'addtime'=>$row['addtime'],
        'usedtime'=>$row['usedtime']
      );
    }
    $data=array('code'=>1,'msg'=>'获取成功','data'=>$data);
    exit(json_encode($data));
  break;
	case 'addkm': // 添加卡密
    $content=trim(strip_tags(daddslashes($_POST['content'])));
    $money=trim(strip_tags(daddslashes($_POST['money'])));
    if($userrow['uid']!=1){
      jsonReturn(-1,"您暂无此权限");
   }
    if($content==''){
      exit('{"code":-1,"msg":"卡密不能为空"}');
    }
    if($money==''){
      exit('{"code":-1,"msg":"卡密的余额不能为空"}');
    }
    $ishas=$DB->get_row("select * from qingka_wangke_km where content='$content' limit 1");
    if($ishas) {
      exit('{"code":-1,"msg":"该卡密已存在"}');
    }
    $DB->query("insert into qingka_wangke_km (content,money,status,addtime) values ('$content','$money',0,NOW())");
    $data=array(
      'code'=>1,
      'msg'=>'添加成功',
      'content'=>$content
    );
    exit(json_encode($data));
  break;
  case 'querykm': // 查询卡密
    $content=trim(strip_tags(daddslashes($_POST['content'])));
          if($userrow['uuid']!=1){
     exit('{"code":-1,"msg":"无权限使用请联系上级充值"}');
   }
    if($content==''){
      exit('{"code":-1,"msg":"卡密不能为空"}');
    }
    $a=$DB->query("select * from qingka_wangke_km where content='$content' ");
    while($row=$DB->fetch($a)){
      $data[]=array(
        'id'=>$row['id'],
        'content'=>$row['content'],
        'money'=>$row['money'],
        'status'=>$row['status'],
        'uid'=>$row['uid'],
        'addtime'=>$row['addtime'],
        'usedtime'=>$row['usedtime']
      );
    }
    if($data == null) {
      exit('{"code":-1,"msg":"卡密不存在"}');
    }
    $data=array('code'=>1,'msg'=>'查询成功','data'=>$data);
    exit(json_encode($data));
  break;
  case 'paykm': // 使用卡密
    $content=trim(strip_tags(daddslashes($_POST['content'])));
    $uid=trim(strip_tags(daddslashes($_POST['uid']))) ? trim(strip_tags(daddslashes($_POST['uid']))) : $userrow['uid'];
      if($userrow['uuid']!=1){
     exit('{"code":-1,"msg":"无权限使用请联系上级充值"}');
    }
 //   if ($userrow['money'] <= 1) {
 //    exit('{"code":-1,"msg":"余额过低无权使用福利卡密"}');
 //   }
    if($content==''){
      exit('{"code":-1,"msg":"卡密不能为空"}');
    }
    if($uid==''){
      exit('{"code":-1,"msg":"给谁充值啊？"}');
    }
    $km=$DB->get_row("select * from qingka_wangke_km where content='$content' limit 1");
    if(!$km) {
      exit('{"code":-1,"msg":"卡密不存在"}');
    }
    if($km['status']!=0) {
      exit('{"code":-1,"msg":"该卡密已被使用过了"}');
    }
    $user=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
    if ($user['active']!='1') {
      exit('{"code":-1,"msg":"该用户账户状态异常，无法进行充值"}');
    }
    $kmmoney = round($km['money'],2);
    $useradd=round($user['money']+$kmmoney,2);
    $DB->query("update qingka_wangke_user set money=money-'$kmmoney' where uid='1' ");//我的扣费
    $DB->query("update qingka_wangke_user set money='$useradd',zcz=zcz+'$useradd' where uid='$uid' ");//下级增加	    
    wlog(1,"卡密充值","使用卡密成功给uid为{$uid}的靓仔充值{$kmmoney}元,扣除{$kmmoney}元",-$kmmoney);
    wlog($uid,"卡密充值","您使用站长的卡密成功充值{$kmmoney}元",+$kmmoney);
    
    // 设置卡密状态
    $DB->query("update qingka_wangke_km set `status`=1, `uid`='$uid', `usedtime`=NOW() where id='{$km['id']}' ");
    $data=array(
      'code'=>1,
      'msg'=>'使用成功',
      'uid'=>$uid,
      'name'=>$user['name'],
      'usermoney'=>$useradd,
      'kmmoney'=>$km['money']
    );
    exit(json_encode($data));
  break;
  
  case 'deletekm': // 删除卡密
    $id=trim(strip_tags(daddslashes($_POST['id'])));
    if($userrow['uid']!=1){
      jsonReturn(-1,"您暂无此权限");
   }
    if($id==''){
      exit('{"code":-1,"msg":"卡密不能为空"}');
    }
    $DB->query("delete from qingka_wangke_km where id='$id' ");
    $data=array(
      'code'=>1,
      'msg'=>'删除成功'
    );
    exit(json_encode($data));
  break;
}

?>