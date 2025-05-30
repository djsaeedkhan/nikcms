<?php
echo $this->element('Template.header',['page'=>'page']);
//echo $this->html->css(['/template/challenge/challenge.css']);
?>
<style>
.page .slider-handler {height: 700px;}
#posts{display: none;}
</style>
<!-- ---------------------------------------------------->
<section class="slider-handler" 
  style="<?=$challenge->img2!= ''?'background-image: url('.$challenge->img2.');':''?>">
    <div class="container">
      <div class="row pt-2">
        <div class="col-lg-5 col-sm-6 pt-3 text-dark lsclass">
			<?= $this->Flash->render() ?><br>
			<?php
			echo $this->Form->create(null);
			echo $this->Form->control('chpass',['class'=>'form-control','label'=>'رمز عبور','dir'=>'ltr']).'<br>';
			echo $this->Form->submit('ورود',['class'=>'btn btn-success']);
			?>
        </div>
      </div>
    </div>
  </section>

<!-- <section class="service-section service-section2"style="background-image1: url('<?=setting['b3_bgimg']?>');background: #f9f9f9;padding: 20px 0;">
	<div class="container">
		<div class="row">
			<div class="boxbg p-3 pt-4 mt-3">
				<?php $this->Flash->render() ?>
				<?php $this->fetch('content');?>
			</div>
		</div>
	</div>
</section> -->
<style>
	.lsclass{
		margin: 0 auto;
		background: #FFF;
		margin-top: 50px;
		padding: 15px;
		border-radius: 10px;
	}

</style>
<?= $this->element('Template.footer')?>