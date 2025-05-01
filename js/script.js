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



let cart = []; // Масив для збереження товарів


document.querySelectorAll(".item").forEach((item) => {
    const button = document.createElement("button");
    button.textContent = "🛒";
    button.classList.add("add-to-cart");

 
    const infoBlock = item.querySelector(".item-info");
    infoBlock.appendChild(button);



    button.addEventListener("click", () => {
        const title = item.querySelector(".item-title").textContent;
        const priceText = item.querySelector(".item-price span").textContent;
        const price = parseFloat(priceText.replace(/[^\d\.]/g, ''));

        // Перевіряємо чи вже є товар у кошику
        const existingItem = cart.find((el) => el.title === title);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({ title, price, quantity: 1 });
        }
        updateCart();
    });
});

// Відкрити кошик
const cartModal = document.getElementById("cart-modal");
document.addEventListener("keydown", (e) => {
    if (e.key === "c") { // натисни "с" — відкриється кошик
        cartModal.style.display = "block";
        updateCart();
    }
});

// Закрити кошик
document.getElementById("close-cart").addEventListener("click", () => {
    cartModal.style.display = "none";
});

// Оновити кошик
function updateCart() {
    const cartItemsDiv = document.getElementById("cart-items");
    cartItemsDiv.innerHTML = "";

    let total = 0;
    cart.forEach((item, index) => {
        const div = document.createElement("div");
        div.innerHTML = `
          <span>${item.title} (${item.price} грн)</span>
          <span>
            <button onclick="changeQuantity(${index}, -1)">-</button>
            ${item.quantity}
            <button onclick="changeQuantity(${index}, 1)">+</button>
            <button onclick="removeItem(${index})">🗑️</button>
          </span>
        `;
        cartItemsDiv.appendChild(div);
        total += item.price * item.quantity;
    });

    document.getElementById("cart-total").textContent = total.toFixed(2);

            // Оновлюємо лічильник на кнопці кошика
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById("cart-count").textContent = count;

}

function changeQuantity(index, delta) {
    const newQuantity = cart[index].quantity + delta;
    if (newQuantity >= 1) {
        cart[index].quantity = newQuantity;
    }
    updateCart();
}


// Видалення товару
function removeItem(index) {
    cart.splice(index, 1);
    updateCart();
}

// Відкрити кошик по кнопці
document.getElementById("open-cart").addEventListener("click", () => {
    cartModal.style.display = "block";
    updateCart();
});
