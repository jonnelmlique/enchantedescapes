<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit(); 
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Promos</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/booking.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/promos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">

            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; Promos</h4>
                <hr>
                <br />

                <div class="row">
                    <div class="col-4">
                        <div class="card" style="border-radius: 8px; background-color: #FAEBD7">
                            <div class="card-header">Promo Form</div>
                            <div class="card-body">
                                <form action="insertpromo.php" method="post" class="needs-validation">

                                    <label for="promo-name">Promo Name</label>
                                    <input type="text" name="promo-name" placeholder="Promo Name" class="form-control"
                                        style="border-radius: 8px" required />

                                    <label for="percentage" class="mt-4">Percentage</label>
                                    <input type="number" name="percentage" placeholder="Percentage" class="form-control"
                                        style="border-radius: 8px" required />


                                    <label for="available" class="mt-4">Available</label>
                                    <input type="number" name="available" placeholder="Available" class="form-control"
                                        style="border-radius: 8px" required />
                            </div>
                            <div class="card-footer" align="center">
                                <button type="submit" class="btn btn-primary text-white text-uppercase">Save</button>
                                <button type="button" class="btn btn-secondary text-uppercase"
                                    onclick="window.history.back();">Cancel</button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-8">
                        <div align="right">
                            <input type="search" class="form-control w-auto" name="search" placeholder="Search"
                                style="border-radius: 8px" id="searchInput" />
                        </div>
                        <br />

                        <table class="table table-hover table-stripped border border-dark" style="border-radius: 8px"
                            id="promosearch">
                            <thead>
                                <tr>
                                    <td class="bg-dark text-white">Promo Name</td>
                                    <td class="bg-dark text-white">Percentage</td>
                                    <td class="bg-dark text-white">Available</td>

                                    <td class="bg-dark text-white">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../src/config/config.php';

                                $sql = "SELECT * FROM eespromo";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["promoname"] . "</td>";
                                        echo "<td>" . $row["percentage"] . "</td>";
                                        echo "<td>" . $row["available"] . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-success w-100' style='border-radius: 8px' onclick='populateModal(\"" . $row["promoname"] . "\", " . $row["percentage"] . ", " . $row["available"] . ", " . $row["promoid"] . ")' data-bs-toggle='modal' data-bs-target='#updateModal'>Edit</button><br />";
                                        echo "<button class='btn btn-danger w-100 mt-2' style='border-radius: 8px' onclick='confirmDelete(" . $row["promoid"] . ")'>Delete</button>";

                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr>
                                    <td colspan='4'>No promos found.</td>
                                </tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br /><br />
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header" align="center">
                    <h5 class="modal-title fw-bold">Update Promo Details</h5>
                </div>
                <div class="modal-body">
                    <form id="update-form">
                        <input type="hidden" name="promo-id" id="promo-id">
                        <label for="update-promo-name">Promo Name</label>
                        <input type="text" name="update-promo-name" id="update-promo-name" placeholder="Promo Name"
                            class="form-control" style="border-radius: 8px" />

                        <label for="update-percentage" class="mt-4">Percentage</label>
                        <input type="number" name="update-percentage" id="update-percentage" placeholder="Percentage"
                            class="form-control" style="border-radius: 8px" />

                        <label for="update-available" class="mt-4">Available</label>
                        <input type="number" name="update-available" id="update-available" placeholder="Available"
                            class="form-control" style="border-radius: 8px" required />
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn continue-btn" onclick="updatePromo()">Update</button>
                </div>
            </div>
        </div>
    </div>



    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: 'insertpromo.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.message === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Promo Added successfully.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to Add Promo.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while processing your request. Please try again later.'
                    });
                }
            });
        });
    });
    </script>
    <script>
    function populateModal(promoName, percentage, available, promoId) {
        $('#update-promo-name').val(promoName);
        $('#update-percentage').val(percentage);
        $('#update-available').val(available);
        $('#promo-id').val(promoId);
    }


    function updatePromo() {
        var promoId = $('#promo-id').val();
        var promoName = $('#update-promo-name').val();
        var percentage = $('#update-percentage').val();
        var available = $('#update-available').val();

        $.ajax({
            url: 'updatepromo.php',
            type: 'POST',
            data: {
                promoId: promoId,
                promoName: promoName,
                percentage: percentage,
                available: available
            },
            dataType: 'json',
            success: function(response) {
                if (response.message === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Promo Updated successfully.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update the promo.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while processing your request. Please try again later.'
                });
            }
        });
    }
    </script>
    <script>
    function confirmDelete(promoId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deletePromo(promoId);
            }
        });
    }

    function deletePromo(promoId) {
        $.ajax({
            url: 'deletepromo.php',
            type: 'POST',
            data: {
                promoid: promoId
            },
            success: function(response) {
                Swal.fire(
                    'Deleted!',
                    'Your promo has been deleted.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'Failed to delete promo.',
                    'error'
                );
            }
        });
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().trim();
            if (searchText !== '') {
                $.ajax({
                    url: 'searchpromo.php',
                    type: 'post',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        $('#promosearch tbody').html(response);
                    }
                });
            }
        });
    });
    </script>

</body>

</html>