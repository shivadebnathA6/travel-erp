<footer class="footer">
  <div class="container-fluid">
    <?php /*echo '<h5 style="background-color: #3df110;color: #000;">&nbsp; Next =>
        <b> http://192.168.29.69/trip-cart-package/master-list-activity-rate</b> <small>->Edit</small>
    </h5>'; ?>

    <?php echo '<h5 style=" background-color: #024d12;color: #fff;">&nbsp; Next =>
        <b> http://192.168.29.69/trip-cart-package/voucher-hotel-list</b> <small>->Filter by Hotel</small><br>
      &nbsp;  <b> http://192.168.29.69/trip-cart-package/voucher-activity-list</b> <small>->Filter by Activity & vendor</small><br>
      &nbsp;  <b> http://192.168.29.69/trip-cart-package/voucher-package-list</b> <small>->Filter by vendor</small><br>
      &nbsp;  <b> http://192.168.29.69/trip-cart-package/voucher-flight-list</b> <small>->Filter by vendor & Details(SelectBox)</small>
    </h5>';*/ ?>

    <div class="row">
    <div class="col-sm-6"> <?=date('Y')?>  ©  <?=$thisSoftware?> </div>
    <div class="col-sm-6">
      <div class="text-sm-end d-none d-sm-block">
      <a href="https://webihqsolutions.in/" target="_blank" class="text-secondary font-weight-bold">WEBI-HQ Solutions</a>
      </div>
    </div>
    </div>
  </div>
</footer>

<!-- end main content-->


<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="assets/libs/pace-js/pace.min.js"></script>
<script src="assets/js/app.js?v=<?=$script_ver?>"></script>
<script src="assets/dhScript.js?v=<?=$script_ver?>"></script>


<script src="assets/libs/select2_4.1/select2.min.js?v=<?=$script_ver?>"></script>

<script type="text/javascript">
    initializeSelect2();
    function initializeSelect2(destroy = false){
      /* if(destroy){

            $("form-select").each(function(index){
                  $(this).select2('destroy');
                  $(this).removeAttr('data-live-search').removeAttr('data-select2-id').removeAttr('aria-hidden').removeAttr('tabindex');
                  $(this).find("option").removeAttr('data-select2-id');
                });


              // if ($('.form-select').hasClass('select2-hidden-accessible')) {
              //     $('.form-select').select2('destroy');
              // }
          }else{

            $('.form-select').each(function(){
                    var placeholder = $(this).find("option:first-child").text() || 'Choose Option';
                    $(this).select2({
                      placeholder:placeholder
                    });
            });
          } */
    }

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>

