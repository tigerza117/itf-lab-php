<?php

if (!isset($_POST['id']) || empty($_POST['id']) || !isset($_POST['name']) || !isset($_POST['comment']) || !isset($_POST['link']) || empty($_POST['name']) || empty($_POST['comment']) || empty($_POST['link'])) {
    echo json_encode([
        'code' => 400,
        'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน',
    ]);
    return;
}

require 'connections.php';

$id = $_POST['id'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$link = $_POST['link'];

$stmt = $conn->prepare("UPDATE guestbook SET Name = :name, Comment = :comment, Link = :link WHERE ID=:id");
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':comment', $comment);
$stmt->bindParam(':link', $link);

if ($stmt->execute()) {
    echo json_encode([
        'code' => 200,
        'message' => 'สำเร็จ',
    ]);
} else {
    echo json_encode([
        'code' => 500,
        'message' => "Error: SQL",
    ]);
}

mysqli_close($conn);