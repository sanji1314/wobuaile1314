<?php
include('confing/common.php'); 
$ckxz=$DB->get_row("select settings,api_ck,api_xd,api_proportion from qingka_wangke_config");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');
if($conf['settings']!=1){
    exit('{"code":-1,"msg":"API�����ѹرգ�����ϵ����Ա��"}');
}else{
    switch($act){
	case 'getmoney'://��ѯ��ǰ���
       $uid=trim(strip_tags(daddslashes($_POST['uid'])));
       $key=trim(strip_tags(daddslashes($_POST['key'])));
        if($uid=='' || $key==''){
     	   exit('{"code":0,"msg":"������Ŀ����Ϊ��"}');
        }
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
	     if($row['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"�㻹û�п�ͨ�ӿ�Ŷ");
	     	exit(json_encode($result));
	     }elseif($row['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"�ܳ״���");
	     	exit(json_encode($result));
	     }else{
            $result=array(
                'code'=>1,
                'msg'=>'��ѯ�ɹ�',
                'money'=>$row['money']
            );
		    exit(json_encode($result));
     }
  break;
  case 'get'://������ѯ
       $ckmoney=$conf['api_ck'];
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $type=daddslashes($_POST['type']);
       $money=daddslashes($_POST['money']);
       $ck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API���' AND uid='$uid' ");
       $xd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API�������' AND uid='$uid' ");
       $xdb=round($xd/$ck,4)*100;
       
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass==''){
     	   exit('{"code":0,"msg":"������Ŀ����Ϊ��"}');
        }
        
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
		$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     if($row['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"�㻹û�п�ͨ�ӿ�Ŷ");
	     	exit(json_encode($result));
	     }elseif($row['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"�ܳ״���");
	     	exit(json_encode($result));
	     }elseif($row['money'] < $ckmoney && $uid!='1049'){
	     	$result=array("code"=>-2,"msg"=>"���С��{$ckmoney}��ֹ���ò��");
	     	exit(json_encode($result));
	     }elseif($rs['status'] == 0){
	     	$result=array("code"=>-2,"msg"=>"�������¼ܽ�ֹ��Σ�");
	     	exit(json_encode($result));
	     }else{
	          if($xdb < $conf['api_proportion']){
	            $ckkf=$row['money']-0;
    	        $DB->query("update qingka_wangke_user set money='$ckkf' where uid='$uid' ");
    	        $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");	    
                $result=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);					
    	 		$result['userinfo']=$school." ".$user." ".$pass;
    		    wlog($uid,"API���","{$rs['name']}-�����Ϣ��{$school} {$user} {$pass}",0);	
        		    
        		    if($type=="xiaochu"){
        		    	foreach($result['data'] as $row){			    		    		
        		    		if($value==''){
        		    			$value=$row['name'];
        		    		}else{
        		    			$value=$value.','.$row['name'];
        		    		}	
        		    	}		 
        		    	$v[0]=$rs['name'];   	
        		    	$v[1]=$user;
        		    	$v[2]=$pass;
        		    	$v[3]=$school;
        		    	$v[4]=$value;	
        		    	$data=array(
        		    	  'code'=>$result['code'],
        		    	  'msg'=>$result['msg'],
        		    	  'data'=>$v,
        		    	  'js'=>'',
        		    	  'info'=>'����֮�࣬��֪���ղ��ڳ�֮? ����'
        		    	);
        		    	exit(json_encode($data));
        		    }else{
        		    	exit(json_encode($result));
        		    }		   		   
	          }
	          else{
	                $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");	    
                    $result=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);					
        	 		$result['userinfo']=$school." ".$user." ".$pass;
        		    wlog($uid,"API���","{$rs['name']}-�����Ϣ��{$school} {$user} {$pass}",0);	
        		    
        		    if($type=="xiaochu"){
        		    	foreach($result['data'] as $row){			    		    		
        		    		if($value==''){
        		    			$value=$row['name'];
        		    		}else{
        		    			$value=$value.','.$row['name'];
        		    		}	
        		    	}		 
        		    	$v[0]=$rs['name'];   	
        		    	$v[1]=$user;
        		    	$v[2]=$pass;
        		    	$v[3]=$school;
        		    	$v[4]=$value;	
        		    	$data=array(
        		    	  'code'=>$result['code'],
        		    	  'msg'=>$result['msg'],
        		    	  'data'=>$v,
        		    	  'js'=>'',
        		    	  'info'=>'����֮�࣬��֪���ղ��ڳ�֮? ����'
        		    	);
        		    	exit(json_encode($data));
        		    }else{
        		    	exit(json_encode($result));
        		    }
	          }
     }
  break;

  case 'add'://�����µ�
       $xdmoney=$conf['api_xd'];
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $kcid=daddslashes($_POST['kcid']);
       $kcname=daddslashes($_POST['kcname']);
       $score=daddslashes($_POST['score']);
       $shichang=daddslashes($_POST['shichang']);
       $clientip=real_ip();
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass=='' || $kcname==''){
     	   exit('{"code":0,"msg":"������Ŀ����Ϊ��"}');
        }
         $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
		 $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     if($row['key']=='0'){
	     	exit('{"code":-1,"msg":"�㻹û�п�ͨ�ӿ�Ŷ"}');
	     }if($row['key']!=$key){
	     	exit('{"code":-2,"msg":"�ܳ״���"}');
	     }elseif($row['money'] < $xdmoney){
	     	$result=array("code"=>-2,"msg"=>"���С��{$xdmoney}��ֹ����API�µ�");
	     	exit(json_encode($result));
	     }elseif($rs['status'] == 0){
	     	$result=array("code"=>-2,"msg"=>"С�ϵܣ���Ʒ���¼����㻹��ʲô���أ�");
	     	exit(json_encode($result));
	     }else{ 
	     	$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     	$res=$DB->get_row("select * from qingka_wangke_huoyuan where hid='{$docking}' limit 1 ");
       	    if($rs['yunsuan']=="*"){
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}elseif($rs['yunsuan']=="+"){
	    		$danjia=round($rs['price']+$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}else{
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}
	    	//�ܼ�
	    	$mijia=$DB->get_row("select * from qingka_wangke_mijia where uid='{$uid}' and cid='{$platform}' ");
	        if($mijia){
	            if ($mijia['mode']==0) {
	                $danjia=round($danjia-$mijia['price'],2);
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }elseif ($mijia['mode']==1) {
	                $danjia=round(($rs['price']-$mijia['price'])*$row['addprice'],2);
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }elseif ($mijia['mode']==2) {
	                $danjia=$mijia['price'];
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }
	        }	
	        if ($danjia>=$danjia1) {//�ܼۼ۸����ԭ�ۣ��ָ�ԭ��
	            $danjia=$danjia1;
	        }
            if($danjia==0 || $row['addprice']<0.1){
            	exit('{"code":-1,"msg":"���У��ҵ��ﲻ��������С�����⣬���������֮��������������"}');
            } 
		    if($res['pt']=='wkm4'){
		    	$m4=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);
		    	    if($m4['code']=='1'){
                    	 for($i=0;$i<count($m4['data']);$i++){
                    	 	$kcid=$m4['data'][$i]['id'];
                    	 	$kcname1=$m4['data'][$i]['name'];
                            if($kcname1==$kcname){
                            	break;
                            }else{
                            	exit('{"code":-1,"msg":"����������γ�����","status":-1,"message":"����������γ�����"}');
                            } 
                    	 }
                   }
		    }

	     	$c=explode(",",$kcname);
	     	$d=explode(",",$kcid);
	     	for($i=0;$i<count($c);$i++){
     		   if($row['money']<$danjia*count($c)){
		        	exit('{"code":-1,"msg":"�����Ա����ύ"}');
		        	return;
		        }
		       if($DB->get_row("select * from qingka_wangke_order where ptname='{$rs['name']}' and school='$school' and user='$user' and pass='$pass' and kcid='$kcid' and kcname='$kcname' ")){
                           $dockstatus='3';//�ظ��µ�
	           }elseif($rs['docking']=='0'){$dockstatus='99';}else{$dockstatus='0';}	      
			   $is=$DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,user,pass,kcid,kcname,fees,noun,miaoshua,addtime,ip,dockstatus,score,shichang) values ('{$uid}','{$rs['cid']}','{$rs['docking']}','{$rs['name']}','{$school}','$user','$pass','$d[$i]','$c[$i]','{$danjia}','{$rs['noun']}','$miaoshua','$date','$clientip','$dockstatus','$score','$shichang') ");//����Ӧ�γ�д�����ݿ�	               	               
	           if($is){
	           	  $DB->query("update qingka_wangke_user set money=money-'{$danjia}' where uid='{$row['uid']}' limit 1 "); 
	              wlog($row['uid'],"API�������","{$user} {$pass} {$c[$i]} �۳�{$danjia}Ԫ��",-$danjia);
	              $ok=1;
	              
	              $Res = $DB->get_row("select * from qingka_wangke_order where ptname='{$rs['name']}' and school='$school' and user='$user' and pass='$pass' and kcid='$kcid' and kcname='$kcname'  order by oid desc limit 1;"); 
                  $oid = $Res['oid'];
	           }  			     		
	     	}
            if($ok==1){
        	 	exit('{"code":0,"msg":"�ύ�ɹ�","status":0,"message":"�ύ�ɹ�","id":"'.$oid.'"}');
        	 }else{
        	 	exit('{"code":-1,"msg":"����������γ�����","status":-1,"message":"����������γ�����"}');
        	 }
         }
  break;
  case 'uporder': //����ˢ��
        $oid = trim(strip_tags(daddslashes($_POST['oid'])));
        $row = $DB -> get_row("select * from qingka_wangke_order where oid='$oid'");
        if ($row['dockstatus'] == '99') {
            $result = pre_zy($oid);
            exit(json_encode($result));
        }
        $result = processCx($oid);
        for ($i = 0; $i < count($result); $i++) {
            $DB -> query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `user`='{$result[$i]['user']}' and `kcname`='{$result[$i]['kcname']}' and `oid`='{$oid}'");
        }
        $upmsg = "ͬ���ɹ�";
        jsonReturn(1, $upmsg);
        break;    
  case 'getadd'://��ѯ�ж��µ�
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $kcname=daddslashes($_POST['kcname']);
       $miaoshua=0;
       $clientip=real_ip();
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass=='' || $kcname==''){
     	   exit('{"code":0,"msg":"������Ŀ����Ϊ��"}');
        }
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
	    if($row['key']=='0'){
            exit('{"code":-1,"msg":"�㻹û�п�ͨ�ӿ�Ŷ"}');
	    }if($row['key']!=$key){
            exit('{"code":-2,"msg":"�ܳ״���"}');
	    }else{
	     	$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     	//$danjia=$rs['price']*$row['addprice'];
	     	
       	    if($rs['yunsuan']=="*"){
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    	}elseif($rs['yunsuan']=="+"){
	    		$danjia=round($rs['price']+$row['addprice'],2);
	    	}else{
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    	}
	     	
            if($danjia==0 || $row['addprice']<0.1){
            	exit('{"code":-1,"msg":"���У��ҵ��ﲻ��������С�����⣬���������֮��������������"}');
            } 
        	if($row['money']<$danjia){
	        	exit('{"code":-1,"msg":"����"}');
	        } 	    
               $a=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);
	     		
                    if($a['code']=='1'){
                    	 for($i=0;$i<count($a['data']);$i++){
                    	 	$kcid1=$a['data'][$i]['id'];
                    	 	$kcname1=$a['data'][$i]['name'];
                    	 	similar_text($kcname1,$kcname,$percent);
                    	 	if($percent>"90%"){
        	 	          	    if($rs['yunsuan']=="*"){
						    		$danjia=round($rs['price']*$row['addprice'],2);
						    	}elseif($rs['yunsuan']=="+"){
						    		$danjia=round($rs['price']+$row['addprice'],2);
						    	}else{
						    		$danjia=round($rs['price']*$row['addprice'],2);
						    	}		     
		           	           if($rs['docking']=='0'){
		           	            	$dockstatus='99';
		           	           }else{
		           	           	    $dockstatus='0';
		           	           }	           	           
		           	           $DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,user,pass,kcid,kcname,fees,noun,miaoshua,addtime,ip,dockstatus) values ('{$uid}','{$rs['cid']}','{$rs['docking']}','{$rs['name']}','{$school}','$user','$pass','$kcid1','$kcname1','{$danjia}','{$rs['noun']}','$miaoshua','$date','$clientip','$dockstatus') ");//����Ӧ�γ�д�����ݿ�	               	           	              	           	               
	           	               $DB->query("update qingka_wangke_user set money=money-'{$danjia}' where uid='$uid' limit 1 "); 
                               wlog($row['uid'],"API�������","{$user} {$pass} {$kcname} �۳�{$danjia}Ԫ��",-$danjia);
                               $ok=1;
                               break;
                    	 	}
                           
                    	 }
                    	 if($ok==1){
                    	 	exit('{"code":0,"msg":"�ύ�ɹ�","status":0,"message":"�ύ�ɹ�","id":"�����ŵ�¼��̨���в鿴����������д��"}');
                    	 }else{
                    	 	exit('{"code":-1,"msg":"����������γ�����","status":-1,"message":"����������γ�����"}');
                    	 }
                    	
                    }else{                    	
                    	$result=array("code"=>-1,'msg'=>$a[0]['msg']);
                    	exit(json_encode($result));
                    }
  
                  
       }
  break;
  case 'chadan':
      $username=trim(strip_tags(daddslashes($_POST['username'])));
      
      $id=trim(strip_tags(daddslashes($_REQUEST['oid'])));
      if($username==""){
            if($id == ""){
                $data=array('code'=>-1,'msg'=>"�˺Ų���Ϊ��");
                exit(json_encode($data)); 
            }else if($id == ""){
                $data=array('code'=>-1,'msg'=>"����ID����Ϊ��");
                exit(json_encode($data)); 
            }
              
      }
      
      if($username != ""){
          $a=$DB->query("select * from qingka_wangke_order where user='$username' order by oid asc ");
      }else if($id != ""){
          $a=$DB->query("select * from qingka_wangke_order where oid='$id'");
      }
      if($a){
	       while($row=$DB->fetch($a)){
		   	   $data[]=array(
		   	      'id'=>$row['oid'],
	              'ptname'=>$row['ptname'],
	              'school'=>$row['school'],
	              'name'=>$row['name'],
	              'user'=>$row['user'],
	              'kcname'=>$row['kcname'],
	              'addtime'=>$row['addtime'],
	              'courseStartTime'=>$row['courseStartTime'],
	              'courseEndTime'=>$row['courseEndTime'],
	              'examStartTime'=>$row['examStartTime'],
	              'examEndTime'=>$row['examEndTime'],
	              'status'=>$row['status'],
	              'process'=>$row['process'],
	              'remarks'=>$row['remarks']
		   	   );
		    }
		    $data=array('code'=>1,'data'=>$data);
		    exit(json_encode($data)); 
	    }else{
	    	$data=array('code'=>-1,'msg'=>"δ�鵽���˺ŵ��µ���Ϣ");
		    exit(json_encode($data)); 
	    } 
  break;
  case 'budan':
        $oid=daddslashes($_POST['id']);
		$b=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
		if($b['bsnum']>5){
			exit('{"code":-1,"msg":"�ö�����ˢ�ѳ���5�β�֧���ٴβ�ˢ��"}');
		}
		
        	  $c=budanWk($oid);
        	  if($c['code']==1){
        	      if($b['hid']=='10'){
                        $DB->query("update qingka_wangke_order set status='������',`process`='',`remarks`='',`bsnum`=bsnum+1 where oid='{$oid}' ");
                        jsonReturn(1,"�ɹ����벹ˢ�̣߳��ŶӲ�ˢ��");       
                    }
                    if($b['hid']=='11' || $b['hid']=='12'){
                        $DB->query("update qingka_wangke_order set dockstatus='0',status='����ˢ',`process`='',`remarks`='',`bsnum`=bsnum+1 where oid='{$oid}' ");
                        jsonReturn(1,"��ˢ�ɹ����ȴ������Ϻţ�");
                    }if($b['status']=="���˿�"){
                        jsonReturn(1,"�������˿��޷���ˢ��");
                    }else{
                        $DB->query("update qingka_wangke_order set status='��ˢ��',`bsnum`=bsnum+1 where oid='{$oid}' ");
        	  	        jsonReturn(1,$c['msg']);
                    }
        	  	
        	  }else{
        	  	jsonReturn(-1,$c['msg']);
        	  }          
	   
  break;
   case 'getclass':

        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        $key = trim(strip_tags(daddslashes($_POST['key'])));
        if ($uid == '' || $key == '') {
            exit('{"code":0,"msg":"������Ŀ����Ϊ��"}');
        }
        $userrow = $DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
        if ($userrow['key'] == '0') {
            $result = array("code" => -1, "msg" => "�㻹û�п�ͨ�ӿ�Ŷ");
            exit(json_encode($result));
        } elseif ($userrow['key'] != $key) {
            $result = array("code" => -2, "msg" => "�ܳ״���");
            exit(json_encode($result));
        }

        if ($_REQUEST['cid']) {
            $a = $DB->query("select * from qingka_wangke_class where status=1 and cid = '{$_REQUEST['cid']}' order by sort desc");
        } else {
            $a = $DB->query("select * from qingka_wangke_class where status=1 order by sort desc");
        }
        while ($row = $DB->fetch($a)) {
            if ($row['yunsuan'] == "*") {
                $price = round($row['price'] * $userrow['addprice'], 2);
                $price1 = $price;
            } elseif ($row['yunsuan'] == "+") {
                $price = round($row['price'] + $userrow['addprice'], 2);
                $price1 = $price;
            } else {
                $price = round($row['price'] * $userrow['addprice'], 2);
                $price1 = $price;
            }
            //�ܼ�
            $mijia = $DB->get_row("select * from qingka_wangke_mijia where uid='{$userrow['uid']}' and cid='{$row['cid']}' ");
            if ($mijia) {
                if ($mijia['mode'] == 0) {
                    $price = round($price - $mijia['price'], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia['mode'] == 1) {
                    $price = round(($row['price'] - $mijia['price']) * $userrow['addprice'], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia['mode'] == 2) {
                    $price = $mijia['price'];
                    if ($price <= 0) {
                        $price = 0;
                    }
                }
                $row['name'] = "���ܼۡ�{$row['name']}";
            }
            if ($price >= $price1) { //�ܼۼ۸����ԭ�ۣ��ָ�ԭ��
                $price = $price1;
            }
            $data[] = array(
                'sort' => $row['sort'],
                'cid' => $row['cid'],
                'kcid' => $row['kcid'],
                'name' => $row['name'],
                'noun' => $row['noun'],
                'price' => $price,
                'fenlei' => $row['fenlei'],
                'content' => $row['content'],
                'status' => $row['status'],
                'miaoshua' => $miaoshua
            );
        }
        foreach ($data as $key => $row) {
            $sort[$key]  = $row['sort'];
            $cid[$key] = $row['cid'];
            $kcid[$key] = $row['kcid'];
            $name[$key] = $row['name'];
            $noun[$key] = $row['noun'];
            $price[$key] = $row['price'];
            $info[$key] = $row['info'];
            $content[$key] = $row['content'];
            $status[$key] = $row['status'];
            $miaoshua[$key] = $row['miaoshua'];
        }
        array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
        $data = array('code' => 1, 'data' => $data);
        exit(json_encode($data));
        break;
}
}


?>