<?php
include "db_conn.php";
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="main p-3">
        <div class="text-center">
            <div class="container">
                <?php
                include "db_conn.php";
                // Include sidebar.php only if needed
                // include "sidebar.php";
                if (isset($_GET["msg"])) {
                    $msg = $_GET["msg"];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            ' . $msg . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                ?>
                <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080;">Admin</nav>
                <a href="add-admin.php" class="btn btn-warning mb-3">Add New</a>
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Password</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Department</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `admin_tbl`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row["adminID"] ?></td>
                                <td>
                                    <span class="masked-password"><?php echo str_repeat("*", strlen($row["password"])); ?></span>
                                    <span class="plain-password" style="display:none;"><?php echo $row["password"]; ?></span>
                                </td>
                                <td><?php echo $row["adminName"] ?></td>
                                <td><?php echo $row["email"] ?></td>
                                <td><?php echo $row["Department"] ?></td>
                                <td>
                                    <button class="btn-reveal-password"><i class="fa fa-eye fs-5" aria-hidden="true"></i></button>
                                    <a href="update-admin.php?id=<?php echo $row["adminID"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                    <a href="#" class="link-dark" onclick="openDeleteModal(<?php echo $row['adminID']; ?>)"><i class="fa-solid fa-trash fs-5"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this admin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="deleteButton" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <!-- Custom Script -->
    <script>
        document.querySelectorAll('.btn-reveal-password').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const maskedPassword = row.querySelector('.masked-password');
                const plainPassword = row.querySelector('.plain-password');

                if (maskedPassword.style.display === 'none') {
                    maskedPassword.style.display = 'inline';
                    plainPassword.style.display = 'none';
                } else {
                    maskedPassword.style.display = 'none';
                    plainPassword.style.display = 'inline';
                }
            });
        });

        function openDeleteModal(id) {
            var deleteButton = document.getElementById('deleteButton');
            var deleteUrl = 'remove_admin.php?id=' + id + '&table=admin-list&header=admin-list.php';
            deleteButton.setAttribute('href', deleteUrl);
            var bsModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            bsModal.show();
        }
    </script>
</body>

</html>
