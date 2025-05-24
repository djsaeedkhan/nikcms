<?php
use Cake\Routing\Router;
?>
<style>
.nav-tree li a,
.nav-tree ul ul a{
    letter-spacing: 0;
    font-weight: normal;
    font-size: 14px;
    padding: 1px 0;
}
.nav-tree ul ul {
    padding-right: 10px;
}
.nav-tree ul ul ul a {
    padding-right: 0px !important;
    padding-left: 0;
}
.nav-tree li a i.icon-angle-down{
    /* float: left !important;
    margin-right: 0 !important;
    margin-left: 5px !important; */
}
.nav-tree {
    margin-bottom: 0;
}
.range-slider {
  margin: auto;
  text-align: center;
  position: relative;
  height: 6em;
}
.range-slider svg,
.range-slider input[type=range] {
  position: absolute;
  left: 0;
  bottom: 0;
}
.range-slider input[type=text] {
  border: 1px solid #ddd;
  text-align: center;
  font-size: 1.6em;
  -moz-appearance: textfield;
}
.range-slider input[type=text]::-webkit-outer-spin-button,
.range-slider input[type=text]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
.range-slider input[type=text]:invalid,
.range-slider input[type=text]:out-of-range {
  border: 2px solid #ff6347;
}
.range-slider input[type=range] {
  -webkit-appearance: none;
  width: 100%;
}
.range-slider input[type=range]:focus {
  outline: none;
}
.range-slider input[type=range]:focus::-webkit-slider-runnable-track {
  background: #2497e3;
}
.range-slider input[type=range]:focus::-ms-fill-lower {
  background: #2497e3;
}
.range-slider input[type=range]:focus::-ms-fill-upper {
  background: #2497e3;
}
.range-slider input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: #2497e3;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
.range-slider input[type=range]::-webkit-slider-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #2497e3;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -7px;
}
.range-slider input[type=range]::-moz-range-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: #2497e3;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
.range-slider input[type=range]::-moz-range-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #2497e3;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
}
.range-slider input[type=range]::-ms-track {
  width: 100%;
  height: 5px;
  cursor: pointer;
  animate: 0.2s;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
.range-slider input[type=range]::-ms-fill-lower,
.range-slider input[type=range]::-ms-fill-upper {
  background: #2497e3;
  border-radius: 1px;
  box-shadow: none;
  border: 0;
}
.range-slider input[type=range]::-ms-thumb {
  z-index: 2;
  position: relative;
  box-shadow: 0px 0px 0px #000;
  border: 1px solid #2497e3;
  height: 18px;
  width: 18px;
  border-radius: 25px;
  background: #a1d0ff;
  cursor: pointer;
}
.sidebar .widget {
    background: #f3f5f8;
    padding: 15px;
    border-radius: 7px;
}
</style>
<div class="sidebar col-lg-3 order-first">

    <?php
    $items = $this->Query->category($post_type,[
        'contain'=>[],
        'field'=>['id','title'],
        'limit'=>0,
        'children'=>isset($category->id)?($category->parent_id == 0?$category->id:$category->parent_id):1,
        'find_type'=>'treechildren'
    ]);
    if( is_array($items) and count($items) > 0 ):?>
    <div class="widget widget_links">
        <h4>فیلتر دسته بندی</h4>
        <ul class="custom-filter">
            <?php
            foreach( $items  as $kitm=>$itm){
                echo '<li class="py-1 fs-13"><a href="'.Router::url('/').$post_type.'/index/'.$kitm.'/'.$this->Query->the_slug($itm).'">'.$itm.'</a></li>';
            }
            ?>
        </ul>
    </div>
    <br>
    <?php endif;?>

    <?= $this->Form->create(null,['type'=>'get','id'=>'form1']);?>
    <div class="widget widget-filter-links">
        <h4>فیلتر مبلغ</h4>
        <div class="range-slider">
            <span>
                از <input type="text" readonly value="<?= number_format($this->request->getQuery('from') != ""?intval($this->request->getQuery('from')):1000000)?>" style="font-size: 14px;width: 95px;" min="0" max="150000000"/>
                تا <input type="text" readonly value="<?= number_format($this->request->getQuery('to') != ""?intval($this->request->getQuery('to')):80000000)?>" style="font-size: 14px;width: 95px;" min="0" max="150000000"/>
            </span>
            
            <br>
            <input name="from" value="<?= ($this->request->getQuery('from') != ""?intval($this->request->getQuery('from')):1000000)?>" min="0" max="150000000" step="500000" type="range"/>
            <input name="to" value="<?= ($this->request->getQuery('to') != ""?intval($this->request->getQuery('to')):80000000)?>" min="0" max="150000000" step="500000" type="range"/>
            <svg width="100%" height="24">
                <line x1="4" y1="0" x2="300" y2="0" stroke="#444" stroke-width="12" stroke-dasharray="1 28"></line>
            </svg>
        </div><br>
        
        <div class=" text-center">
            <button class="btn1 button button-primary button-circle button-small m-0 fw-semibold nott ls0 text-end mb-2">
                فیلتر قیمت <i class="icon-angle-left"></i>
            </button>
        </div>
        <?=$this->Form->end();?>

    </div>
    

    <script>
(function () {
	var parent = document.querySelector(".range-slider");
	if (!parent) return;

	var rangeS = parent.querySelectorAll("input[type=range]"),
		numberS = parent.querySelectorAll("input[type=text]");

	rangeS.forEach(function (el) {
		el.oninput = function () {
			var slide1 = parseFloat(rangeS[0].value),
				slide2 = parseFloat(rangeS[1].value);

			if (slide1 > slide2) {
				[slide1, slide2] = [slide2, slide1];
				// var tmp = slide2;
				// slide2 = slide1;
				// slide1 = tmp;
			}

			numberS[0].value = slide1.toLocaleString();
			numberS[1].value = slide2.toLocaleString();
		};
	});

	numberS.forEach(function (el) {
		el.oninput = function () {
			var number1 = parseFloat(numberS[0].value.replace(/,/g, '')),
				number2 = parseFloat(numberS[1].value.replace(/,/g, ''));

			if (number1 > number2) {
				var tmp = number1;
				numberS[0].value = number2;
				numberS[1].value = tmp;
			}

			rangeS[0].value = number1;
			rangeS[1].value = number2;
		};
	});
})();


	</script>
    <!-- <div class="sidebar-widgets-wrap">
        <?php //use Cake\View\Cell;echo $this->cell('Widget.View',['sidebar_shopindex']);?>
    </div> -->
</div><!-- .sidebar end -->
