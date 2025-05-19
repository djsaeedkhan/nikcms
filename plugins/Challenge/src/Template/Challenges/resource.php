<!-- Posts
============================================= -->
<div id="posts" class="row grid-container gutter-40 has-init-isotope">
	<?php foreach($posts as $post):$metalist = $this->Func->MetaList($post);?>
	<div class="entry col-12 pb-2 mb-2" style="border-bottom: 1px solid #e8e9ed;">
		<div class="grid-inner row no-gutters">
			<?php
			$col = 12;
			if($img = $this->Query->postimage('thumbnail',$post)){
				echo '<div class="entry-image col-md-3 pl-3">'.
					$this->html->image($img, ['alt'=>$post['title'], 'title'=>$post['title']]).
					'</div>'; 
				$col = 9;
			}?>
			
			<div class="col-md-9 pl-md-4">
				<div class="entry-title title-sm">
					<h4><?=$post['title']?></h4>
				</div>
				<div class="entry-content text-justify mt-2">
					<p><?=$this->Query->the_mexcerpt($post['content'],100)?></p>
					<?php
					if(isset($metalist['download_link']) and $metalist['download_link']!=''):
						echo '<a href="'.$metalist['download_link'].'" 
								class="float-right button button-rounded button-reveal button-small button-white button-light float-right text-right">
								<i class="icon-circle-arrow-right"></i><span>
								دانلود فایل</span>
							</a>';
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
	<br>
	<?php endforeach?>
</div><!-- #posts end -->

