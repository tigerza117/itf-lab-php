<?php

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode([
        'code' => 400,
        'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน',
    ]);
    return;
}

$conn = mysqli_init();
mysqli_real_connect($conn, '63070092-db.mysql.database.azure.com', 'tigerza117@63070092-db', '0880880880Za', 'itflab', 3306);
if (mysqli_connect_errno($conn)) {
    echo json_encode([
        'code' => 500,
        'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error(),
    ]);
    return;
}

$id = $_POST['id'];

$sql = "DELETE FROM guestbook WHERE ID='$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        'code' => 200,
        'message' => 'สำเร็จ',
    ]);
} else {
    echo json_encode([
        'code' => 500,
        'message' => "Error: " . $sql . "<br>" . mysqli_error($conn),
    ]);
}

mysqli_close($conn);