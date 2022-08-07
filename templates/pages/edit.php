<div>
    <h3>Edycja notatki</h3>
    <div>
        <?php $note = $params['note'] ?>
        <form class="note-form" action="/?action=edit" method="post">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" value="<?= $note['title'] ?>">
                </li>
                <li>
                    <label>Opis</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?= $note['description'] ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit">
                </li>
            </ul>
        </form>
    </div>
</div>