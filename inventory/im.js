// Function to confirm logout
function confirmLogout() {
    // Show confirmation dialog
    if (confirm("Are you sure you want to logout?")) {
        // If user confirms, submit the logout form
        document.getElementById("logoutForm").submit();
    }
}

// Get the <p> element
const datetimeParagraph = document.getElementById('datetime');

// Function to update date and time
function updateDateTime() {
    // Get current date and time
    const now = new Date();

    // Format the date and time
    const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
    const timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
    const dateString = now.toLocaleDateString(undefined, dateOptions);
    const timeString = now.toLocaleTimeString(undefined, timeOptions);

    // Update the <p> element with the formatted date and time
    datetimeParagraph.textContent = `${dateString}, ${timeString}`;
}

// Call the function once to update initially
updateDateTime();

// Update date and time every second
setInterval(updateDateTime, 1000);

// Get all navigation links
const navLinks = document.querySelectorAll('.navbar .nav-link');
const contents = document.querySelectorAll('.content');

// Add event listener to each navigation link
navLinks.forEach(link => {
    link.addEventListener('click', function (event) {
        // Remove the active class from all navigation links
        navLinks.forEach(link => link.classList.remove('active'));
        contents.forEach(content => content.style.display = 'none');

        // Add the active class to the clicked navigation link
        this.classList.add('active');

        // Show the corresponding content
        const index = parseInt(this.getAttribute('data-index'));
        const content = document.getElementById(`content${index}`);
        content.style.display = 'block';

        // Prevent the default link behavior
        event.preventDefault();
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Function to open the pop-up form
    function openPopupForm(containerId) {
        const popupFormContainer = document.getElementById(`popupFormContainer${containerId}`);
        if (popupFormContainer) {
            popupFormContainer.style.display = "block";
        }
    }

    // Function to close the pop-up form
    function closePopupForm() {
        const popupForms = document.querySelectorAll('.popup-form-container');
        popupForms.forEach(form => {
            form.style.display = 'none';
        });
    }
    function closePopupForm1() {
        const popupForms = document.querySelectorAll('.popupform_edit');
        popupForms.forEach(form => {
            form.style.display = 'none';
        });
    }

    function closePopupForm2() {
        const popupForms = document.querySelectorAll('.popupform_editstocks');
        popupForms.forEach(form => {
            form.style.display = 'none';
        });
    }


    // Add event listener to the "Add Product" button in Content 2
    document.querySelector("#content2 .add-product").addEventListener("click", function() {
        openPopupForm("");
    });

    // Add event listener to the "Close" button in the pop-up form
    document.querySelectorAll(".close-btn").forEach(button => {
        button.addEventListener("click", function() {
            closePopupForm();
        });
    });

    // Initially hide the pop-up form
    closePopupForm();
});

// Function to handle showing content based on the clicked link
function showContent(index) {
    // Hide all content divs
    document.querySelectorAll('.content').forEach(content => {
        content.style.display = 'none';
    });

    // Show the content corresponding to the clicked link
    const content = document.getElementById(`content${index}`);
    if (content) {
        content.style.display = 'block';
    }
}

// Add event listener to the navigation links for content 3 to 6
document.querySelectorAll('.navbar .nav-link[data-index]').forEach(link => {
    link.addEventListener('click', function(event) {
        // Remove the active class from all navigation links
        document.querySelectorAll('.navbar .nav-link').forEach(link => {
            link.classList.remove('active');
        });

        // Add the active class to the clicked navigation link
        this.classList.add('active');

        // Show the corresponding content
        const index = parseInt(this.getAttribute('data-index'));
        showContent(index);

        // Prevent the default link behavior
        event.preventDefault();
    });
});


function toggleForm(rowData) {
    var form = document.getElementById("popupform_edit");
    form.style.display = form.style.display === "none" ? "block" : "none";

    // Populate form fields with row data
    document.getElementById("product_name").value = rowData.product_name;
    document.getElementById("category").value = rowData.category;
    document.getElementById("type").value = rowData.type;
    document.getElementById("product-supplier").value = rowData.supplier;
    document.getElementById("productid").value = rowData.product_id;

}










// Show content 1 by default
showContent(1);
