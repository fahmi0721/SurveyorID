;
(function($) {
    'use strict' // Start of use strict

    // Toggle the side navigation
    // $('#sidebarToggle, #sidebarToggleTop').on('click', function(e) {
    //     $('body').toggleClass('sidebar-toggled')
    //     $('.sidebar').toggleClass('toggled')
    //     if ($('.sidebar').hasClass('toggled')) {
    //         $('.sidebar .collapse').collapse('hide')
    //     }
    // })

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function() {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide')
        }
    })

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail
            this.scrollTop += (delta < 0 ? 1 : -1) * 30
            e.preventDefault()
        }
    })

    // Scroll to top button appear
    $(document).on('scroll', function() {
        var scrollDistance = $(this).scrollTop()
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn()
        } else {
            $('.scroll-to-top').fadeOut()
        }
    })

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function(e) {
        var $anchor = $(this)
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo')
        e.preventDefault()
    })

    // js untuk show hide foto pengawasan harian
    var html1 = "<div class='alert alert-danger alert-sm m-0 pt-1 pb-1'> <i class='fas fa-fw fa-exclamation-triangle'></i><small><b> No Data </b></small></div>"
    var kosong1 = ''
        // perulangan untuk I.BAHAN BAHAN form input file 
        // perulangan untuk I.BAHAN BAHAN form input file 
    for (let i = 1; i < 10; i++) {
        $('#prog_i_' + i + 'tdk').on('click', function() {
            $('input[id="fot_i_' + i + '"]').prop('required', false)
            $('.fot_i_' + i).hide()
            $('#ok' + i).html(html1)
        })
        $('#prog_i_' + i + 'ada').on('click', function() {
            $('input[id="fot_i_' + i + '"]').prop('required', true)
            $('#ok' + i).html(kosong1)
            $('.fot_i_' + i).show()
        })
    }
    // perulangan untuk II. PERSIAPAN LAPANGAN form input file 
    for (let j = 1; j < 16; j++) {
        $('#prog_ii_' + j + 'tdk').on('click', function() {
            $('input[id="fot_ii_' + j + '"]').prop('required', false)
            $('.fot_ii_' + j).hide()
            $('#oki' + j).html(html1)
        })
        $('#prog_ii_' + j + 'ada').on('click', function() {
            $('input[id="fot_ii_' + j + '"]').prop('required', true)
            $('#oki' + j).html(kosong1)
            $('.fot_ii_' + j).show()
        })
    }
})(jQuery); // End of use strict