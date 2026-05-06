// slider1
      $(document).ready(function() {
         $('.center-slider').slick({
             slidesToShow: 4,
             slidesToScroll: 1,
             centerMode: false,
             arrows: true,
             dots: false,
             speed: 300,
             centerPadding: '20px',
             infinite: true,
             autoplaySpeed: 5000,
             nextArrow: $('.slider-next'),
             autoplay: false,
             prevArrow: $('.slider-prev'),
             responsive: [{
                     breakpoint: 1024,
                     settings: {
                         slidesToShow: 2,
                         slidesToScroll: 2,
                         infinite: true,
                         dots: true
                     }
                 },
                 {
                     breakpoint: 600,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 360,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 300,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 }
             ]
         });
     });
    //  end
    // slider2
     $(document).ready(function() {
         $('.slicks-slider').slick({
             slidesToShow: 4,
             slidesToScroll: 1,
             centerMode: false,
             arrows: true,
             dots: false,
             speed: 300,
             centerPadding: '20px',
             infinite: true,
             autoplaySpeed: 5000,
             nextArrow: $('.slider-next1'),
             autoplay: true,
             prevArrow: $('.slider-prev1'),
             responsive: [{
                     breakpoint: 1024,
                     settings: {
                         slidesToShow: 2,
                         slidesToScroll: 2,
                         infinite: true,
                         dots: true
                     }
                 },
                 {
                     breakpoint: 600,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 360,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 300,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 }
             ]
         });
     });
    //  end
     // slider2
     $(document).ready(function() {
         $('.slicks-sliders').slick({
             slidesToShow: 4,
             slidesToScroll: 1,
             centerMode: false,
             arrows: true,
             dots: false,
             speed: 300,
             centerPadding: '20px',
             infinite: true,
             autoplaySpeed: 5000,
             nextArrow: $('.slider-next2'),
             autoplay: false,
             prevArrow: $('.slider-prev2'),
             responsive: [{
                     breakpoint: 1024,
                     settings: {
                         slidesToShow: 2,
                         slidesToScroll: 2,
                         infinite: true,
                         dots: true
                     }
                 },
                 {
                     breakpoint: 600,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 360,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 },
                 {
                     breakpoint: 300,
                     settings: {
                         slidesToShow: 1,
                         slidesToScroll: 1,
                     }
                 }
             ]
         });
     });
    //  end
    // slider3
    $('.instagram-slider').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 0,
  speed: 4000,
  cssEase: 'linear',
  infinite: true,
  arrows: false,
  pauseOnHover: true,
  responsive: [
    { breakpoint: 992, settings: { slidesToShow: 4 } },
    { breakpoint: 768, settings: { slidesToShow: 3 } },
    { breakpoint: 576, settings: { slidesToShow: 2 } }
  ]
});
// end
// datepicker
  const checkInField = document.getElementById('checkIn');
    const checkOutField = document.getElementById('checkOut');

    const picker = new Litepicker({
      element: checkInField,
      elementEnd: checkOutField,
      singleMode: false,
      numberOfMonths: window.innerWidth < 768 ? 1 : 2,
      numberOfColumns: window.innerWidth < 768 ? 1 : 2,
      format: 'YYYY-MM-DD',
      autoApply: true,
      resetButton: true,
      allowRepick: true,
      minDays: 1,
      tooltipText: {
        one: 'night',
        other: 'nights',
      },
      tooltipNumber: (totalDays) => totalDays - 1,
      setup: (picker) => {
        picker.on('preselect', (start, end) => {
          if (start && !end) {
            checkInField.value = start.format('YYYY-MM-DD');
            checkOutField.value = '';
          }
        });

        picker.on('selected', (start, end) => {
          checkInField.value = start.format('YYYY-MM-DD');
          checkOutField.value = end.format('YYYY-MM-DD');
        });

        picker.on('render', () => {
          const calendar = document.querySelector('.litepicker');
          if (calendar && !calendar.querySelector('.litepicker-close-btn')) {
            const closeBtn = document.createElement('div');
            closeBtn.className = 'litepicker-close-btn';
            closeBtn.innerText = 'Close';
            closeBtn.onclick = () => picker.hide();
            calendar.appendChild(closeBtn);
          }
        });
      }
    });

    // Clear button functionality
    document.getElementById('clearBtn').addEventListener('click', () => {
      picker.clearSelection();
      checkInField.value = '';
      checkOutField.value = '';
    });

    // Auto reconfigure on resize
    window.addEventListener('resize', () => {
      picker.setOptions({
        numberOfMonths: window.innerWidth < 768 ? 1 : 2,
        numberOfColumns: window.innerWidth < 768 ? 1 : 2
      });
    });

// end

