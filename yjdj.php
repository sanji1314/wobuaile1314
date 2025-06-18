<?php
$title = '对接管理';
require_once('head.php');
if ($userrow['uid'] != 1) {
    exit("<script language='javascript'>window.location.href='login.php';</script>");
}
?>
<style>
.form-row {
display:flex;
align-items:flex-end;
}
</style>
<style>
.form-row {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

@media (max-width: 768px) {
    .form-group {
        flex: 100%;
        margin-right: 0;
        margin-bottom: 10px;
    }
}
</style>

<div class="app-content-body">
    <div class="wrapper-md control" id="orderlist">
        <div class="panel panel-default">
            <div class="panel-heading font-bold layui-bg-black">万能对接插件</div>
            <div class="panel-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="keyword">选择货源</label>
                        <el-select id="select" v-model="cx.hid" filterable placeholder="选择货源" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
                            <el-option label="输入关键词搜索并选择货源" value=""></el-option>
                            <?php
                            $a = $DB->query("select * from qingka_wangke_huoyuan");
                            while ($row = $DB->fetch($a)) {
                                echo '<el-option label="' .'hid '.$row['hid'] .' '. $row['name'] . '" value="' . $row['hid'] . '"></el-option>';
                            }
                            ?>
                        </el-select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button class="btn btn-info btn-block" @click="checkBalance">查询货源余额</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn btn-info btn-block" @click="checkDeployedCount">查询货源已上架数</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="upstreamCategoryId">对接商品并上架</label>
                        <input type="text" class="form-control" v-model="upstreamCategoryId" placeholder="请输入上游分类ID">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="localCategoryId">&nbsp;</label>
                        <el-select id="localCategorySelect" v-model="localCategoryId" filterable placeholder="选择分类" style="width:100%">
                            <el-option label="选择上架分类" value=""></el-option>
                            <?php
                            $categories = $DB->query("select * from qingka_wangke_fenlei");
                            while ($row = $DB->fetch($categories)) {
                                echo '<el-option label="' .'ID '.$row['id'] .' '. $row['name'] . '" value="' . $row['id'] . '"></el-option>';
                            }
                            ?>
                        </el-select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="markupMultiplier">&nbsp;</label>
                        <input type="text" class="form-control" v-model="markupMultiplier" placeholder="加价">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="multiplyByFive">&nbsp;</label>
                        <select class="form-control" v-model="multiplyByFive">
                            <option value="2">乘法计算且乘5(29)</option>
                            <option value="1">乘法计算且不乘5(暗网)</option>
                            <option value="0">加法计算直接加价</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="skipExisting">&nbsp;</label>
                        <select class="form-control" v-model="skipExisting">
                            <option value="1">跳过已有商品</option>
                            <option value="0">不跳过</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary form-control" @click="startIntegration">开始对接商品(分类)</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="startId">按CID上架(自定义范围)</label>
                        <input type="text" class="form-control" v-model="startId" placeholder="请输入上游起始CID">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="endId">&nbsp;</label>
                        <input type="text" class="form-control" v-model="endId" placeholder="请输入上游结束CID">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="localCategoryIdForRange">&nbsp;&nbsp;</label>
                        <el-select id="localCategorySelectForRange" v-model="localCategoryIdForRange" filterable placeholder="选择分类" style="width:100%">
                            <el-option label="选择上架分类" value=""></el-option>
                            <?php
                            $categories = $DB->query("select * from qingka_wangke_fenlei");
                            while ($row = $DB->fetch($categories)) {
                                echo '<el-option label="' .'ID '.$row['id'] .' '. $row['name'] . '" value="' . $row['id'] . '"></el-option>';
                            }
                            ?>
                        </el-select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="markupMultiplierForRange">&nbsp;</label>
                        <input type="text" class="form-control" v-model="markupMultiplierForRange" placeholder="加价">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="multiplyByFiveForRange">&nbsp;</label>
                        <select class="form-control" v-model="multiplyByFiveForRange">
                            <option value="2">乘法计算且乘5(29)</option>
                            <option value="1">乘法计算且不乘5(暗网)</option>
                            <option value="0">加法计算直接加价</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary form-control" @click="startIntegrationByRange">开始对接商品(CID)</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="upstreamCategoryIdForPrice">更新商品信息</label>
                        <input type="text" class="form-control" v-model="upstreamCategoryIdForPrice" placeholder="默认全部更新,可填写上游分类ID指定更新">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="priceRatio"></label>
                        <input type="text" class="form-control" v-model="priceRatio" placeholder="加价">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="multiplyByFiveForPrice"></label>
                        <select class="form-control" v-model="multiplyByFiveForPrice">
                            <option value="2">乘法计算且乘5(29)</option>
                            <option value="1">乘法计算且不乘5(暗网)</option>
                            <option value="0">加法计算直接加价</option>
                            <option value="3">不更新价格只更新介绍</option>
                            <option value="4">不更新价格只更新介绍和商品名</option>
                            <option value="5">同步上游下架商品（不会删除）</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-danger form-control" @click="updatePrice">更新价格</button>
                    </div>
                </div>
                <div class="form-row mt-4"> 
                    <div class="form-group col-md-3">
                        <label for="oldKeyword">批量对关键词进行替换</label>
                        <input type="text" class="form-control" v-model="oldKeyword" placeholder="请输入要替换的关键词">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="newKeyword" placeholder="请输入替换后的关键词,留空删除关键词">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="effectScope">
                            <option value="category">分类ID=</option>
                            <option value="docking">对接平台ID=</option>
                            <option value="all">对所有范围执行</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="scopeId" placeholder="请输入分类ID或对接平台ID" :disabled="effectScope === 'all'">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="updateKeywords">更新关键词</button>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-3">
                        <label for="prefix">批量对商品添加前缀</label>
                        <input type="text" class="form-control" v-model="prefix" placeholder="请输入要新增的前缀">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="prefixEffectScope">
                            <option value="category">分类ID=</option>
                            <option value="docking">对接平台ID=</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="prefixScopeId" placeholder="请输入分类ID或对接平台ID">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="addPrefix">添加前缀</button>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-3">
                        <label for="deleteDuplicateScope">删除重复商品</label>
                        <select class="form-control" v-model="deleteDuplicateScope">
                            <option value="all">所有范围</option>
                            <option value="category">分类ID=</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="deleteDuplicateScopeId" placeholder="请输入分类ID" :disabled="deleteDuplicateScope === 'all'">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="deleteDuplicateStrategy">
                            <option value="keep_larger">保留CID更大的商品</option>
                            <option value="keep_smaller">保留CID更小的商品</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="deleteDuplicates">删除重复商品</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
<script src="assets/js/element.js"></script>
<script>
new Vue({
  el: "#orderlist",
  data: {
    cx: {
        hid: ""
    },
    upstreamCategoryId: '',
    localCategoryId: '',
    markupMultiplier: '',
    multiplyByFive: '2',
    skipExisting: '1',
    upstreamCategoryIdForPrice: '',
    priceRatio: '',
    multiplyByFiveForPrice: '2',
    oldKeyword: '',
    newKeyword: '',
    effectScope: 'all',
    scopeId: '',
    prefix: '',
    prefixEffectScope: 'category',
    prefixScopeId: '',
    startId: '', 
    endId: '', 
    localCategoryIdForRange: '', 
    markupMultiplierForRange: '', 
    multiplyByFiveForRange: '2',
    deleteDuplicateScope: 'all',
    deleteDuplicateScopeId: '',
    deleteDuplicateStrategy: 'keep_larger'
  },
  methods: {
  checkBalance: function() {
                if (!this.cx.hid) {
                    layer.msg('请选择货源', { icon: 2 });
                    return;
                }
                var load = layer.load(2);
                this.$http.post("/apisub.php?act=checkbalance", {
                    hid: this.cx.hid
                }, { emulateJSON: true }).then(function(data) {
                    layer.close(load);
                    if (data.data.code == 1) {
                        layer.alert(
                            data.data.msg,
                            { icon: 1, title: "信息" },
                            function () {
                                setTimeout(function () {
                                    window.location.href = "";
                                }, 500);
                            }
                        );
                    } else {
                        layer.msg(data.data.msg, { icon: 2 });
                    }
                });
            },
            checkDeployedCount: function() {
                if (!this.cx.hid) {
                    layer.msg('请选择货源', { icon: 2 });
                    return;
                }
                var load = layer.load(2);
                this.$http.post("/apisub.php?act=checkdeployedcount", {
                    hid: this.cx.hid
                }, { emulateJSON: true }).then(function(data) {
                    layer.close(load);
                    if (data.data.code == 1) {
                        layer.alert(
                            data.data.msg,
                            { icon: 1, title: "信息" },
                            function () {
                                setTimeout(function () {
                                    window.location.href = "";
                                }, 500);
                            }
                        );
                    } else {
                        layer.msg(data.data.msg, { icon: 2 });
                    }
                });
            },startIntegration: function() {
    if (!this.cx.hid) {
      layer.msg('请选择货源接口', {icon: 2});
      return;
    }
    if (!this.upstreamCategoryId) {
      layer.msg('请输入上游分类ID', {icon: 2});
      return;
    }
    if (!this.localCategoryId) {
      layer.msg('请输入站内分类ID', {icon: 2});
      return;
    }
    if (!this.markupMultiplier) {
      layer.msg('请输入加价', {icon: 2});
      return;
    }

    var load = layer.load(2);
    this.$http.post("/apisub.php?act=startintegration", {
      hid: this.cx.hid,
      upstreamCategoryId: this.upstreamCategoryId,
      localCategoryId: this.localCategoryId,
      markupMultiplier: this.markupMultiplier,
      multiplyByFive: this.multiplyByFive,
      skipExisting: this.skipExisting
    }, {emulateJSON: true}).then(function(data) {
      layer.close(load);
      if (data.data.code == 1) {
        layer.msg(data.data.msg, {icon: 1});
      } else {
        layer.msg(data.data.msg, {icon: 2});
      }
    });
  },
  updatePrice: function() {
    if (!this.cx.hid) {
      layer.msg('请选择货源接口', {icon: 2});
      return;
    }
    var load = layer.load(2);
    this.$http.post("/apisub.php?act=updateprice", {
      hid: this.cx.hid,
      upstreamCategoryId: this.upstreamCategoryIdForPrice,
      priceRatio: this.priceRatio,
      multiplyByFive: this.multiplyByFiveForPrice
    }, {emulateJSON: true}).then(function(data) {
      layer.close(load);
      if (data.data.code == 1) {
        layer.msg(data.data.msg, {icon: 1});
      } else {
        layer.msg(data.data.msg, {icon: 2});
      }
    });
  },
  updateKeywords: function() {
    if (!this.oldKeyword) {
      layer.msg('请输入要替换的关键词', {icon: 2});
      return;
    }
    if (this.effectScope !== 'all' && !this.scopeId) {
      layer.msg('请输入分类ID或对接平台ID', {icon: 2});
      return;
    }

    var load = layer.load(2);
    this.$http.post("/apisub.php?act=updatekeywords", {
      oldKeyword: this.oldKeyword,
      newKeyword: this.newKeyword,
      effectScope: this.effectScope,
      scopeId: this.scopeId
    }, {emulateJSON: true}).then(function(data) {
      layer.close(load);
      if (data.data.code == 1) {
        layer.msg(data.data.msg, {icon: 1});
      } else {
        layer.msg(data.data.msg, {icon: 2});
      }
    });
},
addPrefix: function() {
      if (!this.prefix) {
        layer.msg('请输入要新增的前缀', {icon: 2});
        return;
      }
      if (!this.prefixScopeId) {
        layer.msg('请输入分类ID或对接平台ID', {icon: 2});
        return;
      }

      var load = layer.load(2);
      this.$http.post("/apisub.php?act=addprefix", {
        prefix: this.prefix,
        prefixEffectScope: this.prefixEffectScope,
        prefixScopeId: this.prefixScopeId
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    deleteDuplicates: function() {
      if (this.deleteDuplicateScope !== 'all' && !this.deleteDuplicateScopeId) {
        layer.msg('请输入分类ID或对接接口ID', {icon: 2});
        return;
      }
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=deleteDuplicates", {
        scope: this.deleteDuplicateScope,
        scopeId: this.deleteDuplicateScopeId,
        strategy: this.deleteDuplicateStrategy
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
startIntegrationByRange: function() {
      if (!this.cx.hid) {
        layer.msg('请选择货源接口', {icon: 2});
        return;
      }
      if (!this.startId) {
        layer.msg('请输入上架起始ID', {icon: 2});
        return;
      }
      if (!this.endId) {
        layer.msg('请输入上架结束ID', {icon: 2});
        return;
      }
      if (!this.localCategoryIdForRange) {
        layer.msg('请输入上架分类ID', {icon: 2});
        return;
      }
      if (!this.markupMultiplierForRange) {
        layer.msg('请输入加价', {icon: 2});
        return;
      }

      var load = layer.load(2);
      this.$http.post("/apisub.php?act=startintegrationbyrange", {
        hid: this.cx.hid,
        startId: this.startId,
        endId: this.endId,
        localCategoryId: this.localCategoryIdForRange,
        markupMultiplier: this.markupMultiplierForRange,
        multiplyByFive: this.multiplyByFiveForRange
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    }
  }
});
</script>