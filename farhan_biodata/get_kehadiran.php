<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $query = "SELECT * FROM kehadiran WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID tidak diberikan']);
}
?> 