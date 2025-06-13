    <!-- Required Js -->
    <script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/popper/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/jquery-scrollbar/js/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/js/pcoded.min.js')); ?>"></script>

    <!-- datatable Js -->
    <script src="<?php echo e(asset('dashboard/plugins/data-tables/js/datatables.min.js')); ?>"></script>

    <!-- form-validation Js -->
    <script src="<?php echo e(asset('dashboard/js/pages/form-validation.js')); ?>"></script>

    <!-- material datetimepicker Js -->
    <script src="<?php echo e(asset('dashboard/plugins/moment/js/moment-with-locales.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js')); ?>"></script>

    <!-- toastr Js -->
    <script src="<?php echo e(asset('dashboard/plugins/toastr/js/toastr.min.js')); ?>"></script>
    <!-- Toastr message display -->
    @toastr_render

    <script type="text/javascript">
        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr["error"]("<?php echo e($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </script>


    <!-- page js -->
    <?php echo $__env->yieldContent('page_js'); ?>


    <script type="text/javascript">
        'use strict';
        $(document).ready(function() {
            // Date Picker
            $('.date').bootstrapMaterialDatePicker({
                setDate: new Date(),
                weekStart: 0,
                time: false
            });

            // Time Picker
            $('.time').bootstrapMaterialDatePicker({
                date: false,
                format: 'HH:mm'
            });
        });
    </script>

    <script type="text/javascript">
        'use strict';
        $(document).ready(function() {
            // [ Zero-configuration ] start
            $('#basic-table').DataTable();
            $('#basic-table2').DataTable();

            // [ HTML5-Export ] start
            $('#export-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i>',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file"></i>',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i>',
                        autoPrint: true,
                        // title: '',
                        footer: false,
                        exportOptions: {
                            columns: ':not(:last-child)',
                        },
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' )
                                /*.prepend(
                                    '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                                );*/
         
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );

                            $(win.document.body).find( 'caption' )
                                .css( 'font-size', '10px' );

                            $(win.document.body).find('h1')
                                .css({"text-align": "center", "font-size": "16pt"});
                        }
                    }
                ]
            });
        });
    </script>

    
    <script type="text/javascript">
        "use strict";
        $(document).ready(function(){
            $("#mobile-collapse").on( "click", function(e) {
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            $.ajax({
               url: "<?php echo e(route('setCookie')); ?>",
               method: 'get',
               data: {},
               success: function(result){
                  console.log(result.data);
               }});
            });
        });
    </script><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/layouts/common/footer_script.blade.php ENDPATH**/ ?>