
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('css/admin/assets/vendor/jquery/dist/jquery.min.js') }} "></script>
  <script src=" {{ asset('css/admin/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }} "></script>
  <script src="{{ asset('css/admin/assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('css/admin/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src=" {{ asset('css/admin/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }} "></script>
  <!-- Optional JS -->
  <script src=" {{ asset('css/admin/assets/vendor/chart.js/dist/Chart.min.js') }} "></script>
  <script src=" {{ asset('css/admin/assets/vendor/chart.js/dist/Chart.extension.js') }} "></script>
  <!-- Argon JS -->
  <script src=" {{ asset('css/admin/assets/js/argon.js?v=1.2.0') }} "></script>
  <!-- State JS -->
  <script src=" {{ asset('css/admin/assets/js/state.js') }} "></script>

   <!-- Bar Chart JS -->
   <!-- <script src=" {{ asset('admin/assets/js/chart-bar-demo.js') }} "></script> -->
  <!-- Data Tables JS -->
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <!-- ck editor -->
  <script src=" {{ asset('css/admin/assets/ckeditor/ckeditor.js') }} " ></script>
  <!-- Excel JS -->
  <script src="{{asset('css/admin/assets/js/jquery.tableToExcel.js')}}"></script>

  <!-- Admin js -->
  <script src="{{asset('js/admin.js')}}"></script>
</body>

</html>

<!-- initializing data tables -->
<script >
  $(function()
  {
    $('#example1').DataTable({
      responsive: true
    });
    $('#example2').DataTable({
      responsive: true
    });
  });
</script>
<!-- initializing ck editor -->

<script>
  $(function()
  {
    CKEDITOR.replace('inputDescription');
    CKEDITOR.replace('desc');
  })
</script>





<!-- configuration of excel js  -->
  <script>


    //... or

    $('#excel').click(function () {
        $('table').tblToExcel();
    });

</script>









