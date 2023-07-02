<?php
include 'connection.php';

$connection = getConnection();

$id_peminjaman = isset($_GET['id']) ? $_GET['id'] : '';

try {
    $query = "SELECT * FROM peminjaman_master WHERE id = :id";

    $statement = $connection->prepare($query);

    $statement->bindParam(':id', $id_peminjaman);

    $statement->execute();

    $peminjaman_master = $statement->fetch(PDO::FETCH_ASSOC);

    if ($peminjaman_master) {
        $query = "SELECT * FROM peminjaman_detail WHERE id_peminjaman_master = :id";

        $statement = $conn->prepare($query);

        $statement->bindParam(':id', $id_peminjaman);

        $statement->execute();

        $peminjaman_detail = $statement->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            'status' => 'success',
            'peminjaman_master' => $peminjaman_master,
            'peminjaman_detail' => $peminjaman_detail
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Data peminjaman tidak ditemukan'
        ];
    }
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat mengambil data peminjaman: ' . $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

$conn = null;
?>