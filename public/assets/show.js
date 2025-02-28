$(document).ready(function ($) {
    "use strict";

    // Initialize Swiper for book table image slider
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

    // Initialize Swiper for team slider
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

    // Remove default class from menu-dish when filters are clicked
    jQuery(".filters").on("click", function () {
        jQuery("#menu-dish").removeClass("bydefault_show");
    });

    // Initialize MixItUp for menu filtering
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

    // Toggle navigation menu
    jQuery(".menu-toggle").click(function () {
        jQuery(".main-navigation").toggleClass("toggled");
    });

    // Close navigation menu when a menu item is clicked
    jQuery(".header-menu ul li a").click(function () {
        jQuery(".main-navigation").removeClass("toggled");
    });

    // Register GSAP ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    var elementFirst = document.querySelector(".site-header");
    ScrollTrigger.create({
        trigger: "body",
        start: "30px top",
        end: "bottom bottom",
        onEnter: () => myFunction(),
        onLeaveBack: () => myFunction(),
    });

    // Toggle sticky header class
    function myFunction() {
        elementFirst.classList.toggle("sticky_head");
    }

    // Initialize Parallax effect
    var scene = $(".js-parallax-scene").get(0);
    var parallaxInstance = new Parallax(scene);
});

// Event handler when the window is fully loaded
jQuery(window).on("load", function () {
    $("body").removeClass("body-fixed");

    // Activate tab filter animation using GSAP
    let targets = document.querySelectorAll(".filter");
    let activeTab = 0;
    let old = 0;
    let animation;

    for (let i = 0; i < targets.length; i++) {
        targets[i].index = i;
        targets[i].addEventListener("click", moveBar);
    }

    // Set initial position of filter indicator
    gsap.set(".filter-active", {
        x: targets[0].offsetLeft,
        width: targets[0].offsetWidth,
    });

    // Function to move the filter indicator
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

// Event listener for updating active navigation menu on scroll
document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("section, footer");
    const navLinks = document.querySelectorAll(".menu li a");

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
            link.classList.remove("active-menu");
            if (link.getAttribute("href").substring(1) === currentSection) {
                link.classList.add("active-menu");
            }
        });
    }

    // Listen for scroll event
    window.addEventListener("scroll", updateActiveMenu);

    // Initialize menu highlighting
    updateActiveMenu();
});
