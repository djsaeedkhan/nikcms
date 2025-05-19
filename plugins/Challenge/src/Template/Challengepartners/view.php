<h3><?= h($challengepartner->title) ?></h3>
<table class="vertical-table">
    <tr>
        <th scope="row"><?= __('Challenge') ?></th>
        <td><?= $challengepartner->has('challenge') ? $this->Html->link($challengepartner->challenge->title, ['controller' => 'Challenges', 'action' => 'view', $challengepartner->challenge->id]) : '' ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Title') ?></th>
        <td><?= h($challengepartner->title) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Id') ?></th>
        <td><?= $this->Number->format($challengepartner->id) ?></td>
    </tr>
</table>
<div class="row">
    <h4><?= __('Link') ?></h4>
    <?= $this->Text->autoParagraph(h($challengepartner->link)); ?>
</div>
<div class="row">
    <h4><?= __('Image') ?></h4>
    <?= $this->Text->autoParagraph(h($challengepartner->image)); ?>
</div>