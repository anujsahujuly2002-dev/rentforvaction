<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        {{-- <div class="mb-2 mb-md-0">©
            <script>
            document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by
            <a href="https://www.uvmdiligentinfotech.com/" target="_blank" class="footer-link fw-bolder">UVM Diligent</a>
        </div> --}}
    </div>
</footer>
<!-- / Footer -->
<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>
<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('admin-auth-assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{ asset('admin-auth-assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{ asset('admin-auth-assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{ asset('admin-auth-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{ asset('admin-auth-assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('admin-auth-assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<!-- Main JS -->
<script src="{{ asset('admin-auth-assets/js/main.js')}}"></script>

{{-- <script src="{{ asset('admin-auth-assets/js/ui-toasts.js')}}"></script> --}}

<!-- Page JS -->
<script src="{{ asset('admin-auth-assets/js/dashboards-analytics.js')}}"></script>
<script src="{{ asset('admin-auth-assets/js/swal.js')}}"></script>

{{-- datatable  --}}
<script src="{{ asset('admin-auth-assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-auth-assets/js/dataTables.bootstrap4.min.js') }}"></script>


{{-- common JS --}}

<script src="{{ asset('admin-auth-assets/js/common.js') }}"></script>
@stack('js')

<script>
    var site_url = {!! json_encode(url('/')) !!}

    function showLoader(){
        $("#loader").removeClass('d-none');
    }

    function hideLoader(){
        $("#loader").addClass('d-none');
    }

    function showToaster(selectedType,selectedPlacement,msg) {
        selectedPlacement = selectedPlacement.split(' ');
        const toastPlacementExample = document.querySelector('.toast-placement-ex');
        toastPlacementExample.classList.add(selectedType);
        DOMTokenList.prototype.add.apply(toastPlacementExample.classList, selectedPlacement);
        toastPlacement = new bootstrap.Toast(toastPlacementExample);
        $(".toast-body").text(msg);
        toastPlacement.show();
    }
</script>

</body>
</html>
