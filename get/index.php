<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>自助售后</title>
		<link rel="icon" href="./favicon.ico" type="image/ico">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes" />
		<link rel="stylesheet" href="assest/element/index.css">
	</head>
	<body>
		<div id="ck">
			<el-card type="border-card" :xs="24" :sm="12" :md="12" v-loading="loading">
				<el-row :gutter="20">
					<el-col :span="20">
						<div style="min-height: 36px;">
							<el-input placeholder="请输入账号" v-model="user"></el-input>
						</div>
					</el-col>
					<el-col :span="4">
						<div style="min-height: 36px;">
							<el-button @click="get()" type='primary' size='medium'>
								<i class="el-icon-search"></i>
							</el-button>
						</div>
					</el-col>
				</el-row>
			</el-card>
			<br>
			<el-card type="border-card" :xs="24" :sm="12" :md="12" v-for="res in row.data">
				<span>[平台名称] {{res.ptname}}</span><br><br>
				<span>[课程名称] {{res.kcname}}</span><br><br>
				<span>[订单状态] {{res.status}}</span><br><br>
				<el-progress :text-inside="true" :stroke-width="20" :percentage="res.process"></el-progress><br>
				<span>[详情进度] {{res.remarks}}</span><br><br>
				<span>[提交时间] {{res.addtime}}</span><br><br>
				<span>[课程操作] &nbsp;&nbsp;
				<el-button type='primary' @click="tborder(res.id)">同步订单</el-button>&nbsp;&nbsp;&nbsp;&nbsp;
				<el-button type='primary' @click="bsorder(res.id)">补刷订单</el-button></span>
			</el-card>
		</div>
		<script src="assest/js/vue.min.js"></script>
		<script src="assest/js/vue-resource.min.js"></script>
		<script src="assest/element/index.js"></script>
		<script src="assest/js/jquery.min.js"></script>
		<script>
			var vm = new Vue({
				el: "#ck",
				data: {
					user: "",
					loading: false,
					row: ""
				},
				methods: {
					get: function() {
						this.loading = true;
						this.$http.post("/get/ajax.php?act=get", {
							user: this.user
						}, {
							emulateJSON: true
						}).then(function(data) {
							this.loading = false;
							if (data.data.code == 1) {
								this.$message({
									message: data.data.msg,
									type: 'success'
								});
								this.row = data.body;
							} else {
								this.$message({
									message: data.data.msg,
									type: 'error'
								});
							}
						});
					},
					tborder: function(id) {
						this.loading = true;
						this.$http.post("/get/ajax.php?act=tborder", {
							id: id
						}, {
							emulateJSON: true
						}).then(function(data) {
							this.loading = false;
							if (data.data.code == 1) {
								this.$message({
									message: data.data.msg,
									type: 'success'
								});
								this.get(this.user);
							} else {
								this.$message({
									message: data.data.msg,
									type: 'error'
								});
							}
						});
					},
					bsorder: function(id) {
						this.loading = true;
						this.$http.post("/get//ajax.php?act=bsorder", {
							id: id
						}, {
							emulateJSON: true
						}).then(function(data) {
							this.loading = false;
							if (data.data.code == 1) {
								this.$message({
									message: data.data.msg,
									type: 'success'
								});
								this.get(this.user);
							} else {
								this.$message({
									message: data.data.msg,
									type: 'error'
								});
							}
						});
					}
				}
			});
		</script>
	</body>
</html>