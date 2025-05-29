<div id="container">
        <div id="header">
            <h1><?= __d('Admin', 'خطا') ?></h1>
        </div>
        <div id="content">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
        </div>
        <div id="footer">
            <?= $this->Auths->link(__d('Admin', 'برگشت'), 'javascript:history.back()') ?>
        </div>
    </div>