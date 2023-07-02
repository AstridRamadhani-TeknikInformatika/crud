<?php
include 'connection.php';

$connection = getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    $query = "UPDATE peminjaman_master SET status_peminjaman = 'DIKEMBALIKAN' WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();

    $query = "SELECT * FROM peminjaman_master WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $peminjamanMaster = $statement->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM peminjaman_detail WHERE id_peminjaman_master = :id";
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $peminjamanDetail = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($peminjamanMaster) {
        $response = [
            'status' => 'success',
            'peminjaman_master' => $peminjamanMaster,
            'peminjaman_detail' => $peminjamanDetail
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
        'message' => 'Terjadi kesalahan saat melakukan pengembalian buku: ' . $e->getMessage()
    ];
}

echo json_encode($response);

$connection = null;
?>