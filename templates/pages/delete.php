<?php
$note = $params['note'] ?? null;
?>
<div class="delete">
    <?php if ($note) : ?>
        <ul>
            <li>
                Id: <?= $note['id'] ?>
            </li>
            <li>
                Tytuł: <?= $note['title'] ?>
            </li>
            <li>
                Data: <?= $note['created'] ?>
            </li>
            <li>
                Opis: <?= $note['description'] ?>
            </li>
        </ul>
        <form action="/?action=delete" method="post">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <input type="submit" value="Usuń">
        </form>
    <?php else : ?>
        <div>Brak notatki</div>
    <?php endif; ?>
    <a href="/"><button>Powrót</button></a>
</div>