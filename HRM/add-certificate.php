<?php
// Include necessary files
include "config.php";
include "sidebar.php";

if (isset($_POST["submit"])) {
  // Get form data
  $employee_id = $_POST["Employee_ID"];
  $name = $_POST["Name"];
  $release = $_POST["todate"];
  $posDept = $_POST["Position"];
  $start = $_POST["StartDate"];

  // Check if certificate already exists for the employee
  $check_sql = "SELECT * FROM `certificate` WHERE `Employee_ID` = '$employee_id'";
  $check_result = mysqli_query($conn, $check_sql);

  if (mysqli_num_rows($check_result) > 0) {
    // Certificate already exists for the employee
    echo "<script>window.location.href = 'certificate.php?msg=Certificate already exist for the employee';</script>";
    exit();
  } else {
    // Insert the certificate into the database
    $insert_sql = "INSERT INTO `certificate` VALUES (default, '$employee_id', '$name', '$release')";
    $insert_result = mysqli_query($conn, $insert_sql);

    if ($insert_result) {
      // Certificate inserted successfully
      printPDF($name, $release, $posDept, $start);

      // Redirect the user to certificate.php with a success message
      echo "<script>window.location.href = 'certificate.php?msg=New certificate created successfully';</script>";
      exit(); // Stop further execution
    } else {
      // Failed to insert certificate
      echo "Failed: " . mysqli_error($conn);
    }
  }
}


