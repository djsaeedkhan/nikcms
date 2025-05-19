<div class="col-12">
	<h2 class="content-header-title float-right mb-0">
		لیست پیام های من
	</h2><br><br>
</div>

<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<!-- <th scope="col"><?= $this->Paginator->sort('id', __d('Template', 'شماره تیکت')) ?></th> -->
			<th scope="col"><?= $this->Paginator->sort('subject', __d('Ticketing', 'عنوان')) ?></th>
			<th scope="col"><?= $this->Paginator->sort('ticketstatus_id', __d('Ticketing', 'وضعیت')) ?></th>
			<!-- <th scope="col"><?= $this->Paginator->sort('ticketpriority_id', __d('Ticketing', 'اولویت')) ?></th> -->
			<th scope="col"><?= $this->Paginator->sort('ticketcategory_id', __d('Ticketing', 'دسته بندی')) ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', __d('Ticketing', 'تاریخ ثبت')) ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($tickets as $ticket): ?>
		<tr>
			<!-- <td><?= $this->Number->format($ticket->id) ?></td> -->
			<td>
				<?= $ticket->completed?
					'<span class="badge badge-danger" title="'.
						__d('Template', 'تیکت').' '.__d('Ticketing', 'بسته شده') .'">*</span>':
					'<span class="badge badge-success" title="'.
						__d('Template', 'تیکت').' '.__d('Ticketing', 'باز') .'">*</span>' ?>
				
				<?= h($ticket->subject) ?>
				<div class="hidme">
					<?= $this->Html->link(__d('Ticketing', 'پاسخ ها'), '/tickets/submit/'.$ticket->id) ?>
				</div>
			</td>
			<td>
				<?php
				if ($ticket->has('ticketcomments') and count($ticket['ticketcomments']) > 0) {
					if($ticket['ticketcomments'][0]['user_id'] == $ticket['user_id']) :
						echo '<span class="badge badge-secondary">'. __d('Ticketing', 'در انتظار پاسخ') .'</span>';
					else:
						echo '<span class="badge badge-primary">'. __d('Ticketing', 'پاسخ داده شده') .'</span>';
					endif;
				}
				?>
				<?= $ticket->has('ticketstatus') ? $ticket->ticketstatus->title: '' ?></td>
			<!-- <td><?= $ticket->has('ticketpriority') ? $ticket->ticketpriority->title : '' ?></td> -->
			<td><?= $ticket->has('ticketcategory') ? $ticket->ticketcategory->title : '' ?></td>
			<td><?= $this->Func->date2($ticket->created) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table></div>