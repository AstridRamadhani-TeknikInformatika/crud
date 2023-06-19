<?php

include 'connection.php';

$connection = getConnection();


$id = isset($_POST['id']) ? $_POST['id'] : '';
$kode = isset($_POST['kode']) ? $_POST['kode'] : '';
$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';


try {

    $query = "UPDATE kategori SET id = :id, kode = :kode, kategori = :kategori WHERE kode = :kode";


    $statement = $connection->prepare($query);


    $statement->bindParam(':id', $id);
    $statement->bindParam(':kode', $kode);
    $statement->bindParam(':kategori', $kategori);


    $statement->execute();


    $response = [
        'status' => 'success',
        'message' => 'Data kategori berhasil diupdate'
    ];
} catch (PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memperbarui data kategori: ' . $e->getMessage()
    ];
}


echo json_encode($response);


$connection = null;
?>