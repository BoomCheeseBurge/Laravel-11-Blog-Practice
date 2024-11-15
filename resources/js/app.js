import './bootstrap';

import 'flowbite';

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

Alpine.plugin(persist)

// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


new Swiper('.card-wrapper', {

    // configure Swiper to use modules
    modules: [Navigation, Pagination],

    // Optional parameters
    loop: true,
    autoplay: {
        delay: 1000,
    },

    // Pagination Bullets
    pagination: {
        el: '.swiper-pagination',
        type: "bullets",
        dynamicBullets: true,
        clickable: true,
    },

    // Navigation Arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // Responsive Breakpoints
    breakpoints: {
        0: {
            slidesPerView: 1,
            // Space between Cards
            spaceBetween: 100,
        },
        640: {
            slidesPerView: 1,
            // Space between Cards
            spaceBetween: 50,
        },
        768: {
            slidesPerView: 1,
            // Space between Cards
            spaceBetween: 50,
        },
        1024: {
            slidesPerView: 2,
            // Space between Cards
            spaceBetween: 100,
        },
        1280: {
            slidesPerView: 3,
            // Space between Cards
            spaceBetween: 50,
        },
        1536: {
            slidesPerView: 3,
            // Space between Cards
            spaceBetween: 100,
        },
    },
});

