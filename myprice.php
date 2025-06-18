<?php
$mod='blank';
$title='价格列表';
require_once('head.php');
?>
	<div class="app-content-body">
	    <div class="wrapper-md control">		
			<div class="row">
				<div class="col-sm-12">
				    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">商品价格</div>
		            <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">    
         		      <div class="table-responsive"> 
				         <table class="table table-striped">
				            
				          <thead><tr><th>ID</th><th>平台名称</th><th>倍数X我的费率</th><th>0.2</th><th>0.3</th><th>0.4</th><th>我的价格（<?php echo $userrow['addprice']?>）</th><th>排序</th></thead>
				          <tbody>				          	
							<?php 
	                     	 $a=$DB->query("select * from qingka_wangke_class where status=1 ");
	                     	 while($rs=$DB->fetch($a)){
	                     	 	  echo "<tr><td>".$rs['cid']."</td>
	                     	 	  	<td>".$rs['name']."</td>
	                     	 	  	<td>(".$rs['price']."倍) X 我的费率</td>
	                     	 	  	<td>".$rs['price']*0.2."</td>
	                     	 	  	<td>".$rs['price']*0.3."</td>
	                     	 	  	<td>".$rs['price']*0.4."</td>
	                     	 	  	<td>".($rs['price']*$userrow['addprice'])."</td>
	                     	 	  	<td>".$rs['sort']."</td>
	                     	 	  	</tr>"; 
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

<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>