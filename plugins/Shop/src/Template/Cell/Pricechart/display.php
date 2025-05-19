<?php
use Cake\Routing\Router;
global $is_status;
if($is_status == 'single' ){
  global $result;
  if(isset($result['id']))
    $link = $this->Query->the_permalink(['id'=> $result['id'] ]);
  else
    $link = Router::url(null, true);
  ?>
  <div class="modal fade" id="pricechart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">نمودار قیمت فروش</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <canvas id="pricechart-0"></canvas>
        </div>
      </div>
    </div>
  </div>
<?php }?>