<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/confing/common.php');
$uid = isset($_GET['id']) ? $_GET['id'] : null;
$userrow = $DB->get_row("SELECT paydata, touristdata FROM qingka_wangke_user WHERE uid = '{$uid}' LIMIT 1");
$paydata = json_decode($userrow['paydata'], true);
$defaultData = json_decode($DB->get_row("SELECT touristdata FROM qingka_wangke_user WHERE uid = '1' LIMIT 1")["touristdata"], true);
$decodedData = json_decode($userrow['touristdata'], true);
$siteName = empty($decodedData["sitename"]) ? $defaultData["sitename"] : $decodedData["sitename"];
?>
<head>
    <meta charset="utf-8">
    <title><?php echo $siteName; ?></title>
    <meta name="keywords" content="<?= $conf['keywords']; ?>" />
    <meta name="description" content="<?= $conf['description']; ?>" />
    <link rel="stylesheet" href="/assets/css/tongyu.css" />
    <link rel="stylesheet" href="/assets/layui/css/layui.css" />
    <script src="/assets/js/aes.js"></script>
    <script src="/index/assets/layui/layui.js"></script>
<!--layui-->
<link rel="stylesheet" href="/assets/toc/layui.min.css?v=2.9.18&sv=<?= $conf['version'] ?>" media="all">
<script src="/assets/toc/layui.min.js?v=2.9.18&sv=<?= $conf['version'] ?>"></script>
<!--Vue3-->
<script src="/assets/toc/vue3.min.js?sv=<?= $conf['version'] ?>"></script>
<!--element-plus-->
<link href="/assets/toc/element-plus.min.css?sv=<?= $conf['version'] ?>" rel="stylesheet">
<script src="/assets/toc/element-plus.min.js?sv=<?= $conf['version'] ?>"></script>
<script src="/assets/toc/element-plus_icons-vue.min.js?sv=<?= $conf['version'] ?>"></script>
<!--axios-->
<script src="/assets/toc/axios.min.js?v=1.7.7&sv=<?= $conf['version'] ?>"></script>
<script src="/assets/toc/axios_toc.min.js?sv=<?= $conf['version'] ?>"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>
<body id="onlineStoreBody">
    <div id="app" style="display:none;">
        <div class="layui-panel" style="max-width: 700px; margin: 20px auto; border-radius: 10px; opacity: 0.88;">
            <div v-if="v_ok===0" class="layui-padding-3">
                当前用户接单商城未开启哦~
            </div>
            <div v-else style="min-height: 50vh;">
        <div class="layui-padding-3" style="text-align: center;">
    <h3 class="title rainbow-text">{{webConfig.sitename}}</h3>
    <div id="current-time" style="font-size: 12px; margin: 0; line-height: 1;"></div>
   <hr>
</div>
<div style="text-align: center; margin: 0 0; border: 1px solid #e0e0e0; border-radius: 10px; padding: 0; overflow-x: auto; white-space: nowrap; max-width: 90%; margin-left: auto; margin-right: auto;">
    <a href="https://passport2.chaoxing.com/login?fid=&newversion=true&refer=https%3A%2F%2Fi.chaoxing.com" target="_blank" style="display: inline-block; margin: 0;">
        <img src="1.png" alt="学习通" style="width: 50px; height: auto; display: block;">
    </a>
    <a href="https://passport.zhihuishu.com/login?service=https://onlineservice-api.zhihuishu.com/gateway/f/v1/login/gologin" target="_blank" style="display: inline-block; margin: 0;">
        <img src="2.png" alt="知到/智慧树" style="width: 50px; height: auto; display: block;">
    </a>
    <a href="https://sso.unipus.cn/sso/login?service=https%3A%2F%2Fu.unipus.cn%2Fuser%2Fcomm%2Flogin%3Fschool_id%3D" target="_blank" style="display: inline-block; margin: 0;">
        <img src="3.png" alt="U校园" style="width: 50px; height: auto; display: block;">
    </a>
    <a href="https://www.icve.com.cn/" target="_blank" style="display: inline-block; margin: 0;">
        <img src="4.png" alt="智慧职教" style="width: 50px; height: auto; display: block;">
    </a>
    <a href="https://www.xuexi.cn/index.html" target="_blank" style="display: inline-block; margin: 0;">
        <img src="5.png" alt="学习强国" style="width: 50px; height: auto; display: block;">
    </a>
    <a href="https://www.xuexi.cn/index.html" target="_blank" style="display: inline-block; margin: 0;">
        <img src="6.png" alt="学习强国" style="width: 50px; height: auto; display: block;">
    </a>
</div>
<hr style="margin-top: 4px; margin-bottom: 4px;">
<div class="layui-padding-3">
    <el-alert class="custom-notice" type="warning" :title="webConfig.notice"></el-alert>
