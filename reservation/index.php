<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Home</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/dashboard.css" rel="stylesheet" />
    <link href="./styles/scrollbar.css" rel="stylesheet" />
</head>


<div> <?php include ("componentshome/navbar.php"); ?>
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
    ?>

    <div class="bg-white">
        <br /><br />
        <div class="container">
            <h1 class="display-2 fw-bold text-uppercase">Enchanted Escapes Hotel</h1>
            <p class="text-primary text-uppercase fw-bold">Rooms // Suites // Presidential Suites</p>
            <br />

            <div class="w-100 d-block">
                <!-- <a href="book-now.php"><button class="btn btn-primary position-absolute text-uppercase py-4"
                        style="right: 304px; padding-left: 64px; padding-right: 64px">Book Now</button></a> -->
                <img src="assets/home-bg.jpg" width="100%" />
            </div>
            <br /><br /><br />

            <h1 class="display-3 text-primary text-uppercase" style="font-family: 'Gideon Roman'; font-weight: 600">
                Rooms <span class="display-6" style="font-family: 'Dancing Script'; font-weight: 600">et</span> Suites
            </h1>
            <br />

            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <ul id="carouselList" <ul id="carouselList"
                            class="list-group list-group-horizontal position-relative overflow-hidden w-100">
                            <li class="list-group-item border-0 rooms">
                                <img src="assets/standard-room.jpg" width="100%" class="p-4 rounded" />
                                <div align="center">
                                    <h4 class="fw-bold">Standard</h4>
                                    <p style="font-family: 'Arial'">Standard rooms offer comfortable accommodation with
                                        modern amenities. Each room is equipped with a cozy bed, workspace, and private
                                        bathroom. Perfect for solo travelers or couples looking for a convenient stay.
                                    </p>
                                </div>
                            </li>
                            <li class="list-group-item border-0 rooms">
                                <img src="assets/deluxe.jpg" width="100%" class="p-4 rounded" />
                                <div align="center">
                                    <h4 class="fw-bold">Deluxe</h4>
                                    <p style="font-family: 'Arial'">Deluxe rooms provide a luxurious experience with
                                        spacious interiors and elegant furnishings. Guests can enjoy additional
                                        amenities such as a minibar, seating area, and deluxe toiletries. Ideal for
                                        those seeking extra comfort and indulgence.</p>
                                </div>
                            </li>
                            <li class="list-group-item border-0 rooms">
                                <img src="assets/suite.jpg" width="100%" class="p-4 rounded" />
                                <div align="center">
                                    <h4 class="fw-bold">Suite</h4>
                                    <p style="font-family: 'Arial'">Suites offer the ultimate in luxury and
                                        sophistication. Featuring separate living and sleeping areas, stunning views,
                                        and exclusive perks, these accommodations are perfect for special occasions or
                                        VIP guests.</p>
                                </div>
                            </li>
                            <li class="list-group-item border-0 rooms">
                                <img src="assets/executive.jpg" width="100%" class="p-4 rounded" />
                                <div align="center">
                                    <h4 class="fw-bold">Executive</h4>
                                    <p style="font-family: 'Arial'">Executive rooms combine modern elegance with
                                        functional design. With ample space, contemporary furnishings, and upgraded
                                        amenities, these rooms are ideal for business travelers or guests seeking a
                                        stylish retreat.</p>
                                </div>
                            </li>
                            <li class="list-group-item border-0 rooms">
                                <img src="assets/family-room.jpg" width="100%" class="p-4 rounded" />
                                <div align="center">
                                    <h4 class="fw-bold">Family</h4>
                                    <p style="font-family: 'Arial'">Family rooms provide spacious accommodations for
                                        groups or families traveling together. Featuring multiple beds, a seating area,
                                        and family-friendly amenities, these rooms ensure a comfortable and enjoyable
                                        stay for everyone.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



            <br /><br />
            <h1 class="display-3 text-primary text-uppercase" style="font-family: 'Gideon Roman'; font-weight: 600">
                Testimonies
            </h1>

            <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <ul id="testimonialsList"
                            class="list-group list-group-horizontal position-relative overflow-hidden w-100">
                            <?php

                            $sql = "SELECT name, message FROM testimonies";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li class="list-group-item border-0">
                            <img src="assets/profile.png" class="p-4 testimony" />
                            <div align="center">
                                <h4 class="fw-bold">' . $row['name'] . '</h4>
                                <p style="font-family: \'Arial\'">' . $row['message'] . '</p>
                            </div>
                        </li>';
                                }
                            } else {
                                echo '<li class="list-group-item border-0">No testimonials found.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>



        </div>
        <br /><br />
    </div>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script>
        var carouselList = document.getElementById('carouselList');

        function slideLeft() {
            var firstItem = carouselList.firstElementChild;
            carouselList.removeChild(firstItem);
            carouselList.appendChild(firstItem);
        }

        setInterval(slideLeft, 1500);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var testimonialsList = document.getElementById('testimonialsList');
            var slideWidth = testimonialsList.firstElementChild.offsetWidth;
            var carouselInterval = 4500;

            function slideLeft() {
                testimonialsList.style.transition = 'transform 1.0s ease-in-out';
                testimonialsList.style.transform = 'translateX(' + (-slideWidth) + 'px)';
                setTimeout(function () {
                    testimonialsList.appendChild(testimonialsList.firstElementChild);
                    testimonialsList.style.transition = 'none';
                    testimonialsList.style.transform = 'translateX(0)';
                }, 500);
            }

            setInterval(slideLeft, carouselInterval);
        });
    </script>



    <?php include ("components/footer.php"); ?>
    </body>

    </html>