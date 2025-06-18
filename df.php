<?php
$title='巅峰排行榜';
include('head.php');
?>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="icon" href="images/IMG_0118.png" type="image/ico">
<link href="https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="js/bootstrap-multitabs/multitabs.min.css">
<link rel="stylesheet" type="text/css" href="css/animate.min.css">
<link rel="stylesheet" type="text/css" href="css/style.min.css">
</head><link rel="stylesheet" href="assets/css/element.css">
<link rel="stylesheet" href="assets/css/iview.css">
<link rel="stylesheet" href="assets/css/element.css" />
		<body>
	<div class="app-content-body ">
		<div class="wrapper-md control" id="gdlist">
		    <div class="col-sm-12">
      <div class="card">
           <div class="panel-heading font-bold layui-bg-pink" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">巅峰排行榜</div>
                <el-card class="box-card">
	    	    <div class="panel panel-default"> 
                   <div class="table-responsive"> 
                 <table class="table table-striped"
                                 <?php
$query = "SELECT u.uid AS uid, COUNT(o.uid) AS order_count FROM qingka_wangke_order AS o JOIN qingka_wangke_user AS u ON o.uid = u.uid WHERE YEARWEEK(o.addtime, 1) = YEARWEEK(NOW(), 1) GROUP BY o.uid ORDER BY order_count DESC LIMIT 10";
$result = $DB->query($query);
$rank = 1;


?>
<li class="list-group-item"></li>
<ul class="list-group">
    <?php
    while ($row = $DB->fetch($result)) {
        $uid = $row['uid'];
        $orderCount = $row['order_count'];
        echo '<li class="list-group-item">排名: ' . $rank . ' UID: ' . $uid . '（订单数量：' . $orderCount . '单）</li>';
        $rank++;
                          }
                         ?>               
                  </tbody>
                </table>
              </div>
              </div>    
            </div>
        
            </div>
       </div>
    </div>
</div>
<?php require_once("footer.php");?>