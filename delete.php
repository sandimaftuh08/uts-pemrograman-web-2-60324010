<?php
require_once 'config/database.php';

// Validasi ID dari GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?pesan=notfound");
    exit();
}

$id = (int) $_GET['id'];

// Cek apakah data ada di database
$cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$cek->bind_param("i", $id);
$cek->execute();
$cek->store_result();

if ($cek->num_rows == 0) {
    header("Location: index.php?pesan=notfound");
    exit();
}
$cek->close();

// Proses delete
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header("Location: index.php?pesan=hapus");
} else {
    header("Location: index.php?pesan=error");
}

$stmt->close();
$conn->close();
exit();
?>