<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
    <?php
        echo $this->Form->input('email', ['label' => 'E-mail', 'required' => true, 'type' => 'email']);
        echo $this->Form->input('senha', ['type'=>'password', 'required' => true]);
        echo $this->Form->submit('Entrar');
    ?>
    </fieldset>
<?= $this->Form->end() ?>
