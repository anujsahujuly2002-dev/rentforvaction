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
// datepicker — two independent single-date Litepickers for #checkIn and #checkOut.
// Picking a check-in date pushes the check-out picker's minDate forward by one day,
// and clears any stale check-out value that's now before the new check-in.
// Guarded so pages without these inputs don't throw.
(function initSingleDatepickers() {
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');
    if (!checkInInput || !checkOutInput || typeof Litepicker === 'undefined') {
        return;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    function parseYmd(v) {
        if (!v) return null;
        const parts = v.split('-');
        if (parts.length !== 3) return null;
        const d = new Date(+parts[0], +parts[1] - 1, +parts[2]);
        return isNaN(d.getTime()) ? null : d;
    }

    function nextDay(d) {
        const n = new Date(d);
        n.setDate(n.getDate() + 1);
        return n;
    }

    function markHasValue(fieldEl, hasVal) {
        if (!fieldEl) return;
        fieldEl.classList.toggle('has-value', !!hasVal);
    }

    const checkInFieldEl = document.getElementById('checkInField');
    const checkOutFieldEl = document.getElementById('checkOutField');

    markHasValue(checkInFieldEl, checkInInput.value);
    markHasValue(checkOutFieldEl, checkOutInput.value);

    // Check-in picker
    const checkInPicker = new Litepicker({
        element: checkInInput,
        singleMode: true,
        numberOfMonths: 1,
        numberOfColumns: 1,
        format: 'YYYY-MM-DD',
        minDate: today,
        autoApply: true,
        setup: (picker) => {
            picker.on('selected', (date) => {
                const ymd = date.format('YYYY-MM-DD');
                checkInInput.value = ymd;
                markHasValue(checkInFieldEl, true);

                // Push check-out minDate to the day after check-in, and clear stale value.
                const minOut = nextDay(date.dateInstance);
                checkOutPicker.setOptions({ minDate: minOut });
                const currentOut = parseYmd(checkOutInput.value);
                if (currentOut && currentOut < minOut) {
                    checkOutInput.value = '';
                    checkOutPicker.clearSelection();
                    markHasValue(checkOutFieldEl, false);
                }
            });
        }
    });

    // Check-out picker — initial minDate is the day after check-in if set, else today+1.
    const initialIn = parseYmd(checkInInput.value);
    const initialOutMin = initialIn ? nextDay(initialIn) : nextDay(today);

    const checkOutPicker = new Litepicker({
        element: checkOutInput,
        singleMode: true,
        numberOfMonths: 1,
        numberOfColumns: 1,
        format: 'YYYY-MM-DD',
        minDate: initialOutMin,
        autoApply: true,
        setup: (picker) => {
            picker.on('selected', (date) => {
                checkOutInput.value = date.format('YYYY-MM-DD');
                markHasValue(checkOutFieldEl, true);
            });
        }
    });

    // Per-field clear buttons (× icon inside each input)
    document.querySelectorAll('.date-clear-btn[data-clear]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const target = btn.getAttribute('data-clear');
            if (target === 'checkIn') {
                checkInPicker.clearSelection();
                checkInInput.value = '';
                markHasValue(checkInFieldEl, false);
                // Reset check-out's minDate back to today+1 since check-in is gone.
                checkOutPicker.setOptions({ minDate: nextDay(today) });
            } else if (target === 'checkOut') {
                checkOutPicker.clearSelection();
                checkOutInput.value = '';
                markHasValue(checkOutFieldEl, false);
            }
        });
    });
})();
// end

