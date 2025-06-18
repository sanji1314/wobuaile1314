<?php
$title='卡密管理';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
$uid=$_GET['uid'];
?>
    <div class="app-content-body">
  <div class="wrapper-md control" id="card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center mb-4 gap-3">
          <h4 class="mt-2">卡密列表</h4>
          <div class="ms-auto">
            <button class="btn btn-primary mt-2 px-4 mt-lg-0" data-toggle="modal" data-target="#modal-add">添加卡密</button>
            <button class="btn btn-primary mt-2 px-4 mt-lg-0" data-toggle="modal" @click="daochu()">导出卡密</button>
          </div>
        </div>
              <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
               <th scope="col">ID</th>
                    <th scope="col">卡号</th>
                    <th scope="col">卡密金额</th>
                    <th scope="col">使用者ID</th>
                    <th scope="col">添加时间</th>
                    <th scope="col">使用时间</th>
                    <th scope="col">状态</th>
                    <th scope="col">操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="res in row.data">
										<td>{{res.id}}</td>
										<td>{{res.content}}</td>
										<td>{{res.money}}</td>
										<td>{{res.uid}}</td>
                    <td>{{res.addtime}}</td>
                    <td>{{res.usedtime}}</td>
                    <td><span class="btn btn-success" v-if="res.status==1">已使用</span><span class="btn btn-danger" v-else-if="res.status==0">未使用</span></td>
                    <td>
                      <a href="javascript:void(0);" class="btn btn-danger btn-action" @click="del(res.id)">删除</i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
     <div class="modal fade primary" id="modal-add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">分类添加</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-add">
                            <input type="hidden" name="action" value="add"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">添加卡密</label>
                                <div class="col-sm-9">             
                                   <input type="text" v-model="addm.num" class="form-control" placeholder="请输入卡密数量">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">卡密金额</label>
                                <div class="col-sm-9">             
                                 <input type="text" v-model="addm.money" class="form-control" placeholder="请输入卡密金额">
                               </div>
                            </div>    
                         </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="add()">确定</button>
                    </div>
                </div>
            </div>
        </div>
  



<?php require_once("footer.php");?>	
<script src="js/bootstrap.bundle.min.js"></script>
<script>
const cardVm = new Vue({
  el: '#card',
  data: {
    row: {},
    addm: {
      num: '',
      money: '',
    },
  },
  methods: {
     
    get: function () {
      this.$http.post('/km.php?act=kmlist').then(function (data) {
        if (data.data.code == 1) {
          this.row = data.body
          this.$nextTick(function () {
            $('.preloader').fadeOut('slow')
          })
        } else {
          iziToast.error({
            title: data.data.msg,
            position: 'topRight',
          })
        }
      })
    },
add: function () {
  // 生成随机卡密
  function generateRandomKey() {
    const length = 16
    const characters =
      'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    let key = ''
    for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length)
      key += characters.charAt(randomIndex)
    }
    return key
  }

  for (let i = 0; i < this.addm.num; i++) {
    var load = layer.load(2)
    let content = generateRandomKey()
    this.$http
      .post(
        '/km.php?act=addkm',
        { content: content, money: this.addm.money },
        { emulateJSON: true }
      )
      .then(function (data) {
        layer.close(load)
        if (data.data.code == 1) {
          $('#modal-add').modal('hide')
          cardVm.get(1)
          layer.msg(data.data.msg, { icon: 1, time: 2000, offset: 't' })
        } else {
          layer.msg(data.data.msg, { icon: 2, time: 2000, offset: 't' })
        }
      })
  }
},
del: function (id) {
  layer.open({
    content: '您确定要删除该项吗？',
    btn: ['确认', '关闭'],
    yes: function (index, layero) {
      var load = layer.load(2);
      cardVm.$http
        .post('/km.php?act=deletekm', { id: id }, { emulateJSON: true })
        .then(function (data) {
          layer.close(load);
          if (data.data.code == 1) {
            cardVm.get();
            layer.close(index);
            layer.msg(data.data.msg, { icon: 1, time: 2000, offset: 't' });
          } else {
            layer.msg(data.data.msg, { icon: 2, time: 2000, offset: 't' });
          }
        });
    }
  });
},
  },
  created() {
    this.get()
  },
})

</script>