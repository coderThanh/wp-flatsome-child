document.addEventListener('DOMContentLoaded', function() {
    var galleries = document.querySelectorAll('.pt-gallery-wrapper');
    
    galleries.forEach(function(gallery) {
        var thumbsElement = gallery.querySelector('.gallery-thumbs');
        var mainElement = gallery.querySelector('.gallery-main');
        
        // Get columns from data attribute
        var thumbCol = parseInt(gallery.getAttribute('data-thumb-col')) || 3;
        var thumbColMd = parseInt(gallery.getAttribute('data-thumb-col-md')) || 4;
        var thumbColLg = parseInt(gallery.getAttribute('data-thumb-col-lg')) || 5;
        
        if (thumbsElement && mainElement) {
            var thumbsSwiper = new Swiper(thumbsElement, {
                spaceBetween: 10,
                slidesPerView: thumbCol, // Mobile
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    // Tablet
                    640: {
                        slidesPerView: thumbColMd,
                        spaceBetween: 10
                    },
                    // Desktop
                    1024: {
                        slidesPerView: thumbColLg,
                        spaceBetween: 10
                    }
                }
            });
            
            new Swiper(mainElement, {
                spaceBetween: 10,
                navigation: false, // No navigation
                pagination: false, // No pagination
                autoHeight:true,
                thumbs: {
                    swiper: thumbsSwiper,
                },
            });
        }
    });
});
