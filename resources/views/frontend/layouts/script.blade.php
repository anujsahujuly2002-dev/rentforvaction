 <!-- Back to top start -->
    <!-- back to top -->
    <div id="backtotop"><i class="bi bi-chevron-up"></i></div>
 <!-- Back to top ends -->

 <!-- *Scripts* -->
 <!-- jQuery must be loaded before Bootstrap -->
 <script src="{{ asset('frontend-assets/js/jquery-3.6.0.min.js') }}"></script>
 <!-- <script src="{{ asset('frontend-assets/js/jquery-3.2.1.min.js') }}"></script> -->
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
 <script src="{{ asset('frontend-assets/js/bootstrap.min.js') }}"></script>

 <script src="{{ asset('frontend-assets/js/plugin.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
 <script src="{{ asset('frontend-assets/js/main.js') }}"></script>
 <script src="{{ asset('frontend-assets/js/main-1.js') }}"></script>
 <script src="{{ asset('frontend-assets/js/custom-accordian.js') }}"></script>
 {{-- <script src="{{ asset('frontend-assets/js/custom-countdown.js') }}"></script> --}}
 <script src="{{ asset('frontend-assets/js/preloader.js') }}"></script>
 <script src="{{ asset('admin-auth-assets/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('admin-auth-assets/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('frontend-assets/js/slick.min.js') }}"></script>


 {{-- toaster js --}}

 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('js')
@yield('js')
 <script>
     showloader = () => {
         $(".loading").css('display', 'block');
     }

     hideLoader = () => {
         $(".loading").css('display', 'none');
     }

     const site_url = {!! json_encode(url('/')) !!};
 </script>
 <script src="{{ asset('frontend-assets/js/ownerJs/logout.js') }}"></script>
 <!-- Litepicker JS -->
 <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>
 <script src="{{ asset('frontend-assets/js/datepicker.js') }}"></script>
  <script>
  window.onload = function () {
    // List of all class names you want to apply active-switching to
    const classNames = ['services__box', 'ourpartner', 'contact-top__item'];

    classNames.forEach(className => {
      const cards = document.querySelectorAll('.' + className);

      cards.forEach(card => {
        card.addEventListener('mouseenter', function () {
          cards.forEach(c => c.classList.remove('active'));
          this.classList.add('active');
        });
      });
    });
  };
</script>

 </body>

 </html>
