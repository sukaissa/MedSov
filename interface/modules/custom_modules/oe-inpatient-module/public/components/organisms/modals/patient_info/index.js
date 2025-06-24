// Function to show the modal and populate with patient data
let currentModalOverlayClickHandler = null; // To store the reference for removeEventListener

// eslint-disable-next-line
function showPatientDetailsModal(patientData) {
    const modal = document.getElementById("patientDetailsModal");

    // Show the modal by removing the 'hidden' class
    if (modal) modal.classList.remove("hidden");
}

// Function to close the modal
// eslint-disable-next-line
function closePatientDetailsModal() {
    const modal = document.getElementById("patientDetailsModal");
    if (modal) modal.classList.add("hidden");

    // Remove the specific event listener to prevent memory leaks and multiple bindings
    if (modal && currentModalOverlayClickHandler) {
        modal.removeEventListener("click", currentModalOverlayClickHandler);
        currentModalOverlayClickHandler = null; // Clear the reference
    }
}
