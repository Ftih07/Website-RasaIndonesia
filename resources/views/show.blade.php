function initMap() {
    // Inisialisasi peta dengan posisi default (Melbourne)
    const defaultLocation = {
        lat: -37.827920,
        lng: 144.960900
    };

    const map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 12,
    });

    // Coba dapatkan lokasi pengguna
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            console.log("User Location:", userLocation);

            // Pindahkan peta ke lokasi pengguna
            map.setCenter(userLocation);
            map.setZoom(14);

            // Ambil data bisnis terdekat dari backend
            fetchNearbyBusinesses(userLocation, map);

        }, () => {
            console.warn("Lokasi pengguna tidak dapat diakses, menggunakan lokasi default.");
            fetchNearbyBusinesses(defaultLocation, map);
        });
    } else {
        console.warn("Geolocation tidak didukung oleh browser ini.");
        fetchNearbyBusinesses(defaultLocation, map);
    }
}

// Fungsi untuk mengambil bisnis terdekat berdasarkan lokasi
function fetchNearbyBusinesses(location, map) {
    fetch(`/api/nearby-businesses?lat=${location.lat}&lng=${location.lng}`)
        .then(response => response.json())
        .then(data => {
            console.log("Nearby Businesses:", data);
            if (Array.isArray(data)) {
                data.forEach(business => {
                    if (business.latitude && business.longitude) {
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(business.latitude),
                                lng: parseFloat(business.longitude),
                            },
                            map: map,
                            title: business.name,
                        });

                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                <div class="card-marker">
                                    <div class="card-content">
                                        <div class="card-title">${business.name}</div>
                                        <div class="rating">${renderStars(business.average_rating)}</div>
                                        <div class="info">${business.type ? business.type.title : 'N/A'}</div>
                                    </div>
                                </div>
                            `,
                            maxWidth: 300,
                        });

                        marker.addListener("click", () => {
                            infoWindow.open(map, marker);
                        });
                    }
                });
            } else {
                console.error("Invalid response format:", data);
            }
        })
        .catch(error => {
            console.error("Error fetching businesses:", error);
        });
}

// Fungsi render rating bintang
function renderStars(rating) {
    const stars = Math.round(rating);
    return "★".repeat(stars) + "☆".repeat(5 - stars);
}

// Inisialisasi peta setelah halaman dimuat
window.onload = initMap;