</div>
                <div class="layui-tab layui-tab-brief layui-padding-2" lay-filter="test-hash" style="margin: 0;">
                    <ul class="layui-tab-title">
                        <li class="layui-this" lay-id="11">在线下单</li>
                        <li lay-id="22">进度查询</li>
                        <li lay-id="33">帮助文档</li>
                    </ul>
                    <div class="layui-tab-content" style="margin-bottom:0;padding:0">
                        <div class="layui-tab-item layui-show">
                            <div class="layui-form-item" style="display: flex; align-items: center; margin-top: 20px;">
    <label class="col-sm-2 control-label" style="margin-right: 10px; white-space: nowrap;">分类</label>
    <el-select id="fenleiSelect" v-model="fid" @change="fenlei(fid)" popper-class="lioverhide" filterable placeholder="请选择分类" style="width:100%;">
        <el-option value="" label="全部分类"></el-option>
        <el-option v-for="item in fllist.data" :key="item.id" :label="item.name" :value="item.id"></el-option>
    </el-select>
</div>
                            <div class="layui-form-item" style="display: flex; align-items: center;">
                                <label class="col-sm-2 control-label" style="margin-right: 10px; white-space: nowrap;">平台</label>
                                <el-select id="select" v-model="cid" @change="tips(cid)" popper-class="lioverhide" filterable placeholder="宝～先来看看项目，支持搜索" style="width:100%;">
                                    <el-option v-for="class2 in class1" :key="class2.cid" :label="class2.name+'('+class2.price+'元)'" :value="class2.cid">
                                        <div style="display: flex; justify-content: space-between; align-items: center; position: relative;">
                                            <span style="overflow-x: auto; white-space: nowrap;">{{ class2.name }}</span>
                                            <span style="float: right; font-size: 13px">{{ Number(class2.price).toFixed(2) }}元</span>
                                        </div>
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="layui-form-item" style="display: flex; align-items: center;">
                                <label class="col-sm-2 control-label" style="margin-right: 10px; white-space: nowrap;">学校</label>
                                <input type="text" v-model="userinfo2.school" placeholder="请输入学校（这个随便写）" class="layui-input" style="border-radius: 8px; flex-grow: 1;height: 35px;">
                            </div>
                            <div class="layui-form-item" style="display: flex; align-items: center;">
                                <label class="col-sm-2 control-label" style="margin-right: 10px; white-space: nowrap;">账号</label>
                                <input type="text" v-model="userinfo2.user" placeholder="账号为学号或手机号" class="layui-input" style="border-radius: 8px; flex-grow: 1;height: 35px;">
                            </div>
                            <div class="layui-form-item" style="display: flex; align-items: center;">
                                <label class="col-sm-2 control-label" style="margin-right: 10px; white-space: nowrap;">密码</label>
                                <input type="text" v-model="userinfo2.pass" placeholder="请输入密码" class="layui-input" style="border-radius: 8px; flex-grow: 1;height: 35px;">
                            </div>
                        <div class="" v-if="!xdsmopen">
    <fieldset class="layui-elem-field" v-if="content" style="background-color: #e8f0fe;">
        <legend style="width: auto; font-size: 14px; border-bottom: 0; margin-bottom: 0; color: #333;">说明</legend>
        <div class="layui-field-box" style="padding-top: 5px;">
            <pre v-html="content" style="color: #333;"></pre>
        </div>
    </fieldset>
