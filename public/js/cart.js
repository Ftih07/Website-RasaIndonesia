document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("productModal");
    const addToCartBtn = document.getElementById("add-to-cart-btn");
    const qtyMinus = document.getElementById("qty-minus");
    const qtyPlus = document.getElementById("qty-plus");
    const qtyInput = document.getElementById("qty-input");
    const optionContainer = document.getElementById("option-groups-container");
    const cartSidebar = document.getElementById("cartSidebar");
    const openCartBtn = document.getElementById("openCartBtn");
    const closeCartBtn = document.getElementById("closeCartBtn");

    let basePrice = 0;
    let quantity = 1;

    // ===== Utility Functions =====
    function animatePriceChange(element, start, end, duration = 300) {
        let startTime = null;
        const flashColor = end > start ? "#28a745" : "#dc3545";
        const originalColor = getComputedStyle(element).color;

        element.style.transform = "scale(1.2)";
        element.style.transition = "transform 0.15s ease, color 0.15s ease";
        element.style.color = flashColor;

        function animate(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const currentValue = start + (end - start) * progress;
            element.textContent = `$${currentValue.toFixed(2)}`;

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                setTimeout(() => {
                    element.style.color = originalColor;
                    element.style.transform = "scale(1)";
                }, 150);
            }
        }
        requestAnimationFrame(animate);
    }

    function updateTotalPrice() {
        let total = basePrice;
        const checkedOptions = optionContainer.querySelectorAll(
            'input[type="checkbox"]:checked'
        );
        checkedOptions.forEach((cb) => {
            total += parseFloat(cb.getAttribute("data-price")) || 0;
        });
        total *= quantity;

        const priceEl = modal.querySelector("#modal-product-price");
        const currentDisplayed =
            parseFloat(priceEl.textContent.replace("$", "")) || basePrice;

        if (currentDisplayed !== total) {
            animatePriceChange(priceEl, currentDisplayed, total, 300);
        }
    }

    function validateRequired() {
        let valid = true;
        const groups = optionContainer.querySelectorAll(
            'div[data-is-required="1"]'
        );
        groups.forEach((group) => {
            const checked = group.querySelectorAll(
                'input[type="checkbox"]:checked'
            ).length;
            if (checked === 0) valid = false;
        });
        addToCartBtn.disabled = !valid;
    }

    function updateCartCount() {
        fetch("/cart", { headers: { Accept: "application/json" } })
            .then((res) => res.json())
            .then((data) => {
                document.getElementById("cart-count").textContent =
                    data.cart_count || 0;
            });
    }

    function animateCartCount() {
        const countEl = document.getElementById("cart-count");
        countEl.style.transform = "scale(1.3)";
        setTimeout(() => (countEl.style.transform = "scale(1)"), 150);
    }

    // ambil dari elemen HTML, ganti dengan id elemen yang kamu pakai
    const currentBusinessIdInput = document.getElementById("currentBusinessId");
    let currentBusinessId = currentBusinessIdInput
        ? currentBusinessIdInput.value
        : "";

    if (currentBusinessId) {
        fetchAndRenderCart(currentBusinessId);
    } else {
        fetchAndRenderCart();
    }

    function fetchAndRenderCart(businessId = "") {
        let url = "/cart";
        if (businessId) {
            url += `?business_id=${businessId}`;
        }

        fetch(url, {
            headers: { Accept: "application/json" },
        })
            .then((res) => res.json())
            .then((data) => {
                const cartCountEl = document.getElementById("cart-count");
                const container = document.getElementById("cartItemsContainer");

                if (!data.success || data.cart_count === 0) {
                    container.innerHTML = "<p>Your cart is empty.</p>";
                    cartCountEl.textContent = 0;
                    return;
                }

                cartCountEl.textContent = data.cart_count;
                container.innerHTML = "";

                data.cart.forEach((item) => {
                    const div = document.createElement("div");
                    div.classList.add(
                        "cart-item",
                        "d-flex",
                        "justify-content-between",
                        "align-items-center",
                        "mb-2"
                    );

                    div.innerHTML = `
                    <div class="d-flex align-items-center mb-2">
                        <img src="${item.product.image_url}" alt="${
                        item.product.name
                    }" 
                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; margin-right: 10px;">
                        <div>
                            <strong>${item.product.name}</strong>
                            <p class="mb-1">Final Price: $${parseFloat(
                                item.total_price
                            ).toFixed(2)}</p>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-secondary qty-minus" data-row="${
                                    item.id
                                }">-</button>
                                <input type="number" value="${
                                    item.quantity
                                }" min="1" 
                                    class="form-control form-control-sm mx-1 qty-input" 
                                    style="width: 50px;" data-row="${item.id}">
                                <button class="btn btn-sm btn-outline-secondary qty-plus" data-row="${
                                    item.id
                                }">+</button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-danger remove-cart-item" data-row="${
                            item.id
                        }">×</button>
                        <button class="btn btn-sm btn-secondary edit-cart-item ms-2" data-row="${
                            item.id
                        }">✎</button>
                    </div>
                `;

                    container.appendChild(div);
                });

                // Update qty
                container.querySelectorAll(".qty-minus").forEach((btn) => {
                    btn.addEventListener("click", () => {
                        const rowId = btn.dataset.row;
                        const input = container.querySelector(
                            `.qty-input[data-row="${rowId}"]`
                        );
                        let qty = parseInt(input.value);
                        if (qty > 1) {
                            qty--;
                            input.value = qty;
                            updateCartQty(rowId, qty);
                        }
                    });
                });

                container.querySelectorAll(".qty-plus").forEach((btn) => {
                    btn.addEventListener("click", () => {
                        const rowId = btn.dataset.row;
                        const input = container.querySelector(
                            `.qty-input[data-row="${rowId}"]`
                        );
                        let qty = parseInt(input.value);
                        qty++;
                        input.value = qty;
                        updateCartQty(rowId, qty);
                    });
                });

                container.querySelectorAll(".qty-input").forEach((input) => {
                    input.addEventListener("change", () => {
                        const rowId = input.dataset.row;
                        let qty = parseInt(input.value);
                        if (qty < 1 || isNaN(qty)) qty = 1;
                        input.value = qty;
                        updateCartQty(rowId, qty);
                    });
                });

                // Remove item
                container
                    .querySelectorAll(".remove-cart-item")
                    .forEach((btn) => {
                        btn.addEventListener("click", () => {
                            removeCartItem(btn.dataset.row);
                        });
                    });
            });
    }

    function updateCartQty(rowId, qty) {
        fetch(`/cart/update/${rowId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ quantity: qty }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    fetchAndRenderCart(currentBusinessId);
                } else {
                    alert(data.message || "Failed to update cart");
                }
            });
    }

    function removeCartItem(rowId) {
        fetch(`/cart/remove/${rowId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    fetchAndRenderCart(currentBusinessId);
                } else {
                    alert(data.message || "Failed to remove item");
                }
            });
    }

    openCartBtn.addEventListener("click", () => {
        currentBusinessId =
            document.getElementById("currentBusinessId")?.value || null;
        if (!currentBusinessId) {
            alert("Business ID not found.");
            return;
        }
        fetchAndRenderCart(currentBusinessId);
        cartSidebar.classList.add("open");
    });

    closeCartBtn.addEventListener("click", () => {
        cartSidebar.classList.remove("open");
    });

    addToCartBtn.addEventListener("click", function () {
        const productId = document.getElementById("modal-product-id").value;
        const businessId = document.getElementById("modal-business-id").value;
        const unitPrice = basePrice;
        const qty = parseInt(qtyInput.value) || 1;
        const note = document.getElementById("cart-note").value || "";
        const preference =
            document.querySelector(
                'input[name="preference_if_unavailable"]:checked'
            )?.value || "";

        // Ambil options per group dalam bentuk objek
        const optionGroups = [];

        document
            .querySelectorAll("#option-groups-container > div.mb-3")
            .forEach((groupEl) => {
                const groupName = groupEl
                    .querySelector("label.form-label")
                    .textContent.trim();
                const groupId = groupEl.dataset.groupId || null;
                const selected = [];

                groupEl
                    .querySelectorAll('input[type="checkbox"]:checked')
                    .forEach((cb) => {
                        selected.push({
                            id: parseInt(cb.value),
                            price: parseFloat(cb.dataset.price) || 0,
                        });
                    });

                if (selected.length > 0) {
                    optionGroups.push({
                        group_name: groupName,
                        group_id: groupId,
                        selected: selected,
                    });
                }
            });

        fetch("/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                product_id: productId,
                business_id: businessId,
                quantity: qty,
                unit_price: unitPrice,
                note: note,
                preference_if_unavailable: preference,
                options: JSON.stringify(optionGroups),
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    document.getElementById("cart-count").textContent =
                        data.cart_count;
                    animateCartCount();
                    showNotification("Success", data.message);
                } else {
                    showNotification("Error", data.message);
                }
            })
            .catch((err) => {
                console.error(err);
                showNotification("Error", "Failed to add to cart.");
            });
    });

    function showNotification(title, message) {
        alert(`${title}: ${message}`);
    }

    // ===== Event Listeners =====
    qtyMinus.addEventListener("click", () => {
        if (quantity > 1) {
            quantity--;
            qtyInput.value = quantity;
            updateTotalPrice();
        }
    });

    qtyPlus.addEventListener("click", () => {
        quantity++;
        qtyInput.value = quantity;
        updateTotalPrice();
    });

    qtyInput.addEventListener("input", () => {
        const val = parseInt(qtyInput.value);
        quantity = isNaN(val) || val < 1 ? 1 : val;
        qtyInput.value = quantity;
        updateTotalPrice();
    });

    modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        // === Cek is_sell di sini ===
        const isSell = button.getAttribute("data-is-sell") === "1";
        if (isSell) {
            addToCartBtn.disabled = false;
            addToCartBtn.textContent = "Add to Cart";
            addToCartBtn.classList.remove("btn-secondary");
            addToCartBtn.classList.add("btn-primary");
        } else {
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = "Not Available";
            addToCartBtn.classList.remove("btn-primary");
            addToCartBtn.classList.add("btn-secondary");
        }
        // === akhir cek is_sell ===

        currentBusinessId = button.getAttribute("data-business_id");

        const name = button.getAttribute("data-name");
        basePrice = parseFloat(button.getAttribute("data-price"));
        const serving = button.getAttribute("data-serving");
        const maxDistance = button.getAttribute("data-max_distance");
        const description = button.getAttribute("data-desc");
        const business = button.getAttribute("data-business");
        const image = button.getAttribute("data-image");
        const optionsRaw = button.getAttribute("data-options");

        modal.querySelector("#modal-product-name").textContent = name;
        modal.querySelector(
            "#modal-product-price"
        ).textContent = `$${basePrice.toFixed(2)}`;
        modal.querySelector("#modal-product-serving").textContent =
            serving || "-";
        modal.querySelector("#modal-product-type").textContent = maxDistance
            ? `${maxDistance} km`
            : "-";
        modal.querySelector("#modal-product-desc").textContent =
            description || "-";
        modal.querySelector("#modal-product-business").textContent =
            business || "-";
        modal.querySelector("#modal-product-image").src = image;
        modal.querySelector("#modal-product-id").value =
            button.getAttribute("data-id");
        modal.querySelector("#modal-business-id").value =
            button.getAttribute("data-business_id");

        let categories = [];
        try {
            categories = JSON.parse(button.getAttribute("data-categories"));
        } catch {
            categories = [];
        }
        modal.querySelector("#modal-product-categories").textContent =
            categories.length > 0 ? categories.join(", ") : "No categories";

        quantity = 1;
        qtyInput.value = quantity;

        optionContainer.innerHTML = "";
        let options;
        try {
            options = JSON.parse(optionsRaw);
        } catch {
            options = [];
        }

        if (options.length === 0) {
            const noOptions = document.createElement("p");
            noOptions.textContent = "No additional options.";
            optionContainer.appendChild(noOptions);
        } else {
            options.forEach((group) => {
                const groupWrapper = document.createElement("div");
                groupWrapper.className = "mb-3";
                groupWrapper.dataset.maxSelection = group.max_selection || 0;
                groupWrapper.dataset.isRequired = group.is_required ? "1" : "0";

                const label = document.createElement("label");
                label.className = "form-label fw-bold";
                label.textContent = `${group.group_name} ${
                    group.max_selection ? `(Max ${group.max_selection})` : ""
                } ${group.is_required ? "*" : ""}`;
                groupWrapper.appendChild(label);

                group.options.forEach((option) => {
                    const optionWrapper = document.createElement("div");
                    optionWrapper.className = "form-check";

                    const id = `option-${group.group_name}-${option.id}`;
                    optionWrapper.innerHTML = `
                        <input class="form-check-input" type="checkbox" name="option_group_${
                            group.group_name
                        }" 
                            id="${id}" value="${option.id}" data-price="${
                        option.price
                    }">
                        <label class="form-check-label" for="${id}">
                            ${option.name} (${
                        option.price > 0 ? `+$${option.price}` : "Free"
                    })
                        </label>
                    `;
                    groupWrapper.appendChild(optionWrapper);
                });

                optionContainer.appendChild(groupWrapper);

                const checkboxes = groupWrapper.querySelectorAll(
                    'input[type="checkbox"]'
                );
                checkboxes.forEach((cb) => {
                    cb.addEventListener("change", () => {
                        const checked = groupWrapper.querySelectorAll(
                            'input[type="checkbox"]:checked'
                        ).length;
                        if (group.max_selection > 0) {
                            checkboxes.forEach((box) => {
                                if (!box.checked) {
                                    box.disabled =
                                        checked >= group.max_selection;
                                }
                            });
                        }
                        validateRequired();
                        updateTotalPrice();
                    });
                });
            });
        }

        validateRequired();
        updateTotalPrice();
    });
});
