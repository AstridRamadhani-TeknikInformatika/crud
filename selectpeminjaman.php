<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'connection.php';

$connection = getConnection();

// Mendapatkan data yang dikirim melalui metode GET
$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    // Query SQL untuk memilih data peminjaman_master berdasarkan ID
    $query = "SELECT * FROM peminjaman_master WHERE id = :id";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $connection->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);

    // Eksekusi statement
    $statement->execute();

    // Mendapatkan hasil seleksi peminjaman_master
    $peminjamanMaster = $statement->fetch(PDO::FETCH_ASSOC);

    // Query SQL untuk memilih data peminjaman_detail berdasarkan ID peminjaman_master
    $query = "SELECT * FROM peminjaman_detail WHERE id_peminjaman_master = :id";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $connection->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);

    // Eksekusi statement
    $statement->execute();

    // Mendapatkan hasil seleksi peminjaman_detail
    $peminjamanDetail = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Mengirimkan response dengan data peminjaman_master dan peminjaman_detail
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
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memilih data peminjaman: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$connection = null;
?>