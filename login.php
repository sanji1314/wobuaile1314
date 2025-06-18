<?php
include('../confing/common.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?=$conf['sitename']?></title>
    <meta name="keywords" content="<?=$conf['keywords'];?>"/>
    <meta name="description" content="<?=$conf['description'];?>"/>
    <link rel="stylesheet" href="../assets/layui/css/layui.css"/>
<style>
* {
	margin: 0;
	padding: 0;
}

input {
	outline: none;
}

body {
            background-image: url("../bjt.jpg");-webkit-background-size: cover
            background-repeat: no-repeat;
            display: flex;
            background-size: cover;
            align-items: center;
	        justify-content: center;
            min-height: 100vh;
            
        }

.form-box {
	width: 320px;
	height: auto;
	box-shadow: 0 0 8px #eeeeee;
	background-color: #fff;
	padding: 14px 20px;
	border-radius: 3px;
	margin-bottom: 20px;
}
h1 {
	color: #1E9FFF;
	font-size: 25px;
	font-weight: bold;
	text-align: center;
	padding: 14px 0;
	letter-spacing: 2px;
	margin-bottom: 15px;
}
.text-box,.pass-box {
	width: 310px;
	height: 36px;
	display: flex;
	justify-content: space-between;
	padding-left: 10px;
	border: 1px solid #e6e6e6;
	margin-bottom: 15px;
	transition: 0.3s;
	border-radius: 2px;
}
i {
	line-height: 36px;
	color: #969696;
}
.text,.pass {
	width: 285px;
	height: 36px;
	border-radius: 2px;
	border: none;
}
.text-box:focus,.pass-box:focus,.text-box:hover,.pass-box:hover {
	border-color: #C9C9C9;
}
.denglu {
	width: 100%;
	height: 38px;
	border: none;
	background-color: #1E9FFF;
	color: #fff;
	margin-bottom: 25px;
	transition: 0.3s;
	border-radius: 2px;
}
.denglu:hover,.denglu:focus,.dl:hover,.dl:active,.zc:hover,.zc:active {
	opacity: 0.8;
	cursor: pointer;
}
.fenlei {
	width: 100%;
	height: 21px;
}
.fenlei>span {
    display: block;
    color: #1E9FFF;
    float: right;
}
.fenlei>span:hover {
    cursor: pointer;
    opacity: 0.8;
}
.mar {
	margin-bottom: 25px;
}
@media screen and (max-width:380px) {
    .box {
        width: 100%;
    }
    .form-box {
        margin: 0 auto;
        width: 80%;
        padding-left: 5%;
        padding-right: 5%;
        /*margin: 0 !important;*/
        /*margin-right: 0;*/
    }
    .text-box,.pass-box {
        width: 100%;
        padding-left: 2%;
    }
    .text,.pass {
        width: 90%;
    }
}

    </style>
		
		
		
	</head>
	<body>
		<div class="box">
			<div class="form-box" id="login1">
				<h1><?=$conf['sitename']?><span id="dh"></span></h1>
				<form class="login" id="form-dl">
					<div class="text-box">
						<i class="layui-icon layui-icon-username"></i>
						<input class="text" type="text" id="zhanghao" placeholder="请输入账号" v-model="dl.user" />
					</div>
					<div class="pass-box mar">
						<i class="layui-icon layui-icon-password"></i>
						<input class="pass" type="password" placeholder="请输入密码" v-model="dl.pass" />
					</div>
					<button type="button" class="denglu" @click="login">登 录</button>
				</form>
				<div class="login" id="form-zc" style="display: none;">
					    <div class="text-box">
						<i class="layui-icon layui-icon-release"></i>
						<input class="text" type="text" placeholder="昵称" v-model="reg.name" />
					</div>
					<div class="text-box">
						<i class="layui-icon layui-icon-username"></i>
						<input class="text" type="number" placeholder="账号（账号必须为QQ号）" v-model="reg.user" />
					</div>
					<div class="pass-box">
						<i class="layui-icon layui-icon-password"></i>
						<input class="pass" type="password" placeholder="密码" v-model="reg.pass" />
					</div>
					<div class="text-box mar">
						<i class="layui-icon layui-icon-link"></i>
						<input class="text" type="text" placeholder="邀请码" v-model="reg.yqm" />
					</div>
					<button type="submit" class="denglu" @click="register">立 即 注 册</button>
				</div>
			
			<div class="fenlei">
				<span class="dl" style="display: none">返回登录</span>
				<span class="zc">注册账号</span>
				<li > 
                        <a href="mzsm">《免责说明使用条款》</a> 
                    </li>
				</div> 
		</div>
	</body>
	<script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
    <script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
    <script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
    <script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
	
	<script>
		var vm = new Vue({
			el: "#login1",
			data: {
				loginType: true,
				title: "你在看什么呢？我写的代码好看吗",
				dl: {},
				reg: {}
			},
			methods: {
				newlogin: function() {
					this.loginType = !this.loginType
				},
				login: function() {
					if (!this.dl.user || !this.dl.pass) {
						layer.msg('账号密码不能为空', {
							icon: 2
						});
						return
					}
					
					// 添加前端输入验证
					if (this.dl.user.length > 32 || /['"\(\)\[\]\{\}<>\/\\]/.test(this.dl.user)) {
						layer.msg('用户名包含非法字符', {
							icon: 2
						});
						return
					}
					
					var loading = layer.load();
					vm.$http.post("/apisub.php?act=login", {
						user: this.dl.user,
						pass: this.dl.pass
					}, {
						emulateJSON: true
					}).then(function(data) {
						layer.close(loading);
						if (data.data.code == 1) {
							layer.msg(data.data.msg, {
								icon: 1
							});
							setTimeout(function() {
								window.location.href = "index.php"
							}, 1000);
						} else if (data.data.code == 5) {
							vm.login2();
						} else {
							layer.msg(data.data.msg, {
								icon: 2
							});
						}
					});

				},
				register: function() {
					if (!this.reg.user || !this.reg.pass || !this.reg.name || !this.reg.yqm) {
						layer.msg('所有项不能为空', {
							icon: 2
						});
						return
					}
					
					// 添加前端输入验证
					if (this.reg.user.length > 32 || /['"\(\)\[\]\{\}<>\/\\]/.test(this.reg.user)) {
						layer.msg('账号包含非法字符', {
							icon: 2
						});
						return
					}
					
					if (this.reg.name.length > 32 || /['"\(\)\[\]\{\}<>\/\\]/.test(this.reg.name)) {
						layer.msg('昵称包含非法字符', {
							icon: 2
						});
						return
					}
					
					var loading = layer.load();
					this.$http.post("/apisub.php?act=register", {
						name: this.reg.name,
						user: this.reg.user,
						pass: this.reg.pass,
						yqm: this.reg.yqm
					}, {
						emulateJSON: true
					}).then(function(data) {
						layer.close(loading);
						if (data.data.code == 1) {
							this.loginType = true;
							this.dl.user = this.reg.user;
							this.dl.pass = this.reg.pass;
							layer.msg(data.data.msg, {
								icon: 1
							});
						} else {
							layer.msg(data.data.msg, {
								icon: 2
							});
						}
					});
				},
				login2: function() {
					layer.prompt({
						title: '管理二次验证',
						formType: 3
					}, function(pass2, index) {
						var loading = layer.load();
						vm.$http.post("/apisub.php?act=login", {
							user: vm.dl.user,
							pass: vm.dl.pass,
							pass2: pass2
						}, {
							emulateJSON: true
						}).then(function(data) {
							layer.close(loading);
							if (data.data.code == 1) {
								layer.msg(data.data.msg, {
									icon: 1
								});
								setTimeout(function() {
									window.location.href = "index.php"
								}, 1000);
							} else {
								layer.msg(data.data.msg, {
									icon: 2
								});
							}
						});
					});
				}
			}
		});

		$('#connect_qq').click(function() {
			var ii = layer.load(0, {
				shade: [0.1, '#fff']
			});
			$.ajax({
				type: "POST",
				url: "../apisub.php?act=connect",
				data: {},
				dataType: 'json',
				success: function(data) {
					layer.close(ii);
					if (data.code == 0) {
						window.location.href = data.url;
					} else {
						layer.alert(data.msg, {
							icon: 7
						});
					}
				}
			});
		});
	</script>
	<script type="text/javascript">
		let dl = document.getElementsByClassName('dl')[0];
		let zc = document.getElementsByClassName('zc')[0];
		let dh = document.getElementById('dh');
		let formdl = document.getElementById('form-dl');
		let formzc = document.getElementById('form-zc');
		dh.innerHTML = '登录'
		dl.onclick = ()=> {
			dh.innerHTML = '登录';
			formdl.style.display = 'block';
			formzc.style.display = 'none';
// 			dl.style.boxShadow = '0 0 5px #eeeeee';
// 			zc.style.boxShadow = 'none';
            dl.style.display = 'none';
            zc.style.display = 'block';
		};
		zc.onclick = ()=> {
			dh.innerHTML = '注册';
			formzc.style.display = 'block';
			formdl.style.display = 'none';
// 			zc.style.boxShadow = '0 0 5px #eeeeee';
// 			dl.style.boxShadow = 'none';
			zc.style.display = 'none';
            dl.style.display = 'block';
		};
	</script>