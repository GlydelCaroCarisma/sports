// logout.js

function confirmLogout() {
  // Show the confirmation dialog
  const confirmBox = document.getElementById("logout-confirmation");
  confirmBox.style.display = "block";
}

function proceedLogout() {
  // Clear client-side storage (optional)
  localStorage.clear();
  sessionStorage.clear();

  // Redirect to server-side logout
  window.location.href = "logout.php";
}

function cancelLogout() {
  // Hide the confirmation dialog
  const confirmBox = document.getElementById("logout-confirmation");
  confirmBox.style.display = "none";
}
