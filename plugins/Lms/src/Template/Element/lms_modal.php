<?php $this->start('modal');?>
<div class="modal fade bd-example-modal-lg " id="exampleModalll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false"  aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
        <div class="modal-header" style="padding: 6px 15px;">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <iframe class="embed-responsive-item" src="" allowfullscreen style="width:100%;border:0px;height: -webkit-fill-available;height:450px;"></iframe>
        </div>
    </div></div>
</div>
<script nonce="<?=get_nonce?>">
    $('#exampleModalll').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        $(this).find('.modal-body iframe').attr('src',button.data('whatever'))
        $(this).find('.modal-title').text(button.data('title'))
    });
    $("#exampleModalll").on("hidden.bs.modal", function () {
        $(this).find('.modal-body iframe').attr('src','')
        $(this).find('.modal-title').attr(button.data('title'))
    });
</script>
<style>
@media (min-width: 992px){
    .modal-lg, .modal-xl {
        max-width: 80%;
    }
}
</style>
<?php $this->end();?>
