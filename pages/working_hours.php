<?php

include('../init.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Working Hours</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
			<script src="<?= get_assets() ?>js/html5shiv.min.js"></script>
			<script src="<?= get_assets() ?>js/respond.min.js"></script>
		<![endif]-->


    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php include_once HEADER; ?>
        <!-- /Header -->

        <!-- Sidebar -->
        <?php include_once SIDEBAR; ?>
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Working Hours</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Working Hours</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <div class="input-group date" id="datepicker">
                                <input type="text" class="form-control" placeholder="Select date">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <label for="datepicker" class="focus-label">Select Date:</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" id="team_filter">
                                <option value="0">Select Team</option>
                                <?php $res = get_all_team_details($DB);

                                foreach ($res as $row) {
                                    echo '<option value="' . $row['team_id'] . '">' . $row['team_name'] . '</option>';
                                }
                                ?>
                            </select>
                            <label class="focus-label">Team</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating">
                                <option value="0">Not Working</option>
                                ?>
                            </select>
                            <label class="focus-label">Active Status</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="#" class="btn btn-success btn-block" id="filter_search_btn"> Search </a>
                    </div>

                </div>

                <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table" id="working_hours">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Full Name</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Total Time</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?= get_assets() ?>js/popper.min.js"></script>
    <script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="<?= get_assets() ?>js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="<?= get_assets() ?>js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="<?= get_assets() ?>js/moment.min.js"></script>

    <script src="<?= get_assets() ?>js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="<?= get_assets() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= get_assets() ?>js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>

    <?php include_once FOOTER; ?>



    <script>
        $(function() {
            $('#datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                viewMode: 'days',
                ignoreReadonly: true,
                allowInputToggle: true,
                defaultDate: moment()
            });
        });


        function mytable() {
            var filter_date = $('#datepicker').find('input').val();
            var filter_team = $('#team_filter').val();
            console.log(filter_date);
            var dataTable = $('#working_hours').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": false,
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [10, 20, 50, 1000],
                    [10, 20, 50, "All"]
                ],
                "responsive": true,
                "ordering": false,
                "iDisplayLength": 10,
                "paging": true, // Enable pagination
                "pageLength": 10, // Set number of rows per page
                "rowCallback": function(nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 1, 2, 3]
                    },
                    {
                        "orderable": true,
                        "targets": []
                    }
                ],
                "lengthMenu": [
                    [10, 50, 200, 1000, -1],
                    [10, 50, 200, 1000, "All"]
                ],
                "language": {
                    "emptyTable": "No Data Found",
                },

                "ajax": {
                    url: "./action/working_hours.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        filter_date: filter_date,
                        filter_team: filter_team,
                    },
                    error: function() { // error handling
                        $(".patient_master_table-error").html("");
                        $("#working_hours").append('<tbody class="patient_master_table-error"><tr><th colspan="8" style="text-align: center;">No User Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    }
                },
                bDestroy: true,
            });

            $('#search').keyup(function() {
                dataTable.search($(this).val()).draw();
            });


        };

        mytable();


        $('#datepicker').on('dp.change', function(e) {
            // Get the selected date
            var selectedDate = e.date.format('YYYY-MM-DD');
            console.log('Selected Date:', selectedDate);
            mytable()
        });

        $('#team_filter').on('change', function() {
            mytable();
        })


        $('#filter_search_btn').on('click', function() {
            mytable();
        })
    </script>
</body>

</html>