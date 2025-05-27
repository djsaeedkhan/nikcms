</div>
        </div>
    </div>
    <?php 
    echo $this->Html->script([
        '/admin/app-assets/vendors/js/forms/validation/jquery.validate.min.js']);
    echo $this->Html->script([
        '/admin/app-assets/js/core/app-menu.js',
        '/admin/app-assets/js/scripts/components/components-popovers.js',
        '/admin/app-assets/js/core/app.js']);
    echo $this->Html->script([
        '/admin/app-assets/js/scripts/pages/page-auth-login.js']);?>
    <script nonce="<?=get_nonce?>">
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
    <style>
        .popover {font-family: inherit !important;}
    </style>
</body>
</html>