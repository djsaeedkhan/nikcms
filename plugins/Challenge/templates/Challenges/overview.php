<div class="entry mt-0">
<?php if($challenge->challengetexts):foreach($challenge->challengetexts as $text):?>
	<div class="grid-inner row align-items-center no-gutters">
		<div class="entry-content text-justify mt-0">
			<p><?=nl2br($text['title'])?></p>
		</div>
	</div>
	<?php endforeach;endif;?>
</div>