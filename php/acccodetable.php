<?php
// ข้อมูลสำหรับการเชื่อมต่อฐานข้อมูล PostgreSQL
class accessDB {
    function connectDB($dbName) {  
        $dbconn = pg_connect("host=localhost dbname=$dbName user=postgres password=postgres") or
        exit("Can not connect to Database !");

    }
}

try {
    // กำหนดชื่อฐานข้อมูลที่ต้องการเชื่อมต่อ
    $dbname = 'input_file';

    // สร้างอ็อบเจกต์ของคลาส accessDB
    $dbObj = new accessDB();

    // เชื่อมต่อกับฐานข้อมูล PostgreSQL โดยใช้อ็อบเจกต์ของคลาส accessDB
    $dbconn = $dbObj->connectDB($dbname);

    // คำสั่ง SQL เพื่อดึงข้อมูล
    $sql = "SELECT * FROM pdf_files";

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
        echo "<tr><td>".$row['id']."</td><td>".$row['uploaded_at']."</td></tr>";
    }
    echo "</table>";

    // ปิดการเชื่อมต่อ
    pg_close($dbconn);
} catch (Exception $e) {
    // กรณีเกิด error ในการเชื่อมต่อฐานข้อมูล
    echo "Error: " . $e->getMessage();
}
?>
