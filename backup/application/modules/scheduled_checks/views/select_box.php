<link href="<?php echo STATIC_ADMIN_CSS?>select-boxes.css" rel="stylesheet">
<script src="<?php echo STATIC_ADMIN_JS?>select-boxes.js" type="text/javascript"></script>
   <script type="text/javascript">
    jQuery(document).ready( function($){

      // Multiple Select
      $(".select-1").select2({
        placeholder: "Select Multiple Values"
      });

      // Loading array data
      var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
      $(".select-data-array").select2({
        data: data
      })
      $(".select-data-array-selected").select2({
        data: data
      });

      // Enabled/Disabled
      $(".select-disabled").select2();
      $(".select-enable").on("click", function () {
        $(".select-disabled").prop("disabled", false);
        $(".select-disabled-multi").prop("disabled", false);
      });
      $(".select-disable").on("click", function () {
        $(".select-disabled").prop("disabled", true);
        $(".select-disabled-multi").prop("disabled", true);
      });

      // Without Search
      $(".select-hide").select2({
        minimumResultsForSearch: Infinity
      });

      // select Tags
      $(".select-tags").select2({
        tags: true
      });

      // Select Splitter

    });
  </script>