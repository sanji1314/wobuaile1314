<?php
$mod='blank';
$title='商品说明';
require_once('head.php');
$fl=$DB->count("select addprice from qingka_wangke_user where uid='{$userrow['uid']}'");
?>
<div class="app-content-body">
	    <div class="wrapper-md control">		
			<div class="row">
				<div class="col-sm-12">
				    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">商品说明</div>
		          <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">    
         		      <div class="table-responsive"> 
				        <table class="layui-hide" id="helplist"></table>
				          <div class="table-responsive">
                                <table class="table table-striped">
        							<thead><tr><th>对接ID</th><th>分类ID</th><th>商品名称</th><th>商品说明</th><th>你的价格</th></thead>
        								<tbody>
        									<?php 
        										$a=$DB->query("select * from qingka_wangke_class where status=1 ");
        										while($rs=$DB->fetch($a)){
        										echo "<tr><td>".$rs['cid']."</td><td>".$rs['fenlei']."</td><td>".$rs['name']."</td><td>".$rs['content']."</td><td>".$rs['price']*$fl."</td></tr>"; 
        										}
        									?>
                                    	</tbody>
        						</table>
                            </div>
                        <script type="text/html" id="helpfy">
				      </div>
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
<script src="assets/layui/layui.js"></script>
