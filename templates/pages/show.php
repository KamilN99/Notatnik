<?php
$note = $params['note'] ?? null;
?>
<div class="show">
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
        <a href="/?action=edit&id=<?= $note['id'] ?>"><button>Edytuj</button></a>
    <?php else : ?>
        <div>Brak notatki</div>
    <?php endif; ?>
    <a href="/"><button>Powrót</button></a>
</div>