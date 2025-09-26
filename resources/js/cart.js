import axios from "axios";

export function addToCart(productId, price, quantity = 1) {
    const token = localStorage.getItem("api_token");

    axios.post('/api/cart/add', {
        product_id: productId,
        quantity: quantity,
        price: price
    }, {
        headers: {
            Authorization: `Bearer ${token}`,
        }
    })
    .then(response => {
        alert("Added to cart!");
        // Optional: emit Livewire event to refresh cart component
        window.livewire.emit('cartUpdated');
    })
    .catch(error => {
        console.error("Failed to add to cart", error);
        alert("Something went wrong!");
    });
}
