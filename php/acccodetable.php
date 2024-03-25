<?php
// ข้อมูลสำหรับการเชื่อมต่อฐานข้อมูล PostgreSQL
class accessDB {
    function connectDB($dbName) {  
        $dbconn = pg_pconnect("host='db01.nidec-copal.co.th' dbname='user_list' user='user_setup' password='user_setup'") or
        exit("Can not connect to Database !");
        return $dbconn;
    }
}

try {
    // สร้างอ็อบเจกต์ของคลาส accessDB
    $dbObj = new accessDB();

    // เชื่อมต่อกับฐานข้อมูล PostgreSQL โดยใช้อ็อบเจกต์ของคลาส accessDB
    $dbconn = $dbObj->connectDB($dbname);

    // คำสั่ง SQL เพื่อดึงข้อมูล
    $sql = "SELECT * FROM user_list";

    // ประมวลผลคำสั่ง SQL
    $result = pg_query($dbconn, $sql);

    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }

    // ดึงข้อมูลแบบ associative array
    $rows = pg_fetch_all($result);

    // แสดงข้อมูลในรูปแบบตาราง HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Uploaded At</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td></tr>";
    }
    echo "</table>";

    // ปิดการเชื่อมต่อ
    pg_close($dbconn);
} catch (Exception $e) {
    // กรณีเกิด error ในการเชื่อมต่อฐานข้อมูล
    echo "Error: " . $e->getMessage();
}
?>
