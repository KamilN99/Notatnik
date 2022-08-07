<div>
    <div class="message">
        <?php if (!empty($params['before'])) {
            echo 'Istnieje już taki użytkownik';
        }
        ?>
    </div>
    <h3> Rejestracja </h3>
    <div>
        <form class="note-form" action="/?action=register" method="post">
            <ul>
                <li>
                    <label>Login <span class="required">*</span></label>
                    <input type="text" name="login" class="field-long">
                </li>
                <li>
                    <label>Hasło<span class="required">*</span></label>
                    <input type="password" name="password" class="field-long">
                </li>
                <li>
                    <input type="submit" value="Wyślij">
                </li>
            </ul>
        </form>
    </div>
</div>