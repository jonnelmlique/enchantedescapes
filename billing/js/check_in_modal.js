var modal = document.getElementById('checkInModal');

// Get the button that opens the modal
var checkInBtn = document.getElementById('submitCheckIn');

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
checkInBtn.onclick = function() {
  modal.style.display = 'block';
};

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function() {
  modal.style.display = 'none';
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
};