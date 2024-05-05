<?php
session_start();

include './src/config/config.php';
if (!isset($_SESSION['data_inserted'])) {
    $sql = "INSERT INTO guestusers () VALUES ()";
    if ($conn->query($sql) === TRUE) {
        $sql_select = "SELECT guestuserid FROM guestusers ORDER BY timestamp_column DESC LIMIT 1";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guestuserid = $row['guestuserid'];
            $_SESSION['guestuserid'] = $guestuserid;
            $_SESSION['data_inserted'] = true;
        } else {
        }
    } else {
    }
}
$conn->close();
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Search</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/dashboard.css" rel="stylesheet" />
    <link href="./styles/scrollbar.css" rel="stylesheet" />
    <link href="./styles/searchstatus.css" rel="stylesheet" />

</head>


<div> <?php include ("componentshome/navbar.php"); ?>


    <div class="container about-us">
        <section class="about-section">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control form-control-lg" id="searchBar"
                        placeholder="Search by Transaction ID...">
                </div>
            </div>
            <p id="searchResult"></p>
        </section>
    </div>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <!-- <script>
    $(document).ready(function() {
        // Function to handle search
        $('#searchBar').keyup(function() {
            var searchText = $(this).val();
            if (searchText != '') {
                $.ajax({
                    url: 'searchreservation.php', // Your PHP file to handle the search
                    method: 'post',
                    data: {
                        query: searchText
                    },
                    success: function(response) {
                        $('#searchResult').html(response);
                    }
                });
            } else {
                $('#searchResult').html('');
            }
        });
    });
    </script> -->
    <script>
    $(document).ready(function() {
        $('#searchBar').keyup(function(event) {
            if (event.keyCode === 13) {
                var searchText = $(this).val().trim();
                if (searchText != '') {
                    window.location.href = 'reservationstatusdetails.php?transactionid=' + searchText;
                }
            }
        });
    });
    </script>

    <?php include ("components/footer.php"); ?>
    </body>

    </html>