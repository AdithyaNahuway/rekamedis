<?php

session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../otentikasi/index.php");
    exit();
}

require "../config.php";

// tambah data rekam medis
if (isset($_POST['simpan'])) {
    $no_rm     = $_POST['no_rm'];
    $tgl       = $_POST['tgl'];
    $idpasien  = $_POST['id'];
    $keluhan   = trim(htmlspecialchars($_POST['keluhan']));
    $dokter    = $_POST['dokter'];
    $diagnosa  = trim(htmlspecialchars($_POST['diagnosa']));
    $obat      = trim(htmlspecialchars($_POST['obat']));


 mysqli_query($koneksi, "INSERT INTO tbl_rekamedis VALUES ('$no_rm', '$tgl', '$idpasien', '$keluhan', $dokter, '$diagnosa', '$obat')");


 header('location: tambah-data.php?msg=added');
 return;

}

// hapus data
if (@$_GET['aksi'] == 'hapus-data') {
    $id = $_GET['id'];

    mysqli_query($koneksi, "DELETE FROM tbl_rekamedis WHERE no_rm = '$id'");

    header('location: index.php?msg=deleted');
    return;
}

if (isset($_POST['update'])) {
    $no_rm     = $_POST['no_rm'];
    $tgl       = $_POST['tgl'];
    $idpasien  = $_POST['id'];
    $keluhan   = trim(htmlspecialchars($_POST['keluhan']));
    $dokter    = $_POST['dokter'];
    $diagnosa  = trim(htmlspecialchars($_POST['diagnosa']));
    $obat      = trim(htmlspecialchars($_POST['obat']));

    // Validate id_pasien
    $checkQuery = "SELECT id FROM tbl_pasien WHERE id = '$idpasien'";
    $resultCheck = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($resultCheck) == 0) {
        die('Error: The patient ID does not exist.');
    }

    $updateQuery = "UPDATE tbl_rekamedis SET
                            tgl_rm = '$tgl',
                            id_pasien = '$idpasien',
                            keluhan   = '$keluhan',
                            id_dokter = '$dokter',
                            diagnosa  = '$diagnosa',
                            obat      = '$obat'
                         WHERE no_rm  = '$no_rm'";

    $result = mysqli_query($koneksi, $updateQuery);

    if (!$result) {
        die('Update Query Error: ' . mysqli_error($koneksi));
    }

    header('location: index.php?msg=updated');
    return;
}
