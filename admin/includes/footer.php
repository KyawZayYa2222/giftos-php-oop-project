<!-- Bootstrap core JavaScript-->
<!-- <script src="vendor/jquery/jquery.min.js"></script> -->
<script src="../assets/js/jquery-3.4.1.min.js"></script>
    <!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
    <script src="../assets/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/js/Chart.min.js"></script>

    <script src="../assets/js/custom.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script> -->
    
    <!-- select 2  -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select-2').select2();
        });

        // print invoice function 
        function printInvoice(url) {
            console.log(url);
            const printWindow = window.open(url, '_blank');
            
            printWindow.onload = function() {
                printWindow.print();
            }
        }

        // contact message mark as read 
    function markAsRead (id) {
      console.log(id)
      $.ajax({
        url: "../../ajaxHandler.php",
        type: 'POST',
        data: {
          controller: 'contact',
          action:'markAsRead',
          id: id
        },
        success: function(resp) {
          // console.log(resp)
          if(JSON.parse(resp).success) {
            $('#contact-detail-'+id).html('<button disabled class="btn float-right">Already read</button>')
          }
        },
        error: function(err) {
          console.log(err)
        }
      })
    }
    </script>

</body>

</html>