function printPDF($name, $release, $posDept, $start)
{
    include_once "pdf/fpdf.php";
    // Create a new FPDF instance
    $pdf = new FPDF();
    $pdf->AddPage();


    // $pdf->Image('assets/images/loogo.png', $leftMargin, 10, 40); // Adjust the path and dimensions as needed

    // // Add logo on the right
    // $pdf->Image('assets/images/loogo.png', $pdf->GetPageWidth() - $rightMargin - 50, 10, 30); // Adjust the path and dimensions as needed

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->MultiCell(0, 10, 'ENCHANTED ESCAPES', 0, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->MultiCell(0, 10, 'NOVALICHES, QUEZON CITY', 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    
    
    // Set margins
    $leftMargin = 20;
    $rightMargin = 20;
    $pdf->SetMargins($leftMargin, $topMargin = 10, $rightMargin);

    $pdf->Line($leftMargin, $pdf->GetY(), $pdf->GetPageWidth() - $rightMargin, $pdf->GetY());
    $pdf->Cell(0, 10, '', 0, 1, 'C');

    // Certificate title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'CERTIFICATE OF EMPLOYMENT', 0, 1, 'C');

    // Calculate effective width considering margins
    $effectiveWidth = $pdf->GetPageWidth() - $leftMargin - $rightMargin;

    // Title and header
    
    $pdf->Cell(0, 10, '', 0, 1, 'C');

    // Content
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, 'This is to certify that', 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->MultiCell(0, 10, $name, 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, 'Has been employed in', 0, 'C');
    $pdf->MultiCell(0, 10, 'Enchanted Escapes Hotel', 0, 'C');
    $pdf->MultiCell(0, 10, 'As', 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->MultiCell(0, 10, $posDept, 0, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->MultiCell(0, 10, 'From ' . date("F j, Y", strtotime($start)) . ' up to ' . date("F j, Y", strtotime($release)), 0, 'C');
    $pdf->MultiCell(0, 10, 'This certificate is being issued upon the request of aforementioned name for whatever lawful purpose it may serve best.', 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');

    // Signature
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Given this ' . date("F j, Y", strtotime($release)) . ' at Enchanted Hotel in Quezon City', 0, 1, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');
    $pdf->Cell(0, 10, '', 0, 1, 'C');

    // Set the file path
    $pdfPath = "./certificates/" . $name . ".pdf";

    // Save the PDF to a file
    $pdf->Output($pdfPath, "F");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" media="screen and (max-width: 1199px" href="./assets/css/md_device.css">
  <link rel="stylesheet" media="screen and (max-width: 991px" href="./assets/css/sm_device.css">
  <link rel="stylesheet" media="screen and (max-width: 768px" href="./assets/css/xs_device.css">
  <link rel="stylesheet" media="screen and (max-width: 450px" href="./assets/css/narrow_device.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
    integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/"
    crossorigin="anonymous"></script>
  <title>Get Your Certificate</title>

  <style>
    .smaller-textbox {
      width: 500px;
      height: 30px;
      /* Adjust the width as needed */
    }
  </style>

  <!-- Start of Async Drift Code -->
  <script>
    "use strict";
    !function () {
      var t = window.driftt = window.drift = window.driftt || [];
      if (!t.init) {
        if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
        t.invoked = !0, t.methods = ["identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on"],
          t.factory = function (e) {
            return function () {
              var n = Array.prototype.slice.call(arguments);
              return n.unshift(e), t.push(n), t;
            };
          }, t.methods.forEach(function (e) {
            t[e] = t.factory(e);
          }), t.load = function (t) {
            var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
            o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
            var i = document.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(o, i);
          };
      }
    }();
    drift.SNIPPET_VERSION = '0.3.1';
    drift.load('c3aurgtk94ca');
  </script>
  <!-- End of Async Drift Code -->

  <script>
    $(document).ready(function () {
      $('#Employee_ID').on('input', function () {
        var employee_id = $(this).val();
        $.ajax({
          url: 'get_employee_name.php', // Change this to the correct path
          method: 'POST',
          data: { employee_id: employee_id },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              $('#Name').val(response.employee_name);
              $('#Position').val(response.position);
              $('#start_date').val(response.startdate);
            } else {
              // Handle case when employee not found
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</head>

<body style="background-color: black;">
  <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080;">Certificate of Employment</nav>
  <section class="dept" style="background-image: url(assets/images/black.avif);  background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-size: 100% 100%;">
    <a href="#" target="_blank"><img src="./assets/images/loogo.png" alt="Logo" id="PUlogo"></a>

    <h2>
      <a href="#" target="_blank" id="chemdept">
        <span style="color: rgb(221, 209, 33); font-weight: 800;">Enchanted Escapes Hotel</span>
        <span style="color: rgb(150, 100, 50); font-weight: 800;">CERTIFICATE</span>
      </a>
    </h2>
    <!-- <form id="formput" action="get_employee_info.php" method="POST"> -->
    <form id="formput" action="add-certificate.php" method="POST">
      <!-- <form id="formput"> -->
      <div class="form-group">
        <div class="col-auto my-4">
          <label class="sr-only" for="inlineFormInput">Employee</label>
          <input type="text" maxlength="20" class="form-control mx-auto mb-2 smaller-textbox" id="Employee_ID"
            name="Employee_ID" style="background-color: white;" placeholder="Employee ID" required>

          <label class="sr-only" for="inlineFormInput">Name</label>
          <input type="text" maxlength="20" class="form-control mx-auto mb-2 smaller-textbox" id="Name" readonly
            name="Name" style="background-color: white;" placeholder="Name" required>

          <label class="sr-only" for="inlineFormInput">Position</label>
          <input type="text" maxlength="20" class="form-control mx-auto mb-2 smaller-textbox" id="Position" readonly
            name="Position" style="background-color: white;" placeholder="Position and Department" required>

          <div class="mb-3">
            <label for="start_date" style="color: white;">Date From -</label>
            <input type="date" id="start_date" name="StartDate" readonly>

            <label for="end_date" style="color: white;">Date Today -</label>
            <input type="date" id="end_date" name="todate" value="<?php echo date('Y-m-d'); ?>" readonly>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary col-3 mb-4" id="submit" name="submit"
        style="background-color: rgb(42, 88, 73); color: white;">Submit</button>
    </form>
  </section>
  <div id="container_button">
    <button type="button" class="btn btn-primary mb-4" id="preview"
      style="background-color: rgb(42, 88, 73);">view</button>
  </div>
  <canvas id="canvas"></canvas>
  <img id="img" style="display: none;" onload='draw()' src="./assets/images/certificate.jpg" />
  <img id="img1" style="display: none;" src="" />
  <div id="container">
    <button type="button" class="btn btn-outline-primary mb-2" style="box-shadow: none;" id="dpdf"
      onclick="downloadpdf()">DOWNLOAD PDF</button>
    <button type="button" class="btn btn-outline-primary mb-2" style="box-shadow: none;" id="djpg"
      onclick="downloadjpg()">DOWNLOAD JPEG</button>
  </div>
  <footer>
    <!-- <div class="center">
            Copyright &copy;2023&nbsp;&nbsp;&nbsp;<a href="#">Enchanted Escapes Hotel</a><br>
            All Rights Reserved
        </div> -->
  </footer>
  <script>

    document.getElementById('Employee_ID').addEventListener('change', function () {
      var employeeId = this.value;
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            document.getElementById('Name').value = xhr.responseText;
          } else {
            console.error('Error fetching employee name');
            // Clear the name field if an error occurs
            document.getElementById('Name').value = '';
          }
        }
      };
      xhr.open('GET', 'get_employee_name.php?Employee_ID=' + employeeId, true);
      xhr.send();
    });

    document.getElementById('Employee_ID').addEventListener('change', function () {
      var employeeId = this.value;
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            document.getElementById('Position').value = xhr.responseText;
          } else {
            console.error('Error fetching employee name');
            // Clear the name field if an error occurs
            document.getElementById('Position').value = '';
          }
        }
      };
      xhr.open('GET', 'get_employee_position_department.php?Employee_ID=' + employeeId, true);
      xhr.send();
    });

    document.getElementById('Employee_ID').addEventListener('change', function () {
      var employeeId = this.value;
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            document.getElementById('start_date').value = xhr.responseText;
          } else {
            console.error('Error fetching employee name');
            // Clear the name field if an error occurs
            document.getElementById('start_date').value = '';
          }
        }
      };
      xhr.open('GET', 'get_employee_start_date.php?Employee_ID=' + employeeId, true);
      xhr.send();
    });

    function draw() {
      var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d');
      canvas.width = $('#img').width();
      canvas.crossOrigin = "Anonymous";
      canvas.height = $('#img').height();
      ctx.drawImage($('#img').get(0), 0, 0);
    };
    canvas.width = $('#img').width();
    canvas.height = $('#img').height();
    var x = $('#img1').width();
    var y = $('#img1').height();
    var ratio = x / y
    var today = new Date();

    function previewFile() {
      const preview = document.getElementById('img1');
      const file = document.querySelector('input[type=file]').files[0];
      const reader = new FileReader();
      reader.addEventListener("load", function () {
        // convert image file to base64 string
        preview.src = reader.result;
      }, false);
      if (file) {
        reader.readAsDataURL(file);
      }
    }
    $('#name').bind('input propertychange', function () {
      if (this.value.length > 20) {
        $("#name").val($("#name").val().substring(0, 20));
        alert("stop");
      }
    });
    $(document).on('click', '#submit', function () {
      var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d');
      $('#preview').css('display', 'inline-block');
      //redraw image
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage($('#img').get(0), 0, 0);
      ctx.drawImage($('#img1').get(0), 943, 916, 409, 409);
      //refill text
      ctx.fillStyle = "black";
      ctx.textAlign = 'center';
      ctx.font = "bold italic 55pt cursive";
      ctx.fillText($('#name').val(), 525, 812);
      ctx.font = '30pt verdana'
      // ctx.fillText(today,260,815);  
    });
    $(document).on('click', '#preview', function () {
      $('#canvas').css('display', 'inline-block');
      $('#dpdf').css('display', 'inline-block');
      $('#djpg').css('display', 'inline-block');
    })
    function downloadjpg() {
      var canvas = document.getElementById('canvas');
      canvas.crossOrigin = "Anonymous";
      var image = canvas.toDataURL();
      var tmpLink = document.createElement('a');
      tmpLink.download = 'certificate.jpg';
      tmpLink.href = image;
      document.body.appendChild(tmpLink);
      tmpLink.click();
      document.body.removeChild(tmpLink);
    }
    function downloadpdf() {
      var canvas = document.getElementById('canvas');
      canvas.crossOrigin = "Anonymous";
      var img = canvas.toDataURL('image/JPEG', 1.0);
      var pdf = new jsPDF('p', 'mm');
      pdf.text(30, 30, 'this is our program')
      pdf.addImage(img, 'JPEG', 0, 0, 210, 297);
      pdf.save('certificate.pdf')
    }
  </script>
</body>

</html>