$(document).ready(function ($) {
    "use strict";

    var book_table = new Swiper(".book-table-img-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,
        effect: "coverflow",
        coverflowEffect: {
            rotate: 3,
            stretch: 2,
            depth: 100,
            modifier: 5,
            slideShadows: false,
        },
        loopAdditionSlides: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    var team_slider = new Swiper(".team-slider", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });

    jQuery(".filters").on("click", function () {
        jQuery("#menu-dish").removeClass("bydefault_show");
    });
    $(function () {
        var filterList = {
            init: function () {
                $("#menu-dish").mixItUp({
                    selectors: {
                        target: ".dish-box-wp",
                        filter: ".filter",
                    },
                    animation: {
                        effects: "fade",
                        easing: "ease-in-out",
                    },
                    load: {
                        filter: ".all, .makanan, .minuman",
                    },
                });
            },
        };
        filterList.init();
    });

    // Filter Toko & Restoran

    jQuery(".menu-toggle").click(function () {
        jQuery(".main-navigation").toggleClass("toggled");
    });

    jQuery(".header-menu ul li a").click(function () {
        jQuery(".main-navigation").removeClass("toggled");
    });

    gsap.registerPlugin(ScrollTrigger);

    var elementFirst = document.querySelector(".site-header");
    ScrollTrigger.create({
        trigger: "body",
        start: "30px top",
        end: "bottom bottom",

        onEnter: () => myFunction(),
        onLeaveBack: () => myFunction(),
    });

    function myFunction() {
        elementFirst.classList.toggle("sticky_head");
    }

    var scene = $(".js-parallax-scene").get(0);
    var parallaxInstance = new Parallax(scene);
});

jQuery(window).on("load", function () {
    $("body").removeClass("body-fixed");

    //activating tab of filter
    let targets = document.querySelectorAll(".filter");
    let activeTab = 0;
    let old = 0;
    let dur = 0.4;
    let animation;

    for (let i = 0; i < targets.length; i++) {
        targets[i].index = i;
        targets[i].addEventListener("click", moveBar);
    }

    // initial position on first === All
    gsap.set(".filter-active", {
        x: targets[0].offsetLeft,
        width: targets[0].offsetWidth,
    });

    function moveBar() {
        if (this.index != activeTab) {
            if (animation && animation.isActive()) {
                animation.progress(1);
            }
            animation = gsap.timeline({
                defaults: {
                    duration: 0.4,
                },
            });
            old = activeTab;
            activeTab = this.index;
            animation.to(".filter-active", {
                x: targets[activeTab].offsetLeft,
                width: targets[activeTab].offsetWidth,
            });

            animation.to(
                targets[old],
                {
                    color: "#0d0d25",
                    ease: "none",
                },
                0
            );
            animation.to(
                targets[activeTab],
                {
                    color: "#fff",
                    ease: "none",
                },
                0
            );
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("section, footer"); // Ambil semua elemen section
    const navLinks = document.querySelectorAll(".menu li a"); // Ambil semua elemen nav link

    // Fungsi untuk mengubah active menu saat scroll
    function updateActiveMenu() {
        let currentSection = "";
        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            if (window.scrollY >= sectionTop - sectionHeight / 3) {
                currentSection = section.getAttribute("id");
            }
        });

        navLinks.forEach((link) => {
            link.classList.remove("active-menu"); // Hapus class active dari semua menu
            if (link.getAttribute("href").substring(1) === currentSection) {
                link.classList.add("active-menu"); // Tambahkan class active pada menu yang sesuai
            }
        });
    }

    // Event listener untuk scroll
    window.addEventListener("scroll", updateActiveMenu);

    // Cek posisi awal saat halaman pertama kali dimuat
    updateActiveMenu();
});

