<?php

include_once '../init.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page</title>

    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->

    <style>
        .authentication-bg {
            background-color: #fff;
        }
    </style>
</head>

<body data-layout="horizontal" data-topbar="dark">
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="home-wrapper text-center">
                        <div>
                            <div class="row justify-content-center">
                                <div class="col-sm-9">
                                    <div class="error-img">
                                        <img src="<?= get_img() ?>3804918.jpg" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-uppercase mt-5">Sorry, page not found</h4>
                        <p class="text-muted">It will be as simple as Accidental in fact, it will be Accidental</p>
                        <div class="mt-2">
                            <a class="btn btn-primary waves-effect waves-light" href="https://hrm.saaol.com">Back to Dashboard</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end authentication section -->

</body>

</html>