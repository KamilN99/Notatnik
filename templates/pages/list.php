<div class="list">
    <section>
        <div class="message">
            <?php if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Dodano nową notatkę';
                        break;
                    case 'deleted':
                        echo 'Notatka została usunięta';
                        break;
                    case 'edited':
                        echo 'Notatka została zaktualizowana';
                        break;
                }
            }
            ?>
        </div>
        <div class="error">
            <?php if (!empty($params['error'])) {
                switch ($params['error']) {
                    case 'noteNotFound':
                        echo 'Notatka nie istnieje';
                        break;
                    case 'noteIdNotFound':
                        echo 'Niepoprawne id';
                        break;
                }
            }
            ?>
        </div>
        <?php
        $phrase = $params['phrase'] ?? null;

        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $pageNumber = (int)$page['pagenumber'] ?? 1;
        $pages = (int)$page['pages'] ?? 1;
        ?>
        <div>
            <form class="settings-form" action="/" method="GET">
                <div>
                    <label><input type="text" name="phrase" value="<?= $phrase ?>"></label>
                </div>
                <div>
                    <div>Sortuj:</div>
                    <label>Tytule: <input type="radio" name="sortby" value="title" <?= $by === 'title' ? 'checked' : '' ?>></label>
                    <label>Dacie: <input type="radio" name="sortby" value="created" <?= $by === 'created' ? 'checked' : '' ?>></label>
                </div>
                <div>
                    <label>Rosnąco: <input type="radio" name="sortorder" value="asc" <?= $order === 'asc' ? 'checked' : '' ?>></label>
                    <label>Malejąco: <input type="radio" name="sortorder" value="desc" <?= $order === 'desc' ? 'checked' : '' ?>></label>
                </div>
                <input type="submit" value="Szukaj">
            </form>
        </div>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php foreach ($params['notes'] ?? [] as $note) : ?>
                        <tr>
                            <td><?= $note['id'] ?></td>
                            <td><?= $note['title'] ?></td>
                            <td><?= $note['created'] ?></td>
                            <td><a href="/?action=show&id=<?= $note['id'] ?>"><button>Szczegóły</button></a></td>
                            <td><a href="/?action=delete&id=<?= $note['id'] ?>"><button>Usuń</button></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="pagination">
            <?php if ($pageNumber > 1) : ?>
                <?php $number = $pageNumber - 1 ?>
                <a href="/?pagenumber=<?= $number ?>&sortby=<?= $by ?>&sortorder=<?= $order ?>">
                    << </a>
                    <?php endif; ?>
                    <?php if ($pageNumber === $pages || $pages === 1) : ?>
                        <div><?= $pageNumber ?></div>
                    <?php else : ?>
                        <div><?= $pageNumber . ' / ' . $pages ?></div>
                    <?php endif; ?>
                    <?php if ($pageNumber < $pages) : ?>
                        <?php $number = $pageNumber + 1 ?>
                        <a href="/?pagenumber=<?= $number ?>&sortby=<?= $by ?>&sortorder=<?= $order ?>">
                            >>
                        </a>
                    <?php endif; ?>
        </div>
    </section>
</div>