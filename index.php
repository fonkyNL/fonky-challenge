<?php
require_once('headers.php');
?>

    <body>
        <!-- Navbar section-->
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4">Fonky-challenge</span>
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
                    <li class="nav-item"><a href="#dashboard" class="nav-link">Dashboard</a></li>

                </ul>
            </header>
        </div>

        <!-- Datatable section -->
        <section class="container" id="dashboard">
            <h3 class="text-center">fonky-challenge</h3>
            <form id="upload_csv" method="post" enctype="multipart/form-data">
                <div class="bg-info text-center row justify-content-center align-items-center">
                    <div class="col-md-4">
                        <label>Add More Data</label>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" style="margin-top:15px;" />
                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-danger" />
                    </div>
                </div>
            </form>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Koper</th>
                            <th>Datum / tijd</th>
                            <th>Product</th>
                            <th>Vestiging / verkoper</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

        <!-- Footer -->
        <footer style="margin-top: 80vh;" class="p-5 bg-info  text-center position-relative">
            <div class="container">
                <p class="lead">Copyright &copy;
                    <?php echo date("Y"); ?> Mohamad Atwa</p>

                <!-- arrow-up-circle svg -->
                <a href="#" class="position-absolute bottom-0 end-0 p-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                      </svg>
                </a>
            </div>
        </footer>


        <!-- Ajax request to the php logic that imports csv as jsonData -->
        <script>
            $(document).ready(function() {
                $('#upload_csv').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: "import.php",
                        method: "POST",
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(jsonData) {
                            $('#csv_file').val('');
                            $('#data-table').DataTable({
                                data: jsonData,
                                columns: [{
                                    data: "id"
                                }, {
                                    data: "koper"
                                }, {
                                    data: "datum"
                                }, {
                                    data: "product"
                                }, {
                                    data: "vestiging"
                                }]
                            });
                        }
                    });
                });
            });
        </script>
    </body>

    </html>