$(document).ready(function () {
    "use strict";

    // GSAP animation setup
    let targets = document.querySelectorAll(".filter");
    let activeTab = 0;
    let animation;

    for (let i = 0; i < targets.length; i++) {
        targets[i].index = i;
        targets[i].addEventListener("click", moveBar);
    }

    // Initial GSAP setup
    gsap.set(".filter-active", {
        x: targets[0].offsetLeft,
        width: targets[0].offsetWidth
    });

    function moveBar() {
        if (this.index !== activeTab) {
            if (animation && animation.isActive()) {
                animation.progress(1);
            }
            animation = gsap.timeline({ defaults: { duration: 0.4 } });
            let oldTab = activeTab;
            activeTab = this.index;

            animation.to(".filter-active", {
                x: targets[activeTab].offsetLeft,
                width: targets[activeTab].offsetWidth
            });

            animation.to(targets[oldTab], { color: "#0d0d25", ease: "none" }, 0);
            animation.to(targets[activeTab], { color: "#fff", ease: "none" }, 0);
        }
    }

    // Filtering logic using MixItUp
    var filterList = {
        init: function () {
            $("#menu-dish").mixItUp({
                selectors: {
                    target: ".dish-box-wp",
                    filter: ".filter",
                },
                animation: {
                    effects: "fade scale",
                    easing: "ease-in-out",
                },
                load: {
                    filter: ".all",
                },
            });
        },
    };
    filterList.init();
});

$(document).ready(function () {
    const menuItems = $("#menu-dish .dish-box-wp");

    $("#filter-search").on("click", function () {
        const selectedCategory = $("#food-category").val().toLowerCase();
        const selectedType = $("#business-type").val().toLowerCase();
        const sortOrder = $("#sort-order").val();
        const keyword = $("#search-keyword").val().toLowerCase();

        // Filtering
        menuItems.hide().filter(function () {
            const itemCategory = $(this).data("category");
            const itemType = $(this).data("cat");
            const itemName = $(this).data("name");

            const matchesCategory = selectedCategory === "all" || itemCategory === selectedCategory;
            const matchesType = selectedType === "all" || itemType === selectedType;
            const matchesKeyword = !keyword || itemName.includes(keyword);

            return matchesCategory && matchesType && matchesKeyword;
        }).show();

        // Sorting
        const sortedItems = menuItems.sort(function (a, b) {
            const timeA = $(a).data("created-at");
            const timeB = $(b).data("created-at");

            return sortOrder === "newest" ? new Date(timeB) - new Date(timeA) : new Date(timeA) - new Date(timeB);
        });

        $("#menu-dish").html(sortedItems);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const foodCategory = document.getElementById('food-category');
    const sortOrder = document.getElementById('sort-order');
    const businessType = document.getElementById('business-type');
    const searchKeyword = document.getElementById('search-keyword');
    const searchButton = document.getElementById('search-button');

    searchButton.addEventListener('click', function () {
        const selectedCategory = foodCategory.value;
        const selectedSort = sortOrder.value;
        const selectedType = businessType.value;
        const keyword = searchKeyword.value.trim();

        // Construct URL with query parameters
        const url = new URL(window.location.href);
        url.searchParams.set('category', selectedCategory);
        url.searchParams.set('sort', selectedSort);
        url.searchParams.set('type', selectedType);
        if (keyword) {
            url.searchParams.set('keyword', keyword);
        } else {
            url.searchParams.delete('keyword'); // Remove keyword if empty
        }

        // Reload page with updated filters
        window.location.href = url;
    });
});









$(document).ready(function ($) {

    jQuery(".filters").on("click", function () {
        jQuery("#menu").removeClass("bydefault_show-menu");
    });
    $(function () {
        var filterList = {
            init: function () {
                $("#menu").mixItUp({
                    selectors: {
                        target: ".dish-box-wp",
                        filter: ".filter",
                    },
                    animation: {
                        effects: "fade",
                        easing: "ease-in-out",
                    },
                    load: {
                        filter: ".all, .makanan, .minuman",
                    },
                });
            },
        };
        filterList.init();
    });
});

