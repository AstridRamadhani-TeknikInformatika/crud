<?php
include 'connection.php';

// Fungsi untuk melakukan pengembalian buku
function pengembalianBuku($idPeminjaman, $tanggalPengembalian)
{
    global $connection;
    $tanggalPengembalian = date('Y-m-d', strtotime($tanggalPengembalian));

    // Cek apakah peminjaman dengan ID tersebut ada
    $query = "SELECT * FROM peminjaman_master WHERE id = '$idPeminjaman'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 0) {
        return "Peminjaman dengan ID $idPeminjaman tidak ditemukan";
    }

    // Cek apakah peminjaman sudah dikembalikan sebelumnya
    $row = mysqli_fetch_assoc($result);
    if ($row['tanggal_pengembalian'] != NULL) {
        return "Peminjaman dengan ID $idPeminjaman sudah dikembalikan pada tanggal " . $row['tanggal_pengembalian'];
    }

    // Hitung durasi keterlambatan
    $tanggalPeminjaman = $row['tanggal_peminjaman'];
    $durasiKeterlambatan = max(0, strtotime($tanggalPengembalian) - strtotime($tanggalPeminjaman));
    $durasiKeterlambatan = ceil($durasiKeterlambatan / (60 * 60 * 24));

    // Update data peminjaman
    $query = "UPDATE peminjaman_master SET tanggal_pengembalian = '$tanggalPengembalian', durasi_keterlambatan = '$durasiKeterlambatan' WHERE id = '$idPeminjaman'";
    mysqli_query($connection, $query);

    return "Peminjaman dengan ID $idPeminjaman berhasil dikembalikan pada tanggal $tanggalPengembalian";
}

// API endpoint untuk pengembalian buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    $idPeminjaman = $requestData['id_peminjaman'];
    $tanggalPengembalian = $requestData['tanggal_pengembalian'];

    $response = array();
    if (empty($idPeminjaman) || empty($tanggalPengembalian)) {
        $response['status'] = 'error';
        $response['message'] = 'ID peminjaman dan tanggal pengembalian harus diisi';
    } else {
        $response['status'] = 'success';
        $response['message'] = pengembalianBuku($idPeminjaman, $tanggalPengembalian);
    }

    echo json_encode($response);
}
?>