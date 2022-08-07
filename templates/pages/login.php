<div>
    <div class="message">
        <?php if (!empty($params['before'])) {
            echo 'Błędne dane logowania';
        }
        ?>
    </div>
    <h3> Logowanie </h3>
    <div>
        <form class="note-form" action="/?action=login" method="post">
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
                    <input type="submit" value="Zaloguj">
                </li>
            </ul>
        </form>
    </div>
</div>