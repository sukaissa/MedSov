// Function to show the modal and populate with patient data
let currentModalOverlayClickHandler = null; // To store the reference for removeEventListener

// eslint-disable-next-line
function showPatientDetailsModal(pid) {
    document.getElementById("patientDetailsPid").value = pid;
    document.getElementById("patientDetailsForm").submit();
}

function removeUrlParams(param) {
    const url = new URL(window.location);

    // Check if param is an array or a single string
    if (Array.isArray(param)) {
        // Remove multiple parameters
        param.forEach((p) => url.searchParams.delete(p));
    } else {
        // Remove single parameter
        url.searchParams.delete(param);
    }

    window.history.replaceState({}, "", url);
}
// Function to close the modal
// eslint-disable-next-line
function closePatientDetailsModal() {
    const modal = document.getElementById("patientDetailsModal");
    if (modal) {
        modal.classList.add("hidden");
        removeUrlParam(["pid", "meals"]);
    }

    // Remove the specific event listener to prevent memory leaks and multiple bindings
    if (modal && currentModalOverlayClickHandler) {
        modal.removeEventListener("click", currentModalOverlayClickHandler);
        currentModalOverlayClickHandler = null; // Clear the reference
    }
}

// eslint-disable-next-line
function showModalContent(
    contentId,
    isBackButton = false,
    urlParamsToRemove = ""
) {
    const modalContentArea = document.getElementById(
        "patientModalDynamicContentArea"
    );
    if (!modalContentArea) {
        console.error("Error: Modal dynamic content area not found.");
        return;
    }

    // Get all direct children of the dynamic content area (which are your content sections)
    const allContentSections = modalContentArea.children;

    // Iterate through all sections and hide them
    for (let i = 0; i < allContentSections.length; i++) {
        allContentSections[i].classList.add("hidden");
    }

    // Show the requested content section
    const targetContent = document.getElementById(
        "patientModal" +
            contentId.charAt(0).toUpperCase() +
            contentId.slice(1) +
            "Content"
    );
    // Using `patientModal` + Capitalized `contentId` + `Content` to match the IDs in PHP generated HTML
    // Example: 'printWristband' -> 'patientModalPrintWristbandContent'

    if (targetContent) {
        if (isBackButton) {
            removeUrlParams(urlParamsToRemove);
        }
        targetContent.classList.remove("hidden");
    } else {
        console.warn(
            `Warning: Content section with ID 'patientModal${contentId
                .charAt(0)
                .toUpperCase()}${contentId.slice(1)}Content' not found.`
        );
    }
}

// eslint-disable-next-line
function showFormsModal(contentId) {
    const modal = document.getElementById("formsModal");
    if (modal) {
        modal.classList.remove("hidden");
    }

    const modalContentArea = document.getElementById("formsDynamicContentArea");
    if (!modalContentArea) {
        return;
    }

    // Get all direct children of the dynamic content area (which are your content sections)
    const allContentSections = modalContentArea.children;

    // Iterate through all sections and hide them
    for (let i = 0; i < allContentSections.length; i++) {
        allContentSections[i].classList.add("hidden");
    }

    // Show the requested content section
    const targetContent = document.getElementById(contentId);

    if (targetContent) {
        targetContent.classList.remove("hidden");
    } else {
        console.warn(
            `Warning: Content section with ID 'patientModal${contentId
                .charAt(0)
                .toUpperCase()}${contentId.slice(1)}Content' not found.`
        );
    }
}

// eslint-disable-next-line
function closeformsModal() {
    const modal = document.getElementById("formsModal");
    if (modal) {
        modal.classList.add("hidden");
    }

    // Remove the specific event listener to prevent memory leaks and multiple bindings
    if (modal && currentModalOverlayClickHandler) {
        modal.removeEventListener("click", currentModalOverlayClickHandler);
        currentModalOverlayClickHandler = null; // Clear the reference
    }
}
