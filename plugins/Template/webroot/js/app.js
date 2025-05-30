$(function () {

   AOS.init();

   /* bootstrap tooltip */
   const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
   const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


   function isMobile() {
      return $(window).width() < 600;
   }


   /* main header show/hide on scroll */
   let lastScrollTop = 0;
   let delta = 50;

   $(window).scroll(function () {
      let scrollTop = $(this).scrollTop();
      if (Math.abs(scrollTop - lastScrollTop) > delta) {
         if (scrollTop > lastScrollTop && scrollTop > delta) {
            // Scroll Down
            $('#main-header').slideUp('fast');
         } else {
            // Scroll Up
            $('#main-header').slideDown('fast');
         }
         lastScrollTop = scrollTop;
      }
   });

   /* scroll to a section */
   $('.scroll-to-items .item').click(function (e) {
      e.preventDefault();
      const target = $(this).data('target');
      $(this).addClass('active').siblings().removeClass('active')
      $('html, body').animate({scrollTop: $('#' + target).offset().top - 20});
   })

   /* show/hide submenu */
   $('.has-submenu').hover(function () {
      $(this).find('.second-lvl-menu').first().stop(true, true).slideDown('fast');
      $(this).find('.arrow-down').addClass('rotate')
   }, function () {
      $(this).find('.second-lvl-menu').first().slideUp('fast');
      $(this).find('.arrow-down').removeClass('rotate')
   });

   /* show/hide mobile menu */
   $('.bars').click(function () {
      $('.mobile-menu').slideToggle('fast');
      $('.hamburger, .close').toggle();
   });


   /***************** filter page *****************/

   function updateURL() {
      // Get current URL
      let url = new URL(window.location);

      // Get all checked checkboxes
      let checkedValues = $('.filter-option .form-check .form-check-input:checked').map(function () {
         return this.value;
      }).get();

      // Set or remove the query parameter 'items'
      if (checkedValues.length) {
         url.searchParams.set('items', checkedValues.join(','));
      } else {
         url.searchParams.delete('items');
      }

      // Update the URL without reloading the page
      window.history.replaceState({}, '', url);
   }

   // Initialize based on current URL
   let urlParams = new URLSearchParams(window.location.search);
   let items = urlParams.get('items');
   if (items) {
      let itemsArray = items.split(',');
      $('.filter-option .form-check .form-check-input').each(function () {
         let isFilterItemOpen = false;
         if (itemsArray.includes(this.value)) {
            isFilterItemOpen = true;
            this.checked = true;
         }
         if (isFilterItemOpen) {
            // if one option of filters had been checked, this filter item will open
            $(this).closest('.filter-item').addClass('active').find('.filter-options').slideDown('fast');
         }
      });
   }

   $('.mobile-filters-toggler-wrapper .toggler').click(function (e) {
      $('.post-sidebar-wrapper').fadeIn('fast');
      e.stopPropagation();
   });
   $(document).click(function () {
      if (isMobile()) {
         $('.post-sidebar-wrapper').fadeOut('fast');
      }
   });
   $('.post-filters').click(function (e) {
      e.stopPropagation();
   })
   $('.filter-item .filter-title').click(function () {
      $(this).closest('.filter-item').toggleClass('active').find('.filter-options').slideToggle('fast');
   });

   // Add event listener to checkboxes
   $('.filter-option .form-check').change(function () {
      updateURL();
   });

   $('.del-filters').click(function () {
      $('.filter-option .form-check .form-check-input').prop('checked', false)
      updateURL();
   })


   /* file input */
   $('.file-input-handler').click(function () {
      $(this).closest('.file-input-wrapper').find('.file-input').click();
   });
   $('.file-input').change(function () {

      $("#files-preview").empty(); // Clear previous previews
      let files = this.files;

      for (let i = 0; i < files.length; i++) {
         let file = files[i];
         let reader = new FileReader();

         reader.onload = function (e) {

            const image = e.target.result.includes('image') ? e.target.result : './css/images/no-preview.png'
            let imgElement = $(`
                <div class="file-preview">
                  <div class="img-info">
                     <img src="${image}" alt="Image Preview" />
                     <div class="img-details">
                        <p class="file-name">${file.name}</p>
                        <p class="file-size">${(file.size / 1024).toFixed(2)} KB</p>
                     </div>
                  </div>  
                  <span class="trash-icon delete-btn">
                     <img src="./css/icons/trash.svg" alt="trash icon" />           
                  </span>
                </div>
            `);
            $("#files-preview").append(imgElement);

            // Add delete functionality
            imgElement.find('.delete-btn').click(function () {
               imgElement.remove();
            });

         }; // reader.onload

         reader.readAsDataURL(file);
      } // for

   });


   /* main swiper slider */
   let mainSlider = new Swiper('#main-slider', {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 0,
      // rtl: true,
      speed: 500,
      pagination: {
         el: ".swiper-pagination",
         clickable: true
      },
      autoplay: {
         delay: 5000,
      },
      effect: "creative",
      creativeEffect: {
         prev: {
            translate: [0, 0, -400],
         },
         next: {
            translate: ["100%", 0, 0],
         },
      }

   });

   let footerContentSlider = new Swiper('.footer-sliders .content-slider', {
      loop: false,
      slidesPerView: 1,
      spaceBetween: 0,
      effect: "fade",
      allowTouchMove: false,
      pagination: {
         el: ".footer-swiper-pagination",
         clickable: true
      },
      navigation: {
         nextEl: '.swiper-button-next',
         prevEl: '.swiper-button-prev',
      },
   });

   let footerImageSlider = new Swiper('.footer-sliders .image-slider', {
      loop: false,
      slidesPerView: 1,
      spaceBetween: 0,
      allowTouchMove: false,
      effect: "creative",
      creativeEffect: {
         prev: {
            shadow: true,
            translate: ["-20%", 0, -1],
         },
         next: {
            translate: ["100%", 0, 0],
         },
      }
   });

   /*footerImageSlider[0].on('slideChange', function () {
      footerContentSlider[0].slideTo(footerImageSlider[0].activeIndex);
   });*/

   footerContentSlider[0].on('slideChange', function () {
      footerImageSlider[0].slideTo(footerContentSlider[0].activeIndex);
   });


   /* swiper with thumbnail */
   let galleryThumbs = new Swiper('.gallery-thumbs', {
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
      navigation: {
         nextEl: '.swiper-button-next',
         prevEl: '.swiper-button-prev',
      },
      loop: true,
      breakpoints: {
         320: {
            slidesPerView: 2.2,
            spaceBetween: 6
         },
         480: {
            slidesPerView: 2.5,
            spaceBetween: 6
         },
         640: {
            slidesPerView: 3,
            spaceBetween: 12,
         },
         1024: {
            slidesPerView: 4,
            spaceBetween: 12,
         }
      }

   });
   let galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      slidesPerView: 1,
      loop: true,
      thumbs: {
         swiper: galleryThumbs
      }
   });


   /******************************************** Profile ********************************************/
   $('.show-pass').click(function () {
      $(this).closest('.form-item').find('.form-control').attr('type', 'text');
      $(this).hide();
      $('.hide-pass').show();
   })
   $('.hide-pass').click(function () {
      $(this).closest('.form-item').find('.form-control').attr('type', 'password');
      $(this).hide();
      $('.show-pass').show();
   });

   $('.user-dropdown-toggler').click(function (e) {
      $(this).find('.user-dropdown').slideToggle('fast');
      $(this).find('.arrow-down').toggleClass('rotate')
      e.stopPropagation();
   });
   $('.user-dropdown').click(function (e) {
      e.stopPropagation();
   })
   $(document).click(function () {
      $('.user-dropdown').slideUp('fast');
      $('.user-dropdown-toggler .arrow-down').removeClass('rotate')
   });


   $('.ticket-items-mobile .ticket-item .title').click(function () {

      // if is not open => it will open
      if (!$(this).closest('.ticket-item').find('.details').is(':visible')) {

         $('.ticket-items-mobile .ticket-item .details').slideUp('fast');
         $('.ticket-items-mobile .ticket-item .arrow-down').removeClass('rotate');

         $(this).closest('.ticket-item').find('.arrow-down').addClass('rotate')
         $(this).closest('.ticket-item').find('.details').slideDown('fast')

      }

   })

})