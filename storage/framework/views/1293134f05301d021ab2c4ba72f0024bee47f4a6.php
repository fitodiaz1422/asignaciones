<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('app.name')); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/adminlte.min.css')); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <?php echo $__env->yieldContent('css'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/app.css')); ?>">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php echo $__env->make('layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <?php echo $__env->make('layouts.info-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('contenido'); ?>


    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>

  </div>



  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo e(asset('plugins/jquery/jquery.min.js')); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- ChartJS -->
<script src="<?php echo e(asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('dist/js/adminlte.js')); ?>"></script>
<script src="<?php echo e(asset('dist/js/notifications.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/moment/locale/es-us.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
<script>
    $('.back-to-top').hide();
        $(".nav-treeview li a").each(function() {
            if(($(this).attr("class")=="nav-link active")){
                $(this).parent().parent().parent().addClass('menu-open');
            }
        });
        $('.nav-treeview').each(function(i) {
            let len = $(this).find('li').size();
            if(len==0) $(this).parent().css("display","none");
        });

    function setUnreadNotifications() {
        var token = '<?php echo e(csrf_token()); ?>';
        var data={_token:token};
        $.ajax({
            type: 'POST',
            url: "/SetUnreadNotifications",
            dataType: 'json',
            data: data,
            success: function (data) {
                getNotifications();
            }
        });
    };


    $(document).ready(function(){
            $(window).scroll(function(){
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });
            $('.scrollup').click(function(){
                $("html, body").animate({ scrollTop: 0 }, 600);
                return false;
            });
            moment.locale('es-us');
            setInterval('getNotifications()',100000);
            getNotifications();
        });
</script>


</body>
</html>
<?php /**PATH /app/resources/views/layout.blade.php ENDPATH**/ ?>