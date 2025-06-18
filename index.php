<?php 
    include 'confing/common.php';
    if ($conf["onlineStore_open"] == '1') {
        if (strpos($_SERVER['REQUEST_URI'], '?id=') !== false) {
            $id = $_GET['id'] ?? null;
            if ($id !== null) {
                echo '<script>window.location.href = "/index/components/onlineStore.php?id=' . htmlspecialchars($id) . '";</script>';
            } else {
                echo '<script>window.location.href = "/index/components/onlineStore.php";</script>';
            }
        } else {
            echo '<script>window.location.href = "/index/index";</script>';
        }
    } else {
        echo '<script>window.location.href = "/index/index";</script>';
    }
?>