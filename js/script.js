document.getElementById("close").addEventListener("click", function() {
    document.getElementById("modal").style.display = "none";
});

const images = document.querySelectorAll(".item img"); // Select all images
images.forEach((image) => {
    image.addEventListener("click", function(event) {
        document.getElementById("modal").style.display = "block"; // Show modal
        document.getElementById("modal-image").src = image.src; // Set modal image source

        const modalText = image.getAttribute("alt"); // Get alt text from the image

        document.getElementById("modal-label").textContent = modalText;// Set modal text
    });
}
);