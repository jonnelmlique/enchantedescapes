<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

</head>
<body>


<form id="bookingForm">
    <input type="text" id="bookingId" name="bookingId">
    <input type="text" id="guestName" name="guestName">
    <!-- Other input fields -->
    <button type="button" onclick="fillFields()">Fill Fields</button>
</form>


<script>
function fillFields() {
    var checkedId = document.getElementById("bookingId").value;
    if (checkedId == 6) {
        // Assuming you have data available for the guest with ID 6
        var guestData = {
            id: 6,
            name: "John Doe",
            // Other data fields
        };

        document.getElementById("guestName").value = guestData.name;
        // Fill other input fields as needed
    } else {
        // Clear input fields if ID is not 6
        document.getElementById("guestName").value = "";
        // Clear other input fields as needed
    }
}
</script>

</body>
</html>