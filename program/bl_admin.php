<?php

    include("config.php");
    session_start();

    if(!isset($_SESSION["login"]))
    {
        header("location: signin.php");
        exit;
    }
    if(!isset($_SESSION["admin"]))
    {
        header("location: signout.php");
    }

    // Proses Update ID PM ke tabel mahasiswa dan Status_lolos pada tabel mengikuti 
    if(isset($_GET['id_mhs']) && isset($_GET['id_dosen']) && isset($_GET['id_mengikuti']))
    {
        $id_mhs = $_GET['id_mhs'];
        $id_dosen = $_GET['id_dosen'];
        $id_mengikuti = $_GET['id_mengikuti'];
    }
    if(isset($id_mhs) && isset($id_dosen))
    {
        $update_pm = mysqli_query($conn, "UPDATE mhs SET id_pm = '$id_dosen' WHERE id_mhs = '$id_mhs'");
        $update_status = mysqli_query($conn, "UPDATE mengikuti SET status_lolos = 'Sudah Lolos' WHERE id_mengikuti = '$id_mengikuti'");

        if(mysqli_affected_rows($conn) > 0)
        {
            echo "<script>
                alert('Mahasiswa Berhasil Lolos!');
                window.location = 'bl_admin.php';
            </script>";
        }
    }

    $mahasiswa = mysqli_query($conn, "SELECT file_lolos, id_mengikuti, status_lolos, mhs.id_pm, mhs.id_mhs, nim, nama_mhs, semester, nama_program, file_lolos FROM mhs JOIN mengikuti ON mhs.id_mhs = mengikuti.id_mhs JOIN program ON program.id_program = mengikuti.id_program WHERE file_lolos != 'NULL' ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="css/style2.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>SI_MBKM</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/dummy.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Admin</h6>
                        
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="db_admin.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="bl_admin.php" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Bukti Lolos</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height: 55px;">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="signout.php" style="color: #000000; font-weight: 600; letter-spacing: 0.5px;">SIGN OUT</a>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Tabel Cek Bukti Lolos</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">NIM</th>
                                            <th scope="col">Nama Mahasiswa</th>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Nama Program</th>
                                            <th scope="col">Bukti Lolos</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                            $nomor = 1;
                                            while($result = mysqli_fetch_assoc($mahasiswa)){

                                        ?>
                                        <tr>
                                            <th scope="row"><?= $nomor ?></th>
                                            <td><?= $result["nim"] ?></td>
                                            <td><?= $result["nama_mhs"] ?></td>
                                            <td><?= $result["semester"] ?></td>
                                            <td><?= $result["nama_program"] ?></td>
                                            <td><a href="download.php?file_name=<?= $result['file_lolos'] ?>"><?= $result["file_lolos"] ?></a></td>
                                            <?php
                                            if($result["status_lolos"] == "Belum Dikonfirmasi")
                                            {
                                                echo "<td><a href='bl_pa_admin.php?id_mhs=" . $result['id_mhs'] . "& id_pm=" . $result['id_pm'] . "& id_mengikuti=" . $result['id_mengikuti'] . "'>ACC</a></td>";
                                            }
                                            else
                                            {
                                                echo "<td><span>Sudah Lolos</span></td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        
                                                $nomor++;
                                            }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>