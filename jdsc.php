<?php
$title = '接单商城';
require_once('head.php');
$user_money = isset($userrow['money']) ? floatval($userrow['money']) : 0;

if ($user_money < 10) {
    echo '
    <style>
.balance-alert{display:flex;justify-content:center;align-items:center;height:100vh;background-color:#f5f5f5;font-family:"Arial",sans-serif;}.alert-box{background-color:#ffffff;padding:40px;border-radius:10px;box-shadow:0 4px 8px rgba(0,0,0,0.1);text-align:center;width:90%;max-width:360px;transition:all 0.3s ease;transform:scale(0.9);opacity:0;animation:fadeIn 0.5s forwards;}.alert-box h3{color:#333333;margin-bottom:15px;font-size:20px;font-weight:500;}.alert-box p{color:#666666;font-size:14px;line-height:1.6;margin-bottom:20px;}@keyframes fadeIn{to{transform:scale(1);opacity:1;}}
    </style>
    <div class="balance-alert">
        <div class="alert-box">
            <h3>余额不足</h3>
            <p>您的余额不足10元，无法配置接单商城。</p>
            <p>请充值后继续使用</p>
        </div>
    </div>';
    exit;
}
?>
<!-- Vue3 -->
<script src="/assets/toc/vue3.min.js?sv=<?= $conf['version'] ?>"></script>

<!-- Element Plus -->
<link href="/assets/toc/element-plus.min.css?sv=<?= $conf['version'] ?>" rel="stylesheet">
<script src="/assets/toc/element-plus.min.js?sv=<?= $conf['version'] ?>"></script>
<script src="/assets/toc/element-plus_icons-vue.min.js?sv=<?= $conf['version'] ?>"></script>

<!-- ECharts -->
<script src="/assets/toc/echarts.min.js?v=5.5.1?sv=<?= $conf['version'] ?>"></script>

<!-- Axios -->
<script src="/assets/toc/axios.min.js?v=1.7.7&sv=<?= $conf['version'] ?>"></script>
<script src="/assets/toc/axios_toc.min.js?sv=<?= $conf['version'] ?>"></script>

<!-- Layui -->
<link rel="stylesheet" href="/assets/toc/layui.min.css?v=2.9.18&sv=<?= $conf['version'] ?>" media="all">
<script src="/assets/toc/layui.min.js?v=2.9.18&sv=<?= $conf['version'] ?>"></script>
<?php
if ($conf["webVfx_open"] == '1') {
    preg_match_all('/<link.*?rel="stylesheet".*?>/', $conf["webVfx"], $matches);
    echo implode('', $matches[0]);
}
?>
<style>
hr{margin:10px 0;}.layui-laypage{margin:0;}.fenlei-selection{padding:15px;background-color:#ffffff;border-radius:8px;box-shadow:0 4px 8px rgba(0,0,0,0.1);font-family:'Arial',sans-serif;}.fenlei-option{display:block;margin-bottom:10px;padding:10px;background-color:#f5f5f5;border:1px solid #e0e0e0;border-radius:4px;transition:background-color 0.3s;cursor:pointer;}.fenlei-option:hover{background-color:#e0e0e0;}.fenlei-option input[type="radio"]{margin-right:8px;vertical-align:middle;}.fenlei-option label{cursor:pointer;display:flex;align-items:center;justify-content:flex-start;}.domain-input-group{display:flex;align-items:center;justify-content:flex-start;border:1px solid #e0e0e0;border-radius:4px;overflow:hidden;background-color:#ffffff;box-shadow:0 2px 4px rgba(0,0,0,0.1);}.domain-input-group input{border:none;outline:none;padding:0 10px;width:150px;height:36px;font-size:20px;color:#333;flex:1;}.domain-input-group .domain-suffix{padding:0 10px;background-color:#f5f5f5;color:#666;font-size:14px;height:36px;line-height:36px;white-space:nowrap;}.domain-input-group button{height:36px;margin-left:10px;}
</style>

<div class="layui-padding-2" id="tourist_spsz" style="display:none">

    <div v-if="!v_ok">
        <button type="button" class="layui-btn layui-bg-blue layui-btn-md" @click="readyGo">点我初始化</button>
    </div>

    <div v-else class="layui-panel layui-padding-2">

        <div class="layui-card-header">
            自助接单商城 <span class="layui-font-12 layui-font-green">v9.9.9</span>
            <button class="layui-btn layui-btn-xs layui-btn-primary layui-border-blue" @click="showResetConfirm">
                <i class="layui-icon layui-icon-util"></i>重置商品及支付
            </button>
        </div>
        <div class="layui-card-body">
<div>
                您的专属接单商城：<a target="_blank" class="layui-font-blue" href="//<?= $_SERVER['HTTP_HOST'] . '/?id=' . $userrow["uid"] ?>"><?= $_SERVER['HTTP_HOST'] . '/?id=' . $userrow["uid"] ?></a>
            </div>

            <hr />

            <ul class="layui-font-12" style="line-height: normal;margin-bottom:5px;">
                <li v-for="(item,index) in tips" :key="index">
                    {{index+1}}. {{item.t}}
                </li>
            </ul>
            <hr />
            <div style="display: flex; align-items: center;">
                <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="flID_open">分类管理</button>
                <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="classID_open">商品管理</button>
                <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="payID_open">支付配置</button>
                <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="touristID_open">商城配置</button>
            </div>

            <hr />

            <div>
                商城订单支付记录&nbsp;&nbsp;
                <button style="margin-bottom:0;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-normal" @click="orderTable_init(orderTable.list.current_page)">
                    <i class="layui-icon layui-icon-refresh"></i>
                </button>&nbsp;&nbsp;
                <button style="margin-bottom:0;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-blue" @click="shenhe()">
                    审核订单
                </button>
            </div>
            <div>
                <table class="layui-table" id="orderTable" lay-filter="orderTable"></table>
            </div>
            <div class="" style="display: flex; justify-content: space-between;">
                <div></div>
                <div id="listTable_laypage" style="scale: .8;margin:0;padding:0;"></div>
            </div>

        </div>

        <div id="shenheBox" style="display:none;">
            <div class="layui-padding-2">
                <button type="button" class="layui-btn layui-bg-blue layui-btn-sm" @click="shenhe_piliang(shenheTable.sex)">批量通过</button>
                <button type="button" class="layui-btn layui-bg-blue layui-btn-sm" @click="shenhe_piliang(shenheTable.sex,1)">批量打回</button>
            </div>
            <table class="layui-table" id="shenheTable" lay-filter="shenheTable" style="display:none;"></table>
        </div>

        <div id="flID" class="layui-padding-2" style="display: none;">
            
            <div class="">
                <ul class="layui-font-12" style="line-height: normal;">
                    <li v-for="(item,index) in flID.tips" :key="index">
                        {{index+1}}. {{item.t}}
                    </li>
                </ul>

                <hr style="margin: 15px 0;" />

                <button style="margin-bottom:5px;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-normal" @click="flID_init(flID.list.current_page)">
                    <i class="layui-icon layui-icon-refresh"></i>
                </button>
                <table class="layui-hide" id="flID_table" layui-filter="flID_table">

                </table>

            </div>
        </div>
    <div id="classID" class="layui-padding-2" style="display: none;">
    <div class="">
        <form class="layui-form" lay-filter="classSearch-filter" action="">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <input type="text" name="name" lay-verify="required" placeholder="请输入对应商品名称" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-inline">
                    <select name="status" lay-verify="required" lay-filter="statusSelect">
                        <option value="">请选择状态</option>
                        <option value="1">上架</option>
                        <option value="0">下架</option>
                    </select>
                </div>
                <div class="layui-inline">
                    <select name="fenlei" lay-verify="required" lay-filter="fenleiSelect">
                        <option value="">请选择分类</option>
                        <!-- 动态加载分类选项 -->
                    </select>
                </div>
<div class="layui-inline">
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="classSearch()">查询</button>
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="batchOperate('up')">批量上架</button>
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="batchOperate('down')">批量下架</button>
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="batchOperatePrice()">批量改价</button>
</div>
<hr style="margin: 10px 0;">
<div class="layui-inline">
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="batchChangeCategory()">批量修改分类</button>
    <button type="button" class="layui-btn layui-btn-sm layui-bg-blue" @click="showReplaceKeywordsDialog">一键替换关键词</button>
</div>
                  <div id="classID_table_laypage" style="scale: .8;margin:0;padding:0;"></div>
            </div>
            <div class="layui-form-item">
                <button type="reset" id="classSearch-reset" class="layui-btn layui-btn-primary" style="display:none;">重置</button>
            </div>
            <ul class="layui-font-12" style="line-height: normal;">
                <li v-for="(item,index) in classID.tips" :key="index">
                    {{index+1}}. {{item.t}}
                </li>
            </ul>
        </form>

        <hr style="margin: 15px 0;" />

        <div class="" style="display: flex; justify-content: space-between;">
            <div><button style="margin-bottom:5px;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-normal" @click="classID_init(classID.list.current_page)">
                <i class="layui-icon layui-icon-refresh"></i>
            </button></div>
            <div id="classID_table_laypage" style="scale: .8;margin:0;padding:0;"></div>
        </div>

        <table class="layui-hide" id="classID_table" layui-filter="classID_table">

        </table>

    </div>
</div>

        <div id="payID" class="layui-padding-2" style="display: none;">
            <div class="">
                <ul class="layui-font-12" style="line-height: normal;">
                    <li v-for="(item,index) in payID.tips" :key="index">
                        {{index+1}}. {{item.t}}
                    </li>
                </ul>

                <hr style="margin: 15px 0;" />

                <button style="margin-bottom:5px;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-normal" @click="payID_init()">
                    <i class="layui-icon layui-icon-refresh"></i>
                </button>
                <div>
                    <form class="layui-form" action="" lay-filter="payID_form">
                        <div class="layui-form-item">
                            <fieldset class="layui-elem-field">
                                <legend class="layui-font-16">支付方式</legend>
                                <div class="layui-field-box">
                                    <input lay-filter="payID_form_type" type="radio" name="type" :checked="payID.form.type==0" value="0" title="在线支付">
                                    <input lay-filter="payID_form_type" type="radio" name="type" :checked="payID.form.type==1" value="1" title="审核模式">
                                </div>
                            </fieldset>
                        </div>
                        <div class="layui-form-item">
                            <fieldset class="layui-elem-field">
                                <legend class="layui-font-16">易支付API</legend>
                                <div class="layui-field-box">
                                    <input :disabled="Boolean(Number(payID.form.type))" type="text" name="epay_api" v-model="payID.form.epay_api" placeholder="请输入易支付API" autocomplete="off" class="layui-input" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                </div>
                            </fieldset>
                        </div>
                        <div class="layui-form-item">
                            <fieldset class="layui-elem-field">
                                <legend class="layui-font-16">商户ID</legend>
                                <div class="layui-field-box">
                                    <input :disabled="Boolean(Number(payID.form.type))" type="text" name="epay_pid" v-model="payID.form.epay_pid" placeholder="请输入商户ID" autocomplete="off" class="layui-input" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                </div>
                            </fieldset>
                        </div>
                        <div class="layui-form-item">
                            <fieldset class="layui-elem-field">
                                <legend class="layui-font-16">商户KEY</legend>
                                <div class="layui-field-box">
                                    <input :disabled="Boolean(Number(payID.form.type))" type="text" name="epay_key" v-model="payID.form.epay_key" placeholder="请输入商户KEY" autocomplete="off" class="layui-input" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                </div>
                            </fieldset>
                        </div>
                        <div class="layui-form-item">
                            <fieldset class="layui-elem-field">
                                <legend class="layui-font-16">支付方式</legend>
                                <div class="layui-field-box">
                                    <div v-if="!Boolean(Number(payID.form.type))" class="layui-input-block" style="margin-left: 0;">
                                        <input :disabled="Boolean(Number(payID.form.type))" type="checkbox" name="is_alipay" :checked="payID.form.is_alipay" value="1" title="支付宝" lay-skin="tag" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                        <input :disabled="Boolean(Number(payID.form.type))" type="checkbox" name="is_wxpay" :checked="payID.form.is_wxpay" value="1" title="微信" lay-skin="tag" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                        <input :disabled="Boolean(Number(payID.form.type))" type="checkbox" name="is_qqpay" :checked="payID.form.is_qqpay" value="1" title="QQ" lay-skin="tag" :class="[Boolean(Number(payID.form.type))?'layui-disabled':'']">
                                    </div>
                                    <div v-else>
                                        禁用
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block" style="float: right;">
                                <button type="submit" class="layui-btn" lay-submit lay-filter="payID_form_add">保存</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div id="touristID" class="layui-padding-2" style="display: none;">
    <div class="">
        <ul class="layui-font-12" style="line-height: normal;">
            <li v-for="(item,index) in touristID.tips" :key="index">
                {{index+1}}. {{item.t}}
            </li>
        </ul>

        <hr style="margin: 15px 0;" />

        <button style="margin-bottom:5px;" type="button" class="layui-btn layui-btn-xs layui-btn-primary  layui-border-normal" @click="touristID_init()">
            <i class="layui-icon layui-icon-refresh"></i>
        </button>
        <div>
            <form class="layui-form" action="" lay-filter="touristID_form">
                <div class="layui-form-item">
                    <fieldset class="layui-elem-field">
                        <legend class="layui-font-16">商城名称</legend>
                        <div class="layui-field-box">
                            <input type="text" name="sitename" v-model="touristID.form.sitename" placeholder="请输入商城名称" autocomplete="off" class="layui-input">
                        </div>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <fieldset class="layui-elem-field">
                        <legend class="layui-font-16">客服</legend>
                        <div class="layui-field-box">
                            <input type="text" name="qqkefu" v-model="touristID.form.qqkefu" placeholder="请输入商城名称" autocomplete="off" class="layui-input">
                        </div>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <fieldset class="layui-elem-field">
                        <legend class="layui-font-16">商城公告</legend>
                        <div class="layui-field-box">
                            <textarea type="text" name="notice" class="layui-textarea" rows="5" v-model="touristID.form.notice">
                            </textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="float: right;">
                        <button type="submit" class="layui-btn" lay-submit lay-filter="touristID_form_add">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>

</div>

<script type="text/html" id="flID_table_status_templet">
{{# if(Number(d.status)) { }}
    <button type="button" class="layui-btn layui-bg-blue layui-btn-xs" lay-event="table_status_on">显示</button>
    {{# } else { }}
        <button type="button" class="layui-btn layui-btn-xs" lay-event="table_status_off">隐藏</button>
        {{# } }}
</script>

<script type="text/html" id="flID_table_name_templet">
    <div class="layui-input-group">
        <input type="text" placeholder="{{= d.name}}" value="{{= d.name}}" class="layui-input" style="height: 27px;">
        <div lay-event="listTable_user_edit" class="layui-input-split layui-input-suffix" style="height: 27px;line-height: normal;">
            <i class="layui-icon layui-icon-edit"></i>
        </div>
    </div>
</script>

<script type="text/html" id="classID_table_status_templet">
{{# if(Number(d.status)) { }}
    <button type="button" class="layui-btn layui-bg-blue layui-btn-xs" lay-event="table_status_on">上架</button>
    {{# } else { }}
        <button type="button" class="layui-btn layui-btn-xs" lay-event="table_status_off">下架</button>
        {{# } }}
</script>

<script type="text/html" id="classID_table_name_templet">
    <div lay-event="classID_name_edit" style="cursor: pointer;">
        <span class="layui-font-blue" style="text-decoration: underline;">{{= d.name}}</span>
    </div>
</script>
<script type="text/html" id="classID_table_price_templet">
    <div lay-event="classID_price_edit" style="cursor: pointer;position: relative;">
        <span class="layui-font-blue" style="text-decoration: underline;">
            {{= d.price}} {{# if(d.price*1000 < d.price2*1000) { }}<i class="layui-icon layui-icon-error layui-font-12 layui-font-red" style="position: absolute; top: -6px; right: 3px;"></i>{{# } }}
        </span>
    </div>
</script>
<script type="text/html" id="classID_table_fenlei_templet">
{{# var flList = vm.flID.list.data; }}
<select lay-event="classID_fenlei_edit" class="layui-border select-demo-primary" lay-ignore>
    {{# layui.each(flList, function(i, v){ }}
        <option value="{{= v.id }}" {{= v.id === d.fenlei ? 'selected' : '' }}>{{= v.name }}</option>
    {{# }); }}
</select>
</script>

<?php include($root . '/index/components/footer.php'); ?>

<script>
    const app = Vue.createApp({
        data() {
            return {
                v_ok: 1,
                readyGo_load: null,
                uid: '<?= $userrow['uid'] ?>',
                tips: [{
                        t: '首次初始化后所有商品默认下架，售价不得低于成本，若管理员下架商品那所有商城的相关商品也会下架',
                    },
                    {
                        t: '每个代理的配置都是独立的，接单商城页面将展示你的配置',
                    },
                    {
                        t: '请确保您的余额充足！！！客户下单提交订单前会进行代理余额检测，余额不足的代理商城不允下单',
                    },
                ],
                orderTable: {
                    ok: false,
                    list: {
                        data: [],
                    },
                    page: 1,
                    cx: {
                        status_text: '',
                        dock: '',
                        qq: '',
                        oid: '',
                        uid: '',
                        cid: '',
                        kcname: '',
                        ptname: '',
                        pagesize: '15',
                    },
                },
                flID: {
                    open: false,
                    ok: false,
                    tips: [{
                            t: '当前页面是用于管理游客下单时需要显示的分类和需要展示的分类名称',
                        },
                        {
                            t: '每个代理的配置都是独立的，商城页面将展示你的配置，商城前端按分类管理端上架时间排序',
                        },
                    ],
                    list: {
                        data: [],
                    },
                    page: 1,
                    cx: {
                        status_text: '',
                        dock: '',
                        qq: '',
                        oid: '',
                        uid: '',
                        cid: '',
                        kcname: '',
                        ptname: '',
                        pagesize: '99999',
                    },
                },
                classID: {
                    open: false,
                    ok: false,
                    tips: [{
                            t: '当前页面是用于管理游客下单时需要显示的商品和需要展示的商品名称',
                        },
                        {
                            t: '每个代理的配置都是独立的，商城页面将展示你的独立配置，商城前端按商品管理端上架时间排序',
                        },
                        {
                            t: '你的成本不得低于售价！成本会自动同步管理员配置，请注意你的售价，低于成本的商品不会在商城显示！',
                        },
                    ],
                    list: {
                        data: [],
                    },
                    page: 1,
                    cx: {
                        status: '',
                        qq: '',
                        cid: '',
                        name: '',
                        pagesize: '15',
                    },
                },
                payID: {
                    open: false,
                    ok: false,
                    tips: [{
                            t: '【在线支付】指客户下单付款时会使用你的易支付配置进行支付验证！',
                        },
                        {
                            t: '【审核模式】指客户下单时不需要付款，代理自己到该页面审核通过',
                        },
                    ],
                    form: {
                        epay_api: '',
                        epay_pid: '',
                        epay_key: '',
                        type: 0,
                    },
                    page: 1,
                },
                touristID: {
                    open: false,
                    ok: false,
                    form: {
                        sitename: '',
                        qqkefu: '',
                    },
                },
                shenheTable: {
                    ok: false,
                    list: {
                        data: [],
                    },
                    sex: [],
                    page: 1,
                    cx: {
                        status_text: '',
                        dock: '',
                        qq: '',
                        oid: '',
                        uid: '',
                        cid: '',
                        kcname: '',
                        ptname: '',
                        type: '',
                        pagesize: '15',
                    },
                },
            }
        },
        mounted() {
            const _this = this;

            let loadIndex = layer.load(2);

            $("#tourist_spsz").ready(() => {
                layer.close(loadIndex);
                $("#tourist_spsz").show();
                _this.v_ok_go();
            })

        },
        methods: {
            // 初始化
      readyGo: function() {
    const _this = this;
    _this.continueInitialization();
},
continueInitialization: function() {
    const _this = this;

    _this.readyGo_load = layer.msg('初始化中...', {
        icon: 16,
        shade: 0.01,
        time: 0
    });

    axios.post('/api/tourist.php?act=dataInit', {
        uid: _this.uid,
    }, {
        emulateJSON: true
    }).then(r => {
        layer.close(_this.readyGo_load);
        if (r.data.code === 1) {
            layer.msg("初始化完成", {
                time: 3000 // 提示信息显示三秒
            }, function() {
                location.reload(); // 三秒后刷新页面
            });
        } else {
            layer.msg(r.data.msg);
        }
    }).catch(error => {
        layer.close(_this.readyGo_load);
        layer.msg('网络异常');
    });
},
            v_ok_go: function() {
                const _this = this;

                axios.post('/api/tourist.php?act=v_ok', {
                    uid: _this.uid,
                }, {
                    emulateJSON: true
                }).then(r => {
                    if (r.data.code === 1) {
                        _this.v_ok = r.data.ok;
                        layer.closeAll('loading')
                        layer.close(_this.readyGo_load);
                        if (_this.v_ok) {
                            _this.orderTable_init(1, 'one');
                        }
                    } else {
                        _this.v_ok = 0;
                        layer.msg("异常");
                    }
                })
            },batchChangeCategory: function() {
    const _this = this;
    const checked = layui.table.checkStatus('classID_table').data; // 获取勾选的商品
    if (checked.length === 0) {
        layer.msg('请先选择需要修改分类的商品！');
        return;
    }

    // 弹出分类选择框
    layer.open({
        type: 1,
        area: ['360px', 'auto'],
        title: '选择分类',
        content: `
            <div class="fenlei-selection">
                ${_this.flID.list.data.map(fl => `
                    <div class="fenlei-option">
                        <input type="radio" name="newCategory" value="${fl.id}" id="category-${fl.id}">
                        <label for="category-${fl.id}">${fl.name}</label>
                    </div>
                `).join('')}
            </div>
        `,
        success: function(layero, index) {
            layui.form.render('radio'); // 重新渲染单选框
        },
        btn: ['确定', '取消'],
        yes: function(index, layero) {
            const selectedCategoryId = $('input[name="newCategory"]:checked').val();
            if (!selectedCategoryId) {
                layer.msg('请选择一个分类！');
                return;
            }

            // 调用后端接口批量修改分类
            layer.load(2);
            axios.post('/api/tourist.php?act=batch_change_category', {
                uid: _this.uid,
                category_id: selectedCategoryId,
                product_ids: checked.map(item => item.cid).join(',')
            }, {
                emulateJSON: true
            }).then(response => {
                layer.closeAll('loading');
                if (response.data.code === 1) {
                    layer.msg('批量修改分类成功！');
                    _this.classID_init(_this.classID.list.current_page); // 刷新商品列表
                } else {
                    layer.msg(response.data.msg || '操作失败！');
                }
            }).catch(error => {
                layer.closeAll('loading');
                layer.msg('网络异常！');
            });
        },
        btn2: function(index, layero) {
            layer.close(index);
        }
    });
},
            orderTable_init: function(page, type) {
                const _this = this;
                _this.orderTable.ok = false;
                layer.load(2);
                axios.post('/api/tourist.php?act=t_orderlist', {
                    uid: _this.uid,
                    cx: _this.orderTable.cx,
                    page: page ? page : 1,
                }, {
                    emulateJSON: true
                }).then(r => {
                    if (r.data.code === 1) {
                        console.log("ok");
                        _this.orderTable.ok = true;
                        _this.orderTable.list = r.data;
                        _this.orderTable_table_init();

                        if (type === 'one') {
                            layui.laypage.render({
                                elem: 'listTable_laypage', // 元素 id
                                count: _this.orderTable.list.count, // 数据总数
                                limit: _this.orderTable.list.pagesize,
                                limits: [15, 30, 50, 100,500,1000],
                                layout: ['count', 'prev', 'page', 'next', 'limit'], // 功能布局
                                prev: '<i class="layui-icon layui-icon-left"></i>',
                                next: '<i class="layui-icon layui-icon-right"></i>',
                                jump: function(obj, first) {
                                    if (!first) {
                                        _this.orderTable.cx.pagesize = obj.limit;
                                        _this.orderTable_init(obj.curr, '');
                                    }
                                }
                            });
                        }

                        layer.closeAll('loading');
                    } else {
                        _this.orderTable.ok = false;
                        layer.closeAll();
                        layer.msg("网络错误，请重试！");
                    }
                })
            },showReplaceKeywordsDialog() {
        const _this = this;
        layer.open({
            type: 1,
            area: ['300px', 'auto'],
            title: '一键替换关键词',
            content: `
                <div class="layui-form-item">
                 <label class="layui-form-label">关键词</label>
                    <div class="layui-input-block">
                        <input type="text" name="oldKeyword" required lay-verify="required" placeholder="商品名包含的词" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                 <label class="layui-form-label">替换为</label>
                    <div class="layui-input-block">
                        <input type="text" name="newKeyword" required lay-verify="required" placeholder="请输入替换词" autocomplete="off" class="layui-input">
                    </div>
                </div>
            `,
            btn: ['确定', '取消'],
            yes: function(index, layero) {
                const oldKeyword = layero.find('input[name="oldKeyword"]').val();
                const newKeyword = layero.find('input[name="newKeyword"]').val();
                if (!oldKeyword || !newKeyword) {
                    layer.msg('请输入被替换词和替换词！');
                    return;
                }
                // 调用后端接口进行替换操作
                _this.replaceKeywords(oldKeyword, newKeyword);
                layer.close(index);
            },
            btn2: function(index, layero) {
                layer.close(index);
            }
        });
    },
    replaceKeywords(oldKeyword, newKeyword) {
        const _this = this;
        layer.load(2); // 显示加载动画
        axios.post('/api/tourist.php?act=replace_keywords', {
            uid: _this.uid,
            oldKeyword: oldKeyword,
            newKeyword: newKeyword
        }).then(response => {
            layer.closeAll('loading'); // 关闭加载动画
            if (response.data.code === 1) {
                layer.msg('关键词替换成功！');
                _this.classID_init(_this.classID.list.current_page); // 刷新商品列表
            } else {
                layer.msg(response.data.msg || '操作失败！');
            }
        }).catch(error => {
            layer.closeAll('loading'); // 关闭加载动画
            layer.msg('网络异常！');
        });
    },
            orderTable_table_init: function() {
                const _this = this;
                layui.table.render({
                    elem: "#orderTable",
                    size: "sm",
                    even: true,
                    cellExpandedMode: 'tips',
                    data: _this.orderTable.list.data,
                    cols: [
                        [
                            {
                                field: "oid",
                                title: "ID",
                                width: 50,
                                align: "center"
                            },
                            {
                                field: "uid",
                                title: "UID",
                                width: 50,
                                align: "center",
                                hide: <?php if ($userrow["uid"]  == 1) { ?>0<?php } else { ?>1<?php } ?>,
                            },
                            {
                                field: "status",
                                title: "状态",
                                width: 90,
                                align: "center",
                                templet: "{{= d.status !='已支付' ?'× '+d.status:'√ 已支付'}}",
                            },
                            {
                                field: "fees",
                                title: "成本",
                                width: 60,
                                align: "center"
                            },
                            {
                                field: "shoujia",
                                title: "售价",
                                width: 60,
                                align: "center",
                            },
                            {
                                field: "ptname",
                                title: "平台",
                                width: 160,
                            },
                            {
                                field: "school",
                                title: "学校",
                                width: 120,
                            },
                            {
                                field: "user",
                                title: "账号",
                                width: 120,
                            },
                            {
                                field: "pass",
                                title: "密码",
                                width: 120,
                            },
                            {
                                field: "kcname",
                                title: "课程",
                                width: 120,
                            },
                            {
                                field: "out_trade_no",
                                title: "订单号",
                                width: 140,
                            },
                            {
                                field: "paytime",
                                title: "支付时间",
                                width: 148,
                            },
                            {
                                field: "addtime",
                                title: "添加时间",
                                width: 170,
                            },
                        ]
                    ],
                    page: false,
                })
            },
loadFenleiOptions: function() {
    const _this = this;
    // 假设 flID.list.data 是分类数据数组
    const fenleiOptions = _this.flID.list.data.map(fl => `
        <option value="${fl.id}">${fl.name}</option>
    `).join('');
    document.querySelector('select[name="fenlei"]').innerHTML = `
        <option value="">请选择分类</option>
        ${fenleiOptions}
    `;
    layui.form.render('select'); // 重新渲染下拉框
},
            flID_table_init: function() {
                const _this = this;
                layui.use("table", function() {
                    let table = layui.table;
                    table.render({
                        elem: "#flID_table",
                        size: "md",
                        even: true,
                        cellExpandedMode: 'tips',
                        data: _this.flID.list.data,
                        cols: [
                            [{
                                    field: "id",
                                    title: "ID",
                                    width: 50,
                                    align: "center"
                                },
                                {
                                    field: "name",
                                    title: "分类名称",
                                    width: 180,
                                    templet: '#flID_table_name_templet'
                                },
                                {
                                    field: "status",
                                    title: "状态",
                                    width: 70,
                                    align: "center",
                                    templet: '#flID_table_status_templet'
                                },
                                {
                                    field: "cnum",
                                    title: "商品数量",
                                    align: "center",
                                    width: 110,
                                },
                                {
                                    field: "name2",
                                    title: "对应分类",
                                    width: 180,
                                },
                                {
                                    field: "time",
                                    title: "添加时间"
                                },
                            ]
                        ],
                        page: false,
                    })

                    table.on('tool(flID_table)', function(obj) {
                        let data = obj.data;
                        switch (obj.event) {
                            case 'listTable_user_up':
                                var load = layer.load(2);
                                axios.post("/api/tourist.php?act=fl_sort", {
                                    type: 'up',
                                    id: data.id
                                }, {
                                    emulateJSON: true
                                }).then(function() {
                                    layer.close(load);
                                    _this.helplist();
                                })
                                break;
                            case 'listTable_user_down':
                                var load = layer.load(2);
                                axios.post("/api/tourist.php?act=fl_sort", {
                                    type: 'down',
                                    id: data.id
                                }, {
                                    emulateJSON: true
                                }).then(function() {
                                    layer.close(load);
                                    _this.helplist();
                                })
                                break;
                            case 'listTable_user_del':
                                _this.del(data.id);
                                break;
                            case 'listTable_user_edit':
                                layer.load(2);
                                let name = $(this).siblings("input").val();
                                axios.post("/api/tourist.php?act=t_fl", {
                                    active: '2',
                                    uid: _this.uid,
                                    id: data.id,
                                    data: {
                                        name: name
                                    }
                                }, {
                                    emulateJSON: true
                                }).then(r => {
                                    layer.closeAll('loading');
                                    if (r.data.code === 1) {
                                        _this.flID_init();
                                        layer.msg("修改成功");
                                    } else {
                                        layer.msg(r.data.msg ? r.data.msg : "修改失败");
                                    }
                                })
                                break;
                            case 'table_status_on':
                                data.status = 0;
                                layer.load(2);
                                axios.post("/api/tourist.php?act=t_fl", {
                                    active: '2',
                                    uid: _this.uid,
                                    id: data.id,
                data: {
        status: data.status ? 1 : 0
    }
                                }, {
                                    emulateJSON: true
                                }).then(r => {
                                    layer.closeAll('loading');
                                    if (r.data.code === 1) {
                                        _this.flID_init();
                                        layer.msg("修改成功");
                                    } else {
                                        layer.msg(r.data.msg ? r.data.msg : "修改失败");
                                    }
                                })
                                break;
                            case 'table_status_off':
                                data.status = 1;
                                layer.load(2);
                                axios.post("/api/tourist.php?act=t_fl", {
                                    active: '2',
                                    uid: _this.uid,
                                    id: data.id,
                data: {
        status: data.status ? 1 : 0
    }
                                }, {
                                    emulateJSON: true
                                }).then(r => {
                                    layer.closeAll('loading');
                                    if (r.data.code === 1) {
                                        _this.flID_init();
                                        layer.msg("修改成功");
                                    } else {
                                        layer.msg(r.data.msg ? r.data.msg : "修改失败");
                                    }
                                })
                                break;
                            default:
                                break;
                        }

                    });
                })
            },
classID_open: function() {
    const _this = this;
    if (_this.classID.open) {
        return;
    }
    layer.open({
        type: 1,
        area: ['360px', '90vh'],
        maxmin: true,
        scrollbar: false,
        title: '商品管理',
        content: $("#classID"),
        success: function(layero, index) {
            layer.full(index);
            _this.classID.open = true;
            layui.use(() => {
                layui.form.render();
            });
            _this.classID_init(1, "one");
            _this.flID_init();
        },
        end: function() {
            _this.classID.open = false;
            for (let i in _this.classID.cx) {
                if (i != 'pagesize') {
                    _this.classID.cx[i] = '';
                }
            }
            $("#classSearch-reset").click();
            $("#classSearch-reset").hide();
            _this.flID.open = false;
        }
    });
},
flID_open: function() {
    const _this = this;
    if (_this.flID.open) {
        return;
    }
    layer.open({
        type: 1,
        area: ['360px', '90vh'],
        maxmin: true,
        scrollbar: false,
        title: '分类管理',
        content: $("#flID"),
        success: function(layero, index) {
            layer.full(index);
            if (!_this.flID.ok) {
                _this.flID_init();
            }
            _this.flID.open = true;
        },
        end: function() {
            _this.flID.open = false;
        }
    });
},

flID_init: function() {
    const _this = this;
    _this.flID.ok = false;
    layer.load(2);
    axios.post('/api/tourist.php?act=t_fllist', {
        uid: _this.uid,
        page: _this.flID.page,
        pagesize: 1,
    }, {
        emulateJSON: true
    }).then(r => {
        layer.closeAll('loading');
        if (r.data.code === 1) {
            _this.flID.ok = true;
            _this.flID.list = r.data;
            _this.flID_table_init();
            _this.loadFenleiOptions();
        } else {
            layer.msg("网络错误，请重试！");
        }
    }).catch(error => {
        layer.closeAll('loading');
        layer.msg("网络异常，请检查后重试！");
    });
},
            classID_init: function(page, type) {
    const _this = this;
    _this.classID.ok = false;
    let loadIndex = layer.load(2);
    axios.post('/api/tourist.php?act=t_classlist', {
        uid: _this.uid,
        page: page ? page : 1,
        cx: _this.classID.cx
    }, {
        emulateJSON: true
    }).then(r => {
        layer.close(loadIndex);
        if (r.data.code === 1) {
            console.log("ok");
            _this.classID.ok = true;
            _this.classID.list = r.data;
            _this.classID_table_init();

            if (type === 'one') {
                layui.laypage.render({
                    elem: 'classID_table_laypage', // 元素 id
                    count: _this.classID.list.count, // 数据总数
                    limit: _this.classID.list.pagesize,
                    limits: [15, 30, 50, 100,500,1000],
                    layout: ['count', 'prev', 'page', 'next', 'limit'], // 功能布局
                    prev: '<i class="layui-icon layui-icon-left"></i>',
                    next: '<i class="layui-icon layui-icon-right"></i>',
                    jump: function(obj, first) {
                        if (!first) {
                            _this.classID.cx.pagesize = obj.limit;
                            _this.classID_init(obj.curr, '');
                        }
                    }
                });
            }

            layer.closeAll('loading');
        } else {
            _this.classID.ok = false;
            layer.closeAll();
            layer.msg("网络错误，请重试！");
        }
    });
},
            classID_table_init: function() {
    const _this = this;
    layui.use("table", function() {
        let table = layui.table;
        table.render({
            elem: "#classID_table",
            size: "md",
            even: true,
            cellExpandedMode: 'tips',
            data: _this.classID.list.data,
            cols: [
                [{
                        type: 'checkbox',
                        fixed: 'left'
                    },
                    {
                        field: "cid",
                        title: "ID",
                        width: 50,
                        align: "center"
                    },
                    {
                        field: "name",
                        title: "商品名称",
                        minWidth: 160,
                        templet: '#classID_table_name_templet'
                    },
                    {
                        field: "price2",
                        title: "成本",
                        align: "center",
                        width: 70,
                    },
                    {
                        field: "price",
                        title: "售价",
                        align: "center",
                        width: 80,
                        templet: '#classID_table_price_templet'
                    },
                    {
                        field: "status",
                        title: "状态",
                        width: 70,
                        align: "center",
                        templet: '#classID_table_status_templet'
                    },
                    {
                        field: "fenlei",
                        title: "分类",
                        align: "center",
                        width: 140,
                        templet: '#classID_table_fenlei_templet'
                    },
                    {
                        field: "name2",
                        title: "对应商品",
                        width: 250,
                    },
                    {
                        field: "content",
                        title: "商品说明",
                        width: 400,
                    },
                ]
            ],
            page: false,
        });

        table.on('tool(classID_table)', function(obj) {
            let data = obj.data;
            switch (obj.event) {
                case 'classID_fenlei_edit':
                    // 分类编辑逻辑
                    layer.open({
                        type: 1,
                        area: ['320px', 'auto'],
                        title: '选择分类',
                        content: `
                            <div class="fenlei-selection">
                                ${_this.flID.list.data.map(fl => `
                                    <div class="fenlei-option">
                                        <input type="radio" name="fenlei" value="${fl.id}" ${fl.id === data.fenlei ? 'checked' : ''}> ${fl.name}
                                    </div>
                                `).join('')}
                            </div>
                        `,
                        success: function(layero, index) {
                            layui.form.render('radio');
                        },
                        btn: ['确认', '取消'],
                        yes: function(index, layero) {
                            let selectVal = $('input[name="fenlei"]:checked').val();
                            if (selectVal !== data.fenlei) {
                                layer.confirm('确定要将分类修改为 "' + $('input[name="fenlei"]:checked').parent().text().trim() + '" 吗？', {
                                    title: '确认修改'
                                }, function(index2) {
                                    _this.classID_edit({
                                        active: '2',
                                        uid: _this.uid,
                                        cid: data.cid,
                                        data: {
                                            fenlei: selectVal + '',
                                        },
                                    });
                                    layer.close(index);
                                    layer.close(index2);
                                });
                            } else {
                                layer.close(index);
                            }
                        },
                        btn2: function(index, layero) {
                            layer.close(index);
                        }
                    });
                    break;
                case 'classID_name_edit':
                    layer.prompt({
                        title: '请输入新商品名称&nbsp;&nbsp;<span class="layui-font-12 layui-font-green">当前名称：' + data.name + '</span>',
                        value: data.name,
                    }, function(value, index, elem) {
                        if (value === '') {
                            layer.msg("请输入正确的名称！");
                            return elem.focus();
                        };
                        let name = value.trim();
                        _this.classID_edit({
                            active: '2',
                            uid: _this.uid,
                            cid: data.cid,
                            data: {
                                name: name,
                            },
                        }, index);
                    });
                    break;
                case 'classID_price_edit':
                    layer.prompt({
                        title: '请输入新售价&nbsp;&nbsp;<span class="layui-font-12 layui-font-green">当前售价：' + data.price + '</span>',
                        value: data.price * 100 < data.price2 * 100 ? data.price2 + 1 : data.price,
                    }, function(value, index, elem) {
                        if (value === '' || !(/^\d*\.?\d+$/.test(value)) || parseFloat(value) < 0) {
                            layer.msg("请输入正确的价格！");
                            return elem.focus();
                        };
                        if (value < data.price2) {
                            return layer.msg("不可低于成本！");
                        }
                        let price = value.trim();
                        _this.classID_edit({
                            active: '2',
                            uid: _this.uid,
                            cid: data.cid,
                            data: {
                                price: price,
                            },
                        }, index);
                    });
                    break;
                case 'table_status_on':
                    data.status = 0;
                    _this.classID_edit({
                        active: '2',
                        uid: _this.uid,
                        cid: data.cid,
                        data: {
                            status: data.status ? 1 : 0
                        },
                    });
                    break;
                case 'table_status_off':
                    data.status = 1;
                    _this.classID_edit({
                        active: '2',
                        uid: _this.uid,
                        cid: data.cid,
                        data: {
                            status: data.status ? 1 : 0
                        },
                    });
                    break;
                default:
                    break;
            }
        });
    });
},
            classID_edit: function(data, index = 0) {
    const _this = this;
    layer.load(2);
    axios.post("/api/tourist.php?act=t_class", data, {
        emulateJSON: true
    }).then(r => {
        if (r.data.code === 1) {
            layer.closeAll("loading");
            layer.msg("修改成功");
            if (index) {
                layer.close(index);
            }
            _this.classID_init(_this.classID.list.current_page); // 刷新表格数据
        } else {
            layer.closeAll("loading");
            layer.msg(r.data.msg);
        }
    })
},
        classSearch: function() {
    const _this = this;
    layui.use(() => {
        let data = layui.form.val("classSearch-filter");
        _this.classID.cx.name = data.name; // 获取商品名称筛选的值
        _this.classID.cx.status = data.status; // 获取状态筛选的值
        _this.classID.cx.fenlei = data.fenlei; // 获取分类筛选的值
        _this.classID_init(1, 'one'); // 重新加载商品列表
    });
},
showResetConfirm: function() {
    const _this = this;
    layer.open({
        type: 1,
        title: '重置商城',
        content: `
            <div style="padding: 15px;">
                <p>确定要重置商城吗？这将重置支付设置和商品名称、价格及所在分类</p>
            </div>
        `,
        area: ['400px', '300px'], // 弹窗大小
        btn: ['确定',  '取消'],
        btn1: function(index, layero) {
            layer.close(index);
            _this.readyGo(); // 直接开始重置
        },
        btn2: function(index, layero) {
            layer.close(index); // 关闭弹窗
        }
    });
},
    replaceKeywords(oldKeyword, newKeyword) {
        const _this = this;
        layer.load(2); // 显示加载动画
        axios.post('/api/tourist.php?act=replace_keywords', {
            uid: _this.uid,
            oldKeyword: oldKeyword,
            newKeyword: newKeyword
        }).then(response => {
            layer.closeAll('loading'); // 关闭加载动画
            if (response.data.code === 1) {
                layer.msg('关键词替换成功！');
                _this.classID_init(_this.classID.list.current_page); // 刷新商品列表
            } else {
                layer.msg(response.data.msg || '操作失败！');
            }
        }).catch(error => {
            layer.closeAll('loading'); // 关闭加载动画
            layer.msg('网络异常！');
        });
    },
            touristID_open: function() {
    const _this = this;
    if (_this.touristID.open) {
        return;
    }
    layer.open({
        type: 1,
        area: ['360px', '90vh'],
        maxmin: true,
        scrollbar: false,
        title: '商城配置',
        content: $("#touristID"),
        success: function(layero, index) {
            layer.full(index);
            layui.use(() => {
                layui.form.render();
            });
            _this.touristID_init();
        },
        end: function() {
            console.log('关闭商城配置');
            _this.touristID.open = false;
        }
    });
},
touristID_init: function(type = '', data = {}) {
    const _this = this;
    _this.touristID.ok = false;
    let loadIndex = layer.load(2);
    for (let i in data) {
        data[i] = data[i].trim();
    }
    axios.post('/api/tourist.php?act=touristData', {
        uid: _this.uid,
        type: type,
        data: data,
    }, {
        emulateJSON: true
    }).then(r => {
        layer.close(loadIndex);
        if (r.data.code == 1) {
            if (type == 'save') {
                layer.msg("修改成功");
            }
            for (let i in r.data.data) {
                _this.touristID.form[i] = r.data.data[i];
            }
            _this.touristID_form_init();
        } else {
            layer.msg(r.data.msg ? r.data.msg : "网络异常");
        }
    });
},
touristID_form_init: function() {
                const _this = this;
                layui.form.render(null, 'touristID');
                layui.form.on('submit(touristID_form_add)', function(data) {
                    var field = data.field; // 获取表单字段值
                    _this.touristID_init("save", field);

                    return false;
                })
            },
            payID_open: function() {
                const _this = this;
                if (_this.payID.open) {
                    return
                }
                _this.flID_init();
                layer.open({
                    type: 1,
                    id: "touristIDlayer",
                    area: ['360px', '90vh'],
                    maxmin: true,
                    scrollbar: false,
                    title: '支付配置',
                    content: $("#payID"),
                    success: function(layero, index) {
                        layer.full(index);
                        _this.payID_init();
                        _this.payID.open = true;
                    },
                    end: function() {
                        console.log('关闭支付配置')
                        _this.payID.open = false;
                    }
                })
            },
            payID_form_init: function() {
                const _this = this;
                layer.load(2);
                setTimeout(() => {
                    layer.closeAll("loading");
                    layui.form.render(null, 'payID_form');
                }, 100)
                layui.form.on('submit(payID_form_add)', function(data) {
                    var field = data.field; // 获取表单字段值

                    field.is_alipay = field.is_alipay ? "1" : "0";
                    field.is_wxpay = field.is_wxpay ? "1" : "0";
                    field.is_qqpay = field.is_qqpay ? "1" : "0";
                    console.log(field)

                    layer.load(2);
                    axios.post("/api/tourist.php?act=payConfig_up", {
                        uid: _this.uid,
                        data: field
                    }, {
                        emulateJSON: true
                    }).then(r => {
                        if (r.data.code === 1) {
                            console.log(r.data, data);
                            _this.payID_init();
                            layer.closeAll("loading");
                            layer.msg('保存成功');
                        } else {
                            layer.closeAll("loading");
                            layer.msg(r.data.msg);
                        }
                    })

                    return false; // 阻止默认 form 跳转
                });

                layui.form.on('radio(payID_form_type)', function(data) {
                    var field = data.elem.value;
                    _this.payID.form.type = field;
                    console.log(99, field);
                    return false;
                })
            },
            payID_init: function() {
                const _this = this;
                _this.payID.ok = false;
                layer.load(2);
                axios.post('/api/tourist.php?act=payConfig', {
                    uid: _this.uid,
                }, {
                    emulateJSON: true
                }).then(r => {
                    layer.closeAll('loading');
                    if (r.data.code === 1) {
                        console.log("ok", r.data);
                        _this.payID.ok = true;

                        r.data.is_alipay = r.data.is_alipay === "1" ? "on" : "";
                        r.data.is_wxpay = r.data.is_wxpay === "1" ? "on" : "";
                        r.data.is_qqpay = r.data.is_qqpay === "1" ? "on" : "";

                        _this.payID.form = r.data.data;
                        _this.payID_form_init();
                    } else {
                        _this.payID.ok = false;
                        layer.closeAll();
                        layer.msg("网络错误，请重试！");
                    }
                })
            },
            shenhe: function() {
                const _this = this;
                let loadIndex = layer.load(2);
                layer.open({
                    type: 1,
                    title: '审核订单',
                    content: $("#shenheBox"),
                    area: ["98%", "98%"],
                    success: function() {
                        layer.close(loadIndex);
                        _this.shenheTable_data(1);
                    },
                    done: function() {
                        
                    },
                    end: function() {
                        _this.orderTable_init(1)
                    }
                })
            },
            shenheTable_init: function() {
                const _this = this;

                layui.use(() => {
                    layui.table.render({
                        elem: "#shenheTable",
                        size: "sm",
                        even: true,
                        cellExpandedMode: 'tips',
                        data: _this.shenheTable.list.data,
                        text: {
                            none: '没有需要审核的订单'
                        },
                        cols: [
                            [{
                                    type: 'checkbox',
                                    fixed: 'left'
                                },
                                {
                                    field: "oid",
                                    title: "ID",
                                    width: 50,
                                    align: "center"
                                },
                                {
                                    field: "status",
                                    title: "状态",
                                    width: 90,
                                    align: "center",
                                    templet: "{{= d.status==='待支付' || d.status==='待审核'?'× '+d.status:'√ 已支付'}}",
                                },
                                {
                                    field: "fees",
                                    title: "成本",
                                    width: 60,
                                    align: "center"
                                },
                                {
                                    field: "ptname",
                                    title: "平台",
                                    width: 160,
                                },
                                {
                                    field: "school",
                                    title: "学校",
                                    width: 120,
                                },
                                {
                                    field: "user",
                                    title: "账号",
                                    width: 120,
                                },
                                {
                                    field: "pass",
                                    title: "密码",
                                    width: 120,
                                },
                                {
                                    field: "kcname",
                                    title: "课程",
                                    width: 120,
                                },
                                {
                                    field: "paytime",
                                    title: "通过时间",
                                    width: 148,
                                },
                                {
                                    field: "addtime",
                                    title: "添加时间",
                                    width: 170,
                                },
                            ]
                        ],
                        page: false,
                        done: function() {

                        },
                    })

                    layui.table.on('checkbox(shenheTable)', function(obj) {
                        let checkData = layui.table.checkStatus('shenheTable').data;
                        _this.shenheTable.sex = [];
                        for (let i in checkData) {
                            _this.shenheTable.sex[i] = checkData[i].oid
                        }
                        console.log(_this.shenheTable.sex)
                    })

                })
            },
            shenheTable_data: function(page, type) {
                const _this = this;
                let loadIndex = layer.load(2);
                _this.shenheTable.cx.type = 'tourist1';
                _this.shenheTable.cx.pagesize = 200;
                axios.post('/api/tourist.php?act=t_orderlist', {
                    uid: _this.uid,
                    cx: _this.shenheTable.cx,
                    page: page ? page : 1,
                }, {
                    emulateJSON: true
                }).then(r => {
                    layer.close(loadIndex);
                    if (r.data.code == 1) {
                        // 确保正确解析数据数组，假设数据结构与orderTable一致
                        _this.shenheTable.list.data = r.data.data || [];
                        _this.shenheTable_init();
                        // 显示表格元素
                        $('#shenheTable').show();
                    } else {
                        layer.msg(r.data.msg ? r.data.msg : "异常");
                    }
                })
            },
            shenhe_piliang: function(sex, type = 0) {
                if (!sex || !sex.length) {
                    layer.msg("请选择订单");
                    return
                }
                type = type ? 1 : 0;
                const _this = this;

                let loadIndex = layer.load(2);
                axios.post('/api/tourist.php?act=shenhe_piliang', {
                    uid: _this.uid,
                    sex: _this.shenheTable.sex,
                    type: type,
                }, {
                    emulateJSON: true
                }).then(r => {
                    layer.close(loadIndex);
                    if (r.data.code == 1) {
                        if (type) {
                            layer.msg("成功打回");
                        } else {
                            layer.msg("成功，扣除：" + r.data.money);
                        }
                        _this.shenheTable_data(1);
                    } else {
                        layer.msg(r.data.msg ? r.data.msg : "异常")
                    }
                })

            },
            // 批量操作方法
            batchOperate: function(status) {
                const checked = layui.table.checkStatus('classID_table').data;
                if (checked.length === 0) {
                    layer.msg('请先选择需要操作的商品！');
                    return;
                }
        
                layer.load(2);
                axios.post('/api/tourist.php?act=batch_class_status', {
                    uid: this.uid,
                    status: status, // up/down
                    ids: checked.map(item => item.cid).join(',')
                }, {
                    emulateJSON: true
                }).then(response => {
                    layer.closeAll('loading');
                    if (response.data.code === 1) {
                        layer.msg(status === 'up' ? '批量上架成功！' : '批量下架成功！');
                        this.classID_init(1); // 刷新列表
                    } else {
                        layer.msg(response.data.msg || '操作失败！');
                    }
                }).catch(error => {
                    layer.closeAll('loading');
                    layer.msg('网络异常！');
                });
            },
            batchOperatePrice: function() {
                const _this = this;
                const checked = layui.table.checkStatus('classID_table').data;
                
                if (checked.length === 0) {
                    layer.msg('请先选择需要操作的商品！');
                    return;
                }
                
                // 获取弹窗索引
                const index = layer.prompt({
                    title: '设置价格倍率（输入999恢复商品默认价格！）',
                    value: '',
                    placeholder: '请输入大于0的倍率（如1.5表示涨价50%）',
                    validate: function(value) {
                        return /^(\d+(\.\d{1,2})?)?$/.test(value) && parseFloat(value) > 0;
                    }
                }, function(value, index, elem) {
                    // 保存弹窗索引
                    const promptIndex = index;
                    
                    if (!value) {
                        layer.msg("请输入有效数值！");
                        return elem.focus();
                    }
                    
                    const pricebl = parseFloat(value);
                    if (pricebl <= 0) {
                        layer.msg("价格倍率必须大于0！");
                        return;
                    }
                    
                    layer.load(2);
                    axios.post('/api/tourist.php?act=batch_class_status', {
                        uid: _this.uid,
                        status: 'pricebl',
                        ids: checked.map(item => item.cid).join(','),
                        pricebl: pricebl.toFixed(2)
                    }, {
                        emulateJSON: true
                    }).then(r => {
                        layer.closeAll('loading');
                        layer.close(promptIndex); // 关闭弹窗
                        if (r.data.code === 1) {
                            layer.msg("改价成功！新价格 = 原价 × " + value);
                            _this.classID_init(1);
                        } else {
                            layer.msg(r.data.msg || "操作失败");
                        }
                    }).catch(error => {
                        layer.closeAll('loading');
                        layer.close(promptIndex); // 错误时也关闭弹窗
                        layer.msg("网络异常！");
                    });
                });
            },
        },
    })
    // -----------------------------
    app.use(ElementPlus)
    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
        app.component(key, component)
    }
    var vm = app.mount('#tourist_spsz');
    // -----------------------------

    layui.use(function() {})
</script>
<script>
layer.alert('请仔细阅读<br><span style="color: red;">1.首次加载请点击初始化，完成后即可配置上架网课商品和商品分类。<br>2.接单模式有两种，一为一单一付模式，该模式类似网站购物，需要到支付配置中配置支付，用户下单即支付金额，金额到账你的微信或支付宝余额中。<br>3.二为审核模式，用户下单不需要支付金额，不通过在线支付系统，代理手动审核订单，通过其他方式与客户单独交易。<br>4.每个模式各有所长，自行选择，下单成功的订单扣除代理当前等级的商品价格，如您的余额不足扣费，客户将无法下单！', {
  time: 180*1000
  ,success: function(layero, index){
    var timeNum = this.time/1000, setText = function(start){
      layer.title((start ? timeNum : --timeNum) + ' 秒后关闭', index);
    };
    setText(!0);
    this.timer = setInterval(setText, 1000);
    if(timeNum <= 0) clearInterval(this.timer);
  }
  ,end: function(){
    clearInterval(this.timer);
  }
});
 </script>