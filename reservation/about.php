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

    <title>About</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/dashboard.css" rel="stylesheet" />
    <link href="./styles/scrollbar.css" rel="stylesheet" />
    <link href="./styles/about.css" rel="stylesheet" />

</head>


<div> <?php include ("componentshome/navbar.php"); ?>



    <div class="container about-us">
        <section class="about-section">
            <div class="row">



                <div class="row">
                    <div class="col-md-12">
                        <h2>About Enchanted Escapes Hotel</h2>
                        <p>Welcome to Enchanted Escapes Hotel, your premier destination for luxury accommodation and
                            unforgettable experiences. At Enchanted Escapes, we believe in providing our guests with
                            unparalleled comfort, convenience, and personalized service throughout their stay.</p>
                        <p>Our hotel offers a sanctuary of relaxation amidst breathtaking natural beauty, ensuring that
                            every moment of your stay is filled with tranquility and serenity. Whether you're seeking a
                            romantic getaway, a family vacation, or a rejuvenating retreat, Enchanted Escapes Hotel is
                            the perfect destination for your next adventure.</p>
                        <h4>Our Mission</h4>
                        <p>At Enchanted Escapes Hotel, our mission is to exceed the expectations of our guests by
                            delivering exceptional hospitality and creating unforgettable memories. We are dedicated to
                            providing an unparalleled guest experience that reflects our commitment to excellence in
                            every detail.</p>
                        <h4>Our Commitment to Excellence</h4>
                        <p>We are committed to excellence in everything we do, from the quality of our accommodations to
                            the professionalism of our staff. Our team is passionate about ensuring that every guest
                            receives the highest level of service and attention, making their stay truly exceptional.
                        </p>
                        <h4>Premium Amenities and Services</h4>
                        <p>Enchanted Escapes Hotel offers a wide range of premium amenities and services designed to
                            enhance your stay. From luxurious accommodations and gourmet dining to world-class spa
                            treatments and exciting recreational activities, we strive to provide everything you need
                            for a truly unforgettable experience.</p>
                        <h4>Your Ultimate Retreat</h4>
                        <p>Escape to Enchanted Escapes Hotel and discover a world of luxury, relaxation, and adventure.
                            Whether you're exploring our pristine beaches, indulging in gourmet cuisine, or simply
                            unwinding in the comfort of your elegant accommodations, you'll find that every moment at
                            our hotel is an opportunity to create lifelong memories.</p>
                        <p>Thank you for choosing Enchanted Escapes Hotel. We look forward to welcoming you and ensuring
                            that your stay with us is nothing short of extraordinary.</p>

                    </div>
                </div>
        </section>
    </div>


    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>

    <?php include ("components/footer.php"); ?>
    </body>

    </html>