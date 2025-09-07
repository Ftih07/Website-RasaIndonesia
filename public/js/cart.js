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
                    // Enhanced empty cart display
                    container.innerHTML = `
                    <div class="cart-empty text-center py-5" style="color: #a0aec0;">
                        <i class="fas fa-shopping-cart display-4 mb-3" style="opacity: 0.5;"></i>
                        <p class="mb-0 fs-5">Your cart is empty</p>
                        <p class="small">Add some delicious items to get started!</p>
                    </div>
                `;
                    cartCountEl.textContent = 0;
                    return;
                }

                cartCountEl.textContent = data.cart_count;
                container.innerHTML = "";

                data.cart.forEach((item) => {
                    const div = document.createElement("div");
                    // Enhanced classes with modern styling
                    div.classList.add(
                        "cart-item",
                        "bg-white",
                        "rounded-4",
                        "p-3",
                        "mb-3",
                        "item-shadow",
                        "hover-lift",
                        "border"
                    );
                    div.style.cssText =
                        "transition: all 0.3s ease; border-color: rgba(255, 107, 53, 0.1) !important;";

                    // Modern card layout with better visual hierarchy
                    div.innerHTML = `
                    <!-- Product Image & Info -->
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0 me-3">
                            <img src="${item.product.image_url}" alt="${
                        item.product.name
                    }" 
                                 class="rounded-3 shadow-sm" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="mb-1 fw-semibold text-dark">${
                                item.product.name
                            }</h6>
                            <p class="mb-0 text-muted small">Final Price: <span class="fw-bold" style="color: #ff6b35;">$${parseFloat(
                                item.total_price
                            ).toFixed(2)}</span></p>
                        </div>
                    </div>
                    
                    <!-- Quantity Controls & Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Modern Quantity Controls -->
                        <div class="d-flex align-items-center bg-light rounded-pill p-1 border">
                            <button class="btn btn-sm rounded-circle qty-minus hover-scale" 
                                    style="width: 32px; height: 32px;" data-row="${
                                        item.id
                                    }">
                                <i class="fas fa-minus small"></i>
                            </button>
                            <input type="number" value="${
                                item.quantity
                            }" min="1" 
                                  class="form-control form-control-sm text-center fw-semibold qty-input border-0 bg-transparent" 
                                  style="width: 50px; color: #2d3748;" data-row="${
                                      item.id
                                  }">
                           <button class="btn btn-sm rounded-circle qty-plus hover-scale" 
                                   style="width: 32px; height: 32px;" data-row="${
                                       item.id
                                   }">
                               <i class="fas fa-plus small"></i>
                           </button>
                       </div>
                       
                       <!-- Action Buttons -->
                       <div class="d-flex gap-2">
                           <button class="btn btn-sm rounded-circle edit-cart-item hover-scale" 
                                   style="width: 32px; height: 32px; background: #e3f2fd; color: #1976d2; border: none;" 
                                   data-row="${item.id}">
                               ✎
                           </button>
                           
                           <button class="btn btn-sm rounded-circle remove-cart-item hover-scale" 
                                   style="width: 32px; height: 32px; background: #fed7d7; color: #e53e3e; border: none;" 
                                   data-row="${item.id}">
                               <i class="fas fa-trash small"></i>
                           </button>
                       </div>
                   </div>
               `;

                    container.appendChild(div);
                });

                // Enhanced hover effects for quantity buttons
                container
                    .querySelectorAll(".qty-minus, .qty-plus")
                    .forEach((btn) => {
                        btn.addEventListener("mouseenter", function () {
                            this.style.background = "#ff6b35";
                            this.style.color = "white";
                        });
                        btn.addEventListener("mouseleave", function () {
                            this.style.background = "transparent";
                            this.style.color = "#6c757d";
                        });
                    });

                // Your original functionality - EXACTLY PRESERVED
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

                container
                    .querySelectorAll(".remove-cart-item")
                    .forEach((btn) => {
                        btn.addEventListener("click", () => {
                            removeCartItem(btn.dataset.row);
                        });
                    });

                // Edit functionality (if you have it)
                container.querySelectorAll(".edit-cart-item").forEach((btn) => {
                    btn.addEventListener("click", () => {
                        // Your existing edit functionality here
                        console.log("Edit item:", btn.dataset.row);
                    });
                });
            })
            .catch((error) => {
                console.error("Error fetching cart:", error);
                const container = document.getElementById("cartItemsContainer");
                container.innerHTML = `
               <div class="text-center py-5 text-danger">
                   <i class="fas fa-exclamation-triangle display-4 mb-3"></i>
                   <p>Error loading cart. Please try again.</p>
               </div>
           `;
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
            addToCartBtn.textContent = "🛒 Add to Cart";
            addToCartBtn.classList.remove("btn-secondary");
            addToCartBtn.classList.add("toi-btn-warning");
        } else {
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = "🚫 Not Available";
            addToCartBtn.classList.remove("toi-btn-warning");
            addToCartBtn.classList.add("btn-secondary");
        }

        // === akhir cek is_sell ===

        currentBusinessId = button.getAttribute("data-business_id");

        const name = button.getAttribute("data-name");
        basePrice = parseFloat(button.getAttribute("data-price"));
        const productisSell = button.getAttribute("data-is-sell");
        const maxDistance = button.getAttribute("data-max_distance");
        const description = button.getAttribute("data-desc");
        const business = button.getAttribute("data-business");
        const image = button.getAttribute("data-image");
        const optionsRaw = button.getAttribute("data-options");
        const stock = button.getAttribute("data-stock");
        const weight = button.getAttribute("data-weight");
        const weightKg = parseFloat(weight);
        const length = button.dataset.length; // cm
        const width = button.dataset.width; // cm
        const height = button.dataset.height; // cm

        // Update modal content
        modal.querySelector("#modal-product-stock").textContent =
            stock > 0 ? stock + " left" : "Out of stock";

        modal.querySelector("#modal-product-name").textContent = name;
        modal.querySelector(
            "#modal-product-price"
        ).textContent = `$${basePrice.toFixed(2)}`;
        modal.querySelector("#modal-product-status").textContent =
            productisSell == 1 ? "Available" : "Not Available";
        modal.querySelector("#modal-product-type").textContent = maxDistance
            ? `${maxDistance} km`
            : "-";

        modal.querySelector("#modal-product-weight").textContent =
            weightKg && weightKg > 0
                ? `${(weightKg * 1000).toFixed(0)} g`
                : "-";
        modal.querySelector("#modal-product-dimension").textContent =
            length && width && height
                ? `${parseFloat(length).toFixed(0)} x ${parseFloat(
                      width
                  ).toFixed(0)} x ${parseFloat(height).toFixed(0)} cm`
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

                const requiredText = group.is_required
                    ? `<span class="text-danger">Required</span>` // merah
                    : "";

                label.innerHTML = `${group.group_name} ${
                    group.max_selection ? `(Max ${group.max_selection})` : ""
                } ${requiredText}`;

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