</div>
                            <div style="margin-bottom:10px; text-align: center;" v-if="!noInfo">
                                <el-button style=" background-color: #409eff; border-color: #409eff;color: white;" @click="get" value="查询课程" class="el-button"/>&nbsp;查课</el-button>
                                <el-button style=" background-color: #409eff; border-color: #409eff;color: white;" :class="nochake != 1 ? 'layui-btn-disabled' : ''" @click="add" value="提交订单"/>&nbsp;提交</el-button>
                            </div>
                            <div v-show="row.length" class="form-horizontal devform" style="margin-bottom:10px;" id="resultBox">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div v-for="(rs, rs_key) in row" :key="rs_key" class="panel panel-default" style="opacity: 0.88;">
                                        <el-divider><span style="color:#909399">选 择 课 程</span></el-divider>
                                        <div style="display: flex; justify-content: space-between; font-weight: bold; margin-bottom: 10px;">
                                            <div class="layui-input-block" style="width: 55px; margin-left: 0">
                                                <input type="checkbox" 
                                                       @change="selectAll(rs_key)" 
                                                       :checked="isAllSelected(rs.data, rs.userinfo)"
                                                       :data-key="rs_key"/>
                                            </div>
                                            <div style="flex: 1; text-align: center;">课程名字</div>
                                            <div style="width: 80px; text-align: center;">课程ID</div>
                                        </div>
                                        <div style="border-bottom: 1px solid #ddd; margin-bottom: 10px;"></div>
                                        <div class="panel-body" style="max-height: 300px; overflow-y: auto; opacity: 1; padding: 0;">
                                            <div v-for="(res, res_key) in rs.data" :key="res_key" style="display: flex; justify-content: space-between; align-items: center; padding: 5px 0;margin-left: 0" class="layui-input-block">
                                                <input type="checkbox" 
                                                       :id="'checkbox_' + res_key" 
                                                       name="checkbox" 
                                                       class="chk_class" 
                                                       @change="checkResources(rs.userinfo, rs.userName, rs.data, res.name, res.id, res.state)" 
                                                       :value="res.id" 
                                                       :checked="isChecked(res, rs.userinfo)"
                                                       :disabled="/错误|异常|失败/.test(res.name)||/错误|异常|失败/.test(res.id)||/错误|异常|失败/.test(res.msg)" 
                                                       style="margin-right: 10px;"/>
                                                <span style="flex: 1; text-align: center;">{{ res.name }}</span>
                                                <span style="width: 80px; text-align: center; overflow-x: auto; white-space: nowrap;">
                                                    {{ res.id ? res.id : '无ID' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-weight: bold;font-size: 13px;color:#ff0000be;text-align: center;margin-top:10px;margin-bottom:-10px;">
                                    <span v-if="check_row.length == 0">
                                        请选择课程
                                    </span>
                                    <span v-else>
                                        已选择 {{check_row.length}} 门课程，
                                    </span>
                                    订单金额： <span>{{money}} 元</span>
                                </div>
                            </div>
                        </div>
                    <div class="layui-tab-item">
<div class="mainBox">
    <div class="searchBox">
        <div class="layui-input-group">
            <input v-model="user" type="text" lay-affix="clear" placeholder="请输入下单账号..." class="layui-input">
            <div class="layui-input-split layui-input-suffix" style="cursor: pointer; height: 40px; line-height: 40px; display: flex; align-items: center; justify-content: center;" @click="query()">
                <i class="layui-icon layui-icon-search" style="font-size: 20px; line-height: 40px;"></i>
            </div>
        </div>
    </div>
   <div v-for="(res, index) in orderList" :key="index" class="layui-panel" style="margin-top: 10px; margin-bottom: 10px; padding: 25px;">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 0 10px;">
        <h4>{{ res.kcname }}</h4>
        <span class="layui-badge layui-bg-blue">{{ c_ptname(res.ptname) }}</span>
    </div>
    <hr />
    <table class="layui-table" lay-even>
        <colgroup>
            <col width="60">
            <col width="150">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <td>状态</td>
                <td>
                    <div style="display: flex; align-items: center;">
                        <span>{{ res.status }}</span>
                        <button class="budan-btn" @click="budan(res.id)">补刷</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>下单时间</td>
                <td>{{ res.addtime }}</td>
            </tr>
            <tr>
                <td>学校</td>
                <td>{{ res.school }}</td>
            </tr>
            <tr>
                <td>参考进度</td>
                <td>
                    <div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="progress-filter">
                        <div class="layui-progress-bar layui-bg-green" :style="{ width: process_num(res.process, res.remarks) + '%' }">
                            <span class="layui-progress-text">{{ process_num(res.process, res.remarks) }}%</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>日志</td>
                <td>已完成：{{ res.remarks ? res.remarks : process_num(res.process, res.remarks) }}%</td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
                        <div class="layui-tab-item">
                            <el-collapse accordion>
                                <el-collapse-item title="学习通" name="1">
                                    <div>建议下普通版本或者慢刷，快刷容易被清进度，24小时不停学习大概率被官方清理进度，清进度补刷即可。<br>
                                         不要多渠道一起下单。</div>
                                </el-collapse-item>
                                <el-collapse-item title="智慧树" name="2">
                                    <div>慢刷15天左右，期间尽量不要登陆，不登陆就不会异常，否则异地IP登录大概率异常<br>
                                    快速当天完成，无习惯分。</div>
                                </el-collapse-item>
                                <el-collapse-item title="U校园" name="3">
                                    <div>由于官方原因，时长和分数会延时到账
                                                                        具体表现：平台显示0分0时长，上号学习记录页面也无分数时长，但任务点变绿，等待即可。</div>
                                </el-collapse-item>
                                <el-collapse-item title="词达人" name="4">
                                    <div>词达人下单后用户不要打开词达人查看，静等刷完，不然token会秒过期导致失效。</div>
                                </el-collapse-item>
                            </el-collapse>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" id="pay2" style="display: none;padding:5px 5px 10px;text-align:center">
            <div>
                <center style="margin:15px;">
                    <h1 style="font-size :44px;">￥{{money}}</h1>
                </center>
            </div>
            <div style="display: flex; justify-content: center;">
                <?php
                $paydata = json_decode($userrow['paydata'], true);
                if ($paydata) {
                    if ($paydata['is_alipay'] == 1) {
                        ?>
                        <button @click="payGo('alipay')" type="radio" name="type" value="alipay" class="layui-btn layui-bg-blue" style="width: 80px;">支付宝</button><br>
                        <?php
                    }
                    if ($paydata['is_qqpay'] == 1) {
                        ?>
                        <button @click="payGo('qqpay')" type="radio" name="type" value="qqpay" class="layui-btn layui-bg-orange" style="width: 80px;">QQ</button><br>
                        <?php
                    }
                    if ($paydata['is_wxpay'] == 1) {
                        ?>
                        <button @click="payGo('wxpay')" type="radio" name="type" value="wxpay" class="layui-btn" style="width: 80px;">微信</button><br>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script src="/assets/js/jquery.min.js"></script>
<script>
    const app = Vue.createApp({
        data(){
            return{
                window: window,
    			uid: "",
                webConfig: {
                    sitename: '',
                    notice: '',
                },
    			payOpen: null,
    			money: 0,
    			orderList: [],
                user: '',
    			payMethods: [],
    			out_trade_no: "",
    			fid: '',
    			fids: [],
    			row: [],
    			shu: '',
    			bei: '',
    			nochake: 0,
    			check_row: [],
    			userTypeID: '11', // 账号模式
    			userinfo: '', // 批量账号模式
    			userinfo2: { // 单个输入框模式
    				school: '',
    				user: '',
    				pass: ''
    			},
    			cid: '',
    			miaoshua: '',
    			class1: '',
    			class3: '',
    			fid: '',
    			fllist: { data: [] },
    			activems: false,
    			checked: false,
    			content: '',
    			noInfo: false,
    			has_getnoun: false,
    			user_money: 0,
    			xdsmopen: 0,
    			loadTime: 0, // 查课加载时间
    			user_use_money: 0,
    			useMoneyAnim: false, // 扣费动画
    			cesyix: "asdasd",
    			v_ok: 0,
            }
        },
		computed: {
			active_rs_key() {
			    const _this = this;
				let active_rs_key_Data = [];
				for (let i in _this.row) {
					active_rs_key_Data.push(Number(i));
				}
				return active_rs_key_Data
			},
		},
		mounted() {
			const _this = this;

			const urlParams = new URLSearchParams(window.location.search);
			_this.uid = urlParams.get('id') ? urlParams.get('id') : 1;
			
			// 处理支付返回状态
			const paymentStatus = urlParams.get('payment_status');
			const paymentMsg = urlParams.get('msg');
			if (paymentStatus) {
				if (paymentStatus === 'success') {
					layer.msg(paymentMsg || '支付成功！', {icon: 1});
				} else if (paymentStatus === 'error') {
					layer.msg(paymentMsg || '支付失败！', {icon: 2});
				}
				// 清除URL中的支付参数，避免刷新页面重复显示消息
				const newUrl = window.location.pathname + '?id=' + _this.uid;
				window.history.replaceState({}, document.title, newUrl);
			}

            let loadIndex = layer.load(0);
			$("#app").ready(() => {
			    layer.close(loadIndex);
				$("#app").show();
				_this.v_ok_f();
				_this.fenleiGet();

				layui.element.on('tab(userType)', function(data) {
					let layId = this.getAttribute("lay-id");
					if (_this.userTypeID === layId) {
						return
					}
					_this.userTypeID = layId;
					_this.calculateTotalAmount();

					_this.userinfo = '';
					for (let i in _this.userinfo2) {
						_this.userinfo2[i] = '';
					}

					if (layId === '11') {

					} else if (layId === '22') {

					}
				});
			})
			layui.use(function() {
				var util = layui.util;
				// 自定义固定条
				util.fixbar({
					margin: 100
				})

				var element = layui.element;
				var hashName = 'tabid'; // hash 名称
				var layid = location.hash.replace(new RegExp('^#' + hashName + '='), ''); // 获取 lay-id 值

				// 初始切换
				element.tabChange('test-hash', layid);
				// 切换事件
				element.on('tab(test-hash)', function(obj) {
					location.hash = hashName + '=' + this.getAttribute('lay-id');
				});

			})

			window.touristPageVue = _this;

		},
		methods: {
		   normalizeProcess(process) {
        // 去除多余的百分号
        if (typeof process === 'string') {
            process = process.replace(/%{2,}/g, '%'); // 替换多个连续的 % 为一个 %
        }

        // 确保 process 是一个数字
        const numericProcess = parseFloat(process);
        if (isNaN(numericProcess)) {
            return '0%'; // 如果不是数字，返回 0%
        }

        // 确保进度值在 0% 到 100% 之间
        const clampedProcess = Math.max(0, Math.min(100, numericProcess));

        return `${clampedProcess}%`; // 返回格式化的进度值
    },
			returnMethod: function(type, msg) {
				const _this = this;
				if (type) {
					layer.closeAll();
				}
				layer.msg(msg);
			},
			qingli: function() {
				vm.check_row = [];
			},
            kcData_adapter :function(data){
                switch (true) {
                    case data.data.courseList instanceof Array:
                        let courseList = data.data.courseList;
                        data.data =[];
                        data.data =courseList;
                        console.log('asd',data.data);
                        for(let i in data.data){
                            data.data[i].name =  data.data[i].Title;
                            delete data.data[i].Title;
                            data.data[i].id =  data.data[i].CourseId;
                            delete data.data[i].CourseId;
                        }

                        break;
                    default:
                        console.log('开始数据适配')
                        for (let i in data) {
                            if (data[i] instanceof Array) {
                                data.data = data[i];
                                    console.log('匹配到数组',data.data,i)
                                if(i !== 'data'){delete data[i];}
                                for (let j in data.data) {
                                    // 课程名称 Key适配
                                    if (data.data[j].name) {
                                    }else if(data.data[j].label){
                                        data.data[j].name = data.data[j].label;
                                        delete data.data[j].label
                                    }else if(data.data[j].courseName){
                                        data.data[j].name = data.data[j].courseName;
                                        delete data.data[j].courseName
                                    }
                                    // 课程ID Key适配
                                    if(data.data[j].id){
                                        
                                    }else if(data.data[j].courseId){
                                        data.data[j].id = data.data[j].courseId;
                                        delete data.data[j].courseId
                                    }
                                }
                                break;
                            }
                        }
                        break;
                }
                return data;
            },
			get: async function(salt) {
				const _this = this;
				vm.qingli();
				_this.nochake = 0;

				// 如果没选择商品
				if (_this.cid == '') {
					layer.msg("请选择平台");
					return false;
				}

				// 单账号
				if (_this.userTypeID === '11') {
					if (!_this.userinfo2.user || !_this.userinfo2.pass) {
						layer.msg("请完善账号");
						return false;
					}
				} else {
					// 多账号
					if (_this.userinfo == '') {
						layer.msg("请完善账号");
						return false;
					}
				}

				if (_this.userTypeID === '11') {
					userinfo = `${_this.userinfo2.school} ${_this.userinfo2.user} ${_this.userinfo2.pass}`
				} else {
					userinfo = _this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");
				}
				userinfo = userinfo.split('[br]'); //分割
				userinfo = userinfo.filter(item => item !== '');

				_this.row = [];
				_this.check_row = [];

				var loadIndex = layer.msg('查课中，第1条...', {
					icon: 16,
					shade: 0.01,
					time: 0,
					tipsMore: true
				});
				_this.loadTime = 0;
				const startTime = new Date().getTime();
				for (var i = 0; i < userinfo.length; i++) {
					var info = userinfo[i];
					if (info === '') {
						continue;
					}
					var hash = getENC('<?php echo $addsalt; ?>');

					try {
                        let response = await axios.post("/api/tourist.php?act=get", {
                            cid: _this.cid,
                            userinfo: info,
                            hash
                        }, {
                            emulateJSON: true
                        });


                        let data = response.data; // 或根据实际情况调整访问响应数据的方式
                        _this.nochake = 1;

                        if (data.code == -7) {
                            let salt = getENC(data.msg);
                            // 注意：这里假设 vm.get(salt) 也返回 Promise，如果不是异步函数需要相应调整
                            await _this.get(salt);
                        } else if (data.code == -1) {
                            let msg = data.msg?(data.msg.msg ? data.msg.msg : data.msg):data.message;
                            layer.msg(msg);
                        } else {
                            layer.msg(data.msg);
                            console.log('3',data)
                            data = await _this.kcData_adapter(data);
                            
                            // 再次解析.解析数据不存在的时候
                            if(!data.data || !data.data.length){
                            console.log('4',data)
                                data.data=[{name:'异常,请重试1'}]
                            }
                            vm.row.push(data);

                            setTimeout(() => {
                                layui.form.render();
                            }, 0)

                            loadIndex = layer.msg('查课中，第' + (i + 2) + '条...', {
                                icon: 16,
                                shade: 0.01,
                                time: 0,
                                tipsMore: true
                            });

                            // 最后一个
                            if (i === userinfo.length - 1) {
                                //  llayer.closeAll(); // 关闭加载动画
                                layer.close(loadIndex); // 关闭加载动画
                                setTimeout(() => {
                                    layui.form.on('checkbox(demo-checkbox-filter)', function(data) {
                                        var elem = data.elem; // 获得 checkbox 原始 DOM 对象
                                        var checked = elem.checked; // 获得 checkbox 选中状态
                                        var value = elem.value; // 获得 checkbox 值
                                        var othis = data.othis; // 获得 checkbox 元素被替换后的 jQuery 对象
                                        let dataset_data = JSON.parse(elem.dataset.data);
                                        console.log(24, dataset_data)
                                        _this.checkResources(dataset_data.rs.userinfo, dataset_data.rs.userName, dataset_data.rs.data, dataset_data.res.name, dataset_data.res.id, dataset_data.res.state);

                                    });

                                    if ($(document).width() < 750) {
                                        console.log($('#resultBox').offset().top)
                                        $(document).scrollTop($('#resultBox').offset().top - 100);
                                    }

                                    // 监听全选
                                    layui.form.on('checkbox(selectAll)', function(data) {
                                        let userKey = data.elem.dataset.key
                                        let child = $(`.checkboxC${userKey}`)
                                        child.each(function(index, item) {
                                            item.checked = data.elem.checked;
                                        });
                                        layui.form.render('checkbox');

                                        if (data.elem.checked) {
                                            userinfo = _this.row[userKey].userinfo
                                            userName = _this.row[userKey].userName
                                            rs = _this.row[userKey].data ?_this.row[userKey].data: _this.row[userKey].children
                                            for (a = 0; a < rs.length; a++) {
                                                aa = rs[a]
                                                data = {
                                                    userinfo,
                                                    userName,
                                                    data: aa
                                                }
                                                vm.check_row.push(data);
                                            }
                                        } else {
                                            vm.check_row = [];
                                        }
                                    })

                                }, 0)

                                const endTime = new Date().getTime();
                                _this.loadTime = (endTime - startTime) / 1000;
                                layer.msg('查询成功');
                            }

                        }
                    } catch (error) {
                        console.error("请求处理异常", error);
                        // 错误处理
                    }
				}

				// layer.close(loadIndex); // 关闭加载动画

			},
			calculateTotalAmount: function() {
    // 获取当前选择的商品单价
    const selectedClass = this.class1.find(item => item.cid === this.cid);
    const pricePerCourse = selectedClass ? parseFloat(selectedClass.price) : 0;

    // 计算总金额
    this.money = this.check_row.length * pricePerCourse;
},isChecked: function(res, userinfo) {
    return this.check_row.some(item => 
        item.data.id === res.id && 
        item.userinfo === userinfo&&
        item.data.name === res.name
    );
},process_num(process = 0, remarks = '') {
    if (parseFloat(process) == 100 || process ? process.search(/已完成|已经完成|已经全部完成/) !== -1 : 0) {
        return 100;
    } else {
        if (process) {
            if (isNaN(parseFloat(process))) {
                let match = process.match(/(\d+)\/(\d+)/);
                if (match) {
                    return (match[1] / match[2] * 100).toFixed(2);
                } else {
                    match2 = process.match(/(\d+(\.\d+)?)%/);
                    if (match2) {
                        return parseFloat(match2[1]);
                    }
                }
            }
            return parseFloat(process);
        } else {
            // 如果process为空，尝试从remarks中解析百分比
            if (remarks) {
                let match = remarks.match(/(\d+(\.\d+)?)%/);
                if (match) {
                    return parseFloat(match[1]);
                }
            }
            return 0;
        }
    }
},
    c_ptname(rp) {
        let includesC = (['】']).find(item => rp.includes(item));
        return includesC ? rp.split(includesC)[1] : rp;
    },
    budan(id = '') {
        if (!id) {
            layer.msg('无法获取订单ID');
            return;
        }
        layer.confirm('是否补刷所选的任务？非必要不建议补刷，如有漏课/进度被清/异常请点此补刷', { title: '确认补刷' }, () => {
            layer.load(2);
            axios.post('/get/ajax.php?act=bsorder', { id: id }).then(r => {
                layer.closeAll("loading");
                if (r.data.code === 1) {
                    layer.msg('成功进入补刷队列');
                    this.query();
                } else {
                    layer.msg(r.data.msg ? r.data.msg : '补刷失败');
                }
            }).catch(error => {
                layer.closeAll("loading");
                console.error(error);
                layer.msg('补刷失败，服务器错误！');
            });
        });
    },
query(user = this.user) {
    if (!this.user) {
        layer.msg('请输入账号！');
        return;
    }
    layer.load(2);
    axios.post('/get/ajax.php?act=get', { user: this.user }).then(response => {
        layer.closeAll("loading");
        if (response.data.code !== 1 || !response.data.data || response.data.data.length === 0) {
            layer.msg('未查找到订单~');
            return;
        }
        this.orderList = response.data.data;
    }).catch(error => {
        layer.closeAll("loading");
        console.error(error);
        layer.msg('服务器错误，请稍后再试！');
    });
},
    refresh() {
        this.query();
    },
			add: function() {
				const _this = this;

				layer.msg("请先完善账号信息");

				console.log('_this.check_row', _this.check_row);

				if (_this.cid == '') {
					// 如果没查课和需要课程
					if (_this.nochake != 1) {
						layer.msg("请先查课1");
						return false;
					}
				}
				// 如果没查课和需要课程
				if (_this.nochake != 1 && !_this.noInfo) {
					layer.msg("请先查课哈！");
					return false;
				}
				if (_this.check_row.length < 1) {

					// 如果没查课和需要课程
					if (_this.nochake != 1 && !_this.noInfo) {
						layer.msg("请先选择课程");
						return false;
					}
				}
				// 如果不需要课程
				if (_this.noInfo) {
					if (_this.userinfo) {
						_this.check_row = [{
							userinfo: _this.userinfo,
							data: {}
						}]
					} else {
						layer.msg("请先完善账号信息");
						return
					}
				}
				console.log('_this.check_row', _this.check_row);

				let loadIndex = layui.layer.msg('提交中，请耐心等待', {
					icon: 16,
					shade: 0.01,
					time: 100000000,
					offset: function() {
						var viewportWidth = $(window).width();
						var viewportHeight = $(window).height();
						var offsetX = Math.floor(viewportWidth / 2) + 'px';
						var offsetY = Math.floor(viewportHeight / 2) + 'px';
						return [offsetY, offsetX];
					}
				});
				axios.post("/api/tourist.php?act=add", {
    uid: _this.uid,
    cid: _this.cid,
    data: _this.check_row,
    shu: _this.shu,
    bei: _this.bei,
    userinfo: _this.userinfo,
    nochake: _this.nochake
}, {
    emulateJSON: true
}).then(function(r) {
    if (r.data.code == 1) {
        vm.qingli();
        /*_this.$message({type: 'success', showClose: true,message: r.data.msg});*/
        _this.money = r.data.need;
        _this.out_trade_no = r.data.out_trade_no;

        layer.open({
            type: 1,
            title: '<i class="layui-icon layui-icon-vercode"></i>&nbsp;&nbsp;请选择支付方式',
            // closeBtn: 0,
            area: ['300px', 'auto'],
            skin: 'layui-bg-gray', //没有背景色
            shadeClose: true,
            content: $('#pay2'),
            end: function() {
                $("#pay2").hide();
                _this.row = [];
                _this.check_row = [];
            }
        });

        _this.nochake = 0;
    } else if(r.data.code == 2){
        layer.closeAll();
        layer.msg('成功下单，等待审核！');
        return
    }else {
        layer.msg(r.data.msg, {
            offset: function() {
                var viewportWidth = $(window).width();
                var viewportHeight = $(window).height();
                var offsetX = Math.floor(viewportWidth / 2) + 'px';
                var offsetY = Math.floor(viewportHeight / 2) + 'px';
                return [offsetY, offsetX];
            }
        });
        //   console.log('-55')
    }
    layer.close(loadIndex)
});
			},payGo: function(payType) {
				const _this = this;
				// 直接跳转到支付页面，不使用iframe
				window.location.href = '/onlinepay/epay.php?type0=tourist&uid=' + _this.uid + '&type=' + payType + '&out_trade_no=' + _this.out_trade_no;
			},
selectAll: function(rs_key) {
    const currentRow = this.row[rs_key];
    const userinfo = currentRow.userinfo;
    const courseList = currentRow.data;
    const isAllSelected = this.isAllSelected(courseList, userinfo);

    if (!isAllSelected) {
        // 添加未选中的课程
        courseList.forEach(res => {
            if (!this.isChecked(res, userinfo)) {
                this.check_row.push({
                    userinfo: userinfo,
                    userName: currentRow.userName,
                    data: res
                });
            }
        });
    } else {
        // 移除已选中的课程
        this.check_row = this.check_row.filter(item => 
            !(item.userinfo === userinfo && 
              courseList.some(res => res.id === item.data.id))
        );
    }

    // 重新计算订单金额
    this.calculateTotalAmount();

    // 触发视图更新
    this.$forceUpdate();
},
isAllSelected: function(courseList, userinfo) {
    if (!courseList || courseList.length === 0) return false;
    
    return courseList.every(res => 
        this.check_row.some(item => 
            item.data.id === res.id && 
            item.userinfo === userinfo&&
        item.data.name === res.name
        )
    );
},fenleiGet: function() {
        const _this = this;
        let loadIndex = layer.load(2);
        axios.post("/api/tourist.php?act=getfenlei", {
            uid: _this.uid,
        }, {
            emulateJSON: true
        }).then(r => {
            layer.close(loadIndex);
            if (r.data.code === 1) {
                _this.fllist = r.data;
            } else {
                layer.msg("分类获取失败，请刷新页面！");
            }
        });
    },
    fenlei: function(id) {
        const _this = this;
        let load = layer.load(2);
        axios.post("/api/tourist.php?act=getclass", {
            uid: _this.uid,
            fenlei: id
        }, {
            emulateJSON: true
        }).then(function(r) {
            layer.close(load);
            if (r.data.code == 1) {
                _this.class1 = r.data.data;
            } else {
                layer.msg(r.data.msg, {
                    icon: 2
                });
            }
        });
    },
			checkResources: function(userinfo, userName, rs, name, id, state) {
    const _this = this;
    for (let i = 0; i < rs.length; i++) {
        if (rs[i].name == name && rs[i].id == id && rs[i].state == state) {
            let aa = rs[i];
            let data = {
                userinfo,
                userName,
                data: aa
            };

            // 检查是否已经存在该课程
            let exists = _this.check_row.some(item => 
                item.userinfo === userinfo && 
                item.data.name === name && 
                item.data.id === id
            );

            if (!exists) {
                // 如果不存在，添加到勾选列表
                _this.check_row.push(data);
            } else {
                // 如果已存在，从勾选列表中移除
                _this.check_row = _this.check_row.filter(item => 
                    !(item.userinfo === userinfo && 
                      item.data.name === name && 
                      item.data.id === id)
                );
            }

            // 重新计算订单金额
            _this.calculateTotalAmount();

            break;
        }
    }
},
		getclass: function() {
				var load = layer.load(2);
				const _this = this;
				axios.post("/api/tourist.php?act=getclass", {
					uid: _this.uid
				}, {
					emulateJSON: true
				}).then(function(r) {
					if (vm.qd_notice) {
						_this.qd_notice_open()
					}
					layer.close(load);
					if (r.data.code == 1) {
						_this.class1 = r.data.data;
					} else {
						layer.msg(r.data.msg, {
							icon: 2
						});
					}
				});

			},
			getnock: function(cid) {
				const _this = this;
				axios.post("/api/tourist.php?act=getnock").then(function(r) {
					if (r.data.code == 1) {
						_this.nock = r.data.data;
						for (i = 0; _this.nock.length > i; i++) {
							if (cid == _this.nock[i].cid) {
								_this.nochake = 1;
								break;
							} else {
								_this.nochake = 0;
							}
						}
					} else {
						layer.msg(r.data.msg, {
							icon: 2
						});
					}
				});

			},
			tips: function(message) {
				const _this = this;
				_this.noInfo = false;
				_this.has_getnoun = false;
				for (var i = 0; _this.class1.length > i; i++) {
					if (_this.class1[i].cid == message) {
						_this.show = true;
						_this.content = _this.class1[i].content;
						if (!_this.class1[i].getnoun) {
							_this.noInfo = true;
						}
						if (_this.class1.find(item => item.cid === vm.cid).getnoun) {
							_this.has_getnoun = true;
						}
						_this.$notify.closeAll();
						if (_this.xdsmopen) {
							_this.$notify({
								title: '说明',
								dangerouslyUseHTMLString: true,
								message: _this.class1[i].content ? _this.class1[i].content : '暂无',
								position: 'bottom-left'
							});
						}

						return false;
						if (_this.class1[i].miaoshua == 1) {
							_this.activems = true;
						} else {
							_this.activems = false;
						}
						return false;

					}

				}

			},
			fetchPayMethods() {
    const _this = this;
    axios.post("/api/tourist.php?act=getPayMethods", {
        uid: _this.uid
    }).then(r => {
        if(r.data.code === 1) {
            _this.payMethods = r.data.methods;
        }
    });
},
			v_ok_f() {
    const _this = this;
    let loadIndex = layer.load(0);
    axios.post('/api/tourist.php?act=v_ok', {
        uid: _this.uid,
    }, {
        emulateJSON: true
    }).then(r => {
        layer.close(loadIndex);
        if (r.data.code === 1) {
            _this.v_ok = r.data.ok;
            if (_this.v_ok) {
                _this.getclass();
                _this.webConfig = r.data.webConfig;
                _this.fetchPayMethods();
                if (!_this.webConfig.notice || _this.webConfig.notice.trim() === '') {
                    _this.webConfig.notice = '店主较懒，暂未设置公告';
                }
            }
        } else {
            _this.v_ok = 0;
            layer.msg(r.data.msg ? r.data.msg : "网络异常");
        }
    })
},
		},
    })
    // -----------------------------
    app.use(ElementPlus)
    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
        app.component(key, component)
    }
    var vm = app.mount('#app');
    // -----------------------------
    
</script>
<script>
function updateTime() {
    const now = new Date();
    const options = { 
        year: 'numeric', 
        month: '2-digit', 
        day: '2-digit', 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit', 
        hour12: false, 
        timeZone: 'Asia/Shanghai' 
    };
    const parts = new Intl.DateTimeFormat('zh-CN', options).formatToParts(now);
    const formattedTime = `${parts[0].value}-${parts[2].value}-${parts[4].value} ${parts[6].value}:${parts[8].value}:${parts[10].value} 周${['日', '一', '二', '三', '四', '五', '六'][now.getDay()]}`;
    
    document.getElementById('current-time').textContent = formattedTime;
}
setInterval(updateTime, 1000); // 每秒更新时间
updateTime(); // 初始调用
// 创建雪花飘落效果
const createSnowflake = () => {
const snowflake = document.createElement('div');
snowflake.className = 'snowflake';
snowflake.style.left = Math.random() * window.innerWidth + 'px';
snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
document.body.appendChild(snowflake);

// 移除雪花
setTimeout(() => {
snowflake.remove();
}, 5000);
};

// 每隔一段时间生成雪花
setInterval(createSnowflake, 300);

// 添加CSS样式
const style = document.createElement('style');
style.textContent = `
.snowflake {
position: absolute;
top: -10px;
width: 10px;
height: 10px;
background-color: white;
opacity: 0.8;
border-radius: 50%;
animation: fall linear infinite;
}
@keyframes fall {
to {
transform: translateY(100vh);
}
}
`;
document.head.appendChild(style);
</script>