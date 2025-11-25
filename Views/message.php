<?php
/** @var \Helpers\Message $message */
?>

<?php if ($message): ?>
    <div class="alert <?= $message->color ?> my-3">
        <strong><?= $this->e($message->title) ?> :</strong>
        <?= $this->e($message->content) ?>
    </div>
<?php endif; ?>

