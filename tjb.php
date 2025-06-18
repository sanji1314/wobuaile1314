<?php
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
?>

<div class="container-fluid p-t-15">
  
  <div class="row">
    
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 15px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>今日销量排行榜</th>
                  <th>最新下单时间</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $a = $DB->query("SELECT ptname, COUNT(*) AS count, MAX(addtime) as latest_order_time FROM qingka_wangke_order where to_days(addtime) = to_days(now()) GROUP BY ptname order by count desc LIMIT 50");

                while ($rs = $DB->fetch($a)) {
                    $formatted_time = date('Y-m-d H:i:s', strtotime($rs['latest_order_time']));

                    echo "<tr>
                            <td>" . $rs['ptname'] . "</td>
                            <td>" . $formatted_time . "</td>
                          </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 15px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>昨日销量排行榜</th>
                  <th>最新下单时间</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $a = $DB->query("SELECT ptname, COUNT(*) AS count, MAX(addtime) as latest_order_time FROM qingka_wangke_order WHERE to_days(addtime) = to_days(now())-1 GROUP BY ptname ORDER BY count DESC LIMIT 50");

                while ($rs = $DB->fetch($a)) {
                    $formatted_time = date('Y-m-d H:i:s', strtotime($rs['latest_order_time']));

                    echo "<tr>
                            <td>" . $rs['ptname'] . "</td>
                            <td>" . $formatted_time . "</td>
                          </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 15px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>本周销量排行榜</th>
                  <th>最新下单时间</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $a = $DB->query("SELECT ptname, COUNT(*) AS count, MAX(addtime) AS last_order_time FROM qingka_wangke_order WHERE addtime >= DATE_FORMAT(NOW(), '%Y-%m-%d') - INTERVAL (WEEKDAY(NOW()) + 1) DAY GROUP BY ptname ORDER BY count DESC LIMIT 50");
                while ($rs = $DB->fetch($a)) {
                    echo "<tr>
                            <td>" . $rs['ptname'] . "</td>
                            <td>" . $rs['last_order_time'] . "</td>
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
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>