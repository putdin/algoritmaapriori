<?php
$conn = mysqli_connect('localhost', 'root', 'hteeshy28', 'dm_apriori');
if (isset($_POST['inputProduk'])) {
    $produk     = $_POST['produk'];
    $harga      = $_POST['harga'];
    $ekstensi_diperbolehkan    = array('png', 'jpg', 'jpeg', 'JPG');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran    = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $cekProduk = mysqli_query($conn, "SELECT * FROM `tbl_produk` WHERE produk LIKE '%" . $produk . "%' ");
    if (mysqli_num_rows($cekProduk) > 0) {
        $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf !</strong>Produk ' . $produk . ' Sudah Ada.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        if (empty($nama)) {
            $input = mysqli_query($conn, "INSERT INTO `tbl_produk`(`produk`,`harga`) VALUES ('$produk','$harga')");
            if ($input) {
                $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> Menginput data Produk ' . $produk . '.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            } else {
                $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal !</strong> Terjadi Kesalahan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            }
        } else {
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if ($ukuran < 1044070) {
                    move_uploaded_file($file_tmp, 'file/' . $nama);
                    $input = mysqli_query($conn, "INSERT INTO `tbl_produk`(`produk`,`harga`,`foto`) VALUES ('$produk','$harga','$nama')");
                    if ($input) {
                        $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> Menginput data Produk ' . $produk . '.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    } else {
                        $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal !</strong> Terjadi Kesalahan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                } else {
                    $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal !</strong> UKURAN FILE TERLALU BESAR.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
            } else {
                $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            }
        }
    }
} else
if (isset($_POST['edit'])) {
    $id_produk  = $_POST['id_produk'];
    $produk     = $_POST['produk'];
    $harga      = $_POST['harga'];
    $ekstensi_diperbolehkan    = array('png', 'jpg', 'jpeg', 'JPG');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran    = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    if (empty($nama)) {
        $edit = mysqli_query($conn, "UPDATE `tbl_produk` SET `produk`='$produk', `harga`='$harga' 
                                                WHERE id_produk='$id_produk' ");
        if ($edit) {
            $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Mengubah data Produk ' . $produk . '.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        } else {
            $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal !</strong> Terjadi Kesalahan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    } else {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070) {
                move_uploaded_file($file_tmp, 'file/' . $nama);
                $edit = mysqli_query($conn, "UPDATE `tbl_produk` SET `produk`='$produk', `harga`='$harga', foto='$nama'  
                                                WHERE id_produk='$id_produk' ");
                if ($edit) {
                    $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Mengubah data Produk ' . $produk . '.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                } else {
                    $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal !</strong> Terjadi Kesalahan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                }
            } else {
                $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal !</strong> UKURAN FILE TERLALU BESAR.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }
        } else {
            $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal !</strong> EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }
} else {
    $pesan = '';
}
if ($_SESSION['apriori_level'] == "2") {
    $insert = '';
} else {
    $insert = '<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Input Produk
    </button><br><br>';
}
echo $insert;
?>

<?php
if (!empty($pesan)) {
    echo $pesan;
}
?>
<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Daftar Tanaman Penjualan</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-info text-white">
                <tr>
                    <th>No</th>
                    <th>Tanaman</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['edit'])) {
                    $id_produk  = $_POST['id_produk'];
                    $data = mysqli_query($conn, "SELECT * FROM `tbl_produk` WHERE id_produk='$id_produk' ");
                } else {
                    $data = mysqli_query($conn, "SELECT * FROM `tbl_produk`");
                }
                $no = 1;
                while ($row = mysqli_fetch_array($data)) {
                    if ($_SESSION['apriori_level'] == "1") {
                        $edit = '<a class="btn btn-success" title="Edit" href="#editProduk" data-toggle="modal" data-id="' . $row['id_produk'] . '">Edit</a>';
                        $hapus = ' <a onClick=\'return confirm("Anda Yakin Menghapus Produk Ini?")\' href="index.php?hapusProduk=' . $row['id_produk'] . '" class="btn btn-danger">Delete</a>';
                    } else {
                        $edit = 'None';
                        $hapus = 'None';
                    }
                    echo '<tr>
                        <td>' . $no . '</td>
                        <td>' . $row['produk'] . '</td>
                        <td>' . "Rp" . number_format($row['harga'], 0, ',', '.') . '</td>
                        <td>' . "<img src='file/" . $row['foto'] . "' width='180px' height='180px'>" . '</td>
                        <td>
                        ' . $edit . '' . $hapus . '
                        </td>
                    </tr>';
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Data Tanaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanaman Baru</label>
                        <input type="text" name="produk" id="" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" name="harga" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">File</label>
                        <input type="file" name="file" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="inputProduk" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit  -->
<div class="modal fade" id="editProduk" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Update Tanaman</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="data-produk"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">
                        Simpan</button>
                    <button type="button" class="btn btn-danger" name="reset" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal edit -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    //select edit data 
    $(document).ready(function() {
        $('#editProduk').on('show.bs.modal', function(e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: 'view/editProduk.php',
                data: 'idx=' + idx,
                success: function(data) {
                    $('.data-produk').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    //end select data
</script>