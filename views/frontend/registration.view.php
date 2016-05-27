<?php //Debug::dump(UPcon::validateAge('08-06-1998')); ?>
<!-- notifications -->
<?php if (Notification::get('success')) { ?><div class="notification notification-success"><?php echo Notification::get('success'); ?></div><?php } ?>
<?php if (Notification::get('error')) { ?><div class="notification notification-error"><?php echo Notification::get('error'); ?></div><?php } ?>
<!-- plugin content -->
<div class="upcon-plugin">
    <?php echo
        Form::open(Null, array('role' => 'form')) .
        Form::hidden('csrf', Security::token());
    ?>
    <?php echo Html::heading(__('Persönliche Daten', 'upcon'), 3); ?>
    <div class="row uniform">
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('prename', __('Vorname', 'upcon') . Html::nbsp() . '*') .
                Form::input('prename', $data['prename'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('lastname', __('Nachname', 'upcon') . Html::nbsp() . '*') .
                Form::input('lastname', $data['lastname'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('gender', __('Du bist...', 'upcon') . Html::nbsp() . '*') .
                Form::select('gender', $gender, $data['gender'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('birthday', __('Geburtstag', 'upcon') . Html::nbsp() . '*');
            ?>
        </div>
        <div class="2u 4u(xsmall) stacked">
            <?php echo
                Form::select('birthday_d', array_combine(range(1,31), range(1,31)), $data['birthday_d'], array('required' => 'required'));
            ?>
        </div>
        <div class="2u 4u(xsmall) stacked small-gap">
            <?php echo
                Form::select('birthday_m', array_combine(range(1,12), array('Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez')), $data['birthday_m'], array('required' => 'required'));
            ?>
        </div>
        <div class="2u 4u$(xsmall) stacked small-gap">
            <?php echo
                Form::select('birthday_y', array_combine(range(2004,1910), range(2004,1910)), $data['birthday_y'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('email', __('E-Mail', 'upcon') . Html::nbsp() . '*') .
                Form::input('email', $data['email'], array('type' => 'email', 'required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('mobile', __('Telefon', 'upcon')) .
                Form::input('mobile', $data['mobile']);
            ?>
        </div>
    </div>
    <?php echo Html::heading(__('Adressdaten', 'upcon'), 3); ?>
    <div class="row uniform">
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('address', __('Adresse, Hausnummer', 'upcon') . Html::nbsp() . '*') .
                Form::input('address', $data['address'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('zip', __('PLZ', 'upcon')) .
                Form::input('zip', $data['zip']);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('city', __('Stadt', 'upcon') . Html::nbsp() . '*') .
                Form::input('city', $data['city'], array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('country', __('Land', 'upcon') . Html::nbsp() . '*') .
                Form::input('country', $data['country'], array('required' => 'required'));
            ?>
        </div>
    </div>
    <?php echo Html::heading(__('Teilnahmedaten', 'upcon'), 3); ?>
    <div class="row uniform">
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('status', __('Status', 'upcon') . Html::nbsp() . '*') .
                Form::select('status', $status, $data['status'], array('id' => 'upcon-status', 'required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('youthgroup', __('Jugendgruppe', 'upcon')) .
                Form::input('youthgroup', $data['youthgroup']);
            ?>
        </div>
        <div class="6u$ 12u$(xsmall) upcon-staff">
            <?php echo
                Form::label('safecom_visited', __('Sichere Gemeinde besucht', 'upcon')) .
                Form::select('safecom_visited', $decision, $data['safecom_visited']);
            ?>
        </div>
        <div class="6u$ 12u$(xsmall) upcon-guest">
            <?php echo
                Form::label('arrival', __('Anreisedatum, Tag + Uhrzeit', 'upcon')) .
                Form::input('arrival', $data['arrival']);
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('message', __('Hinweis', 'upcon')) .
                Form::textarea('message', $data['message'], array('class' => 'input-xxlarge', 'placeholder' => __('Essen, Sport, Krankheiten...', 'upcon')));
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('terms_accepted', __('Ich akzeptiere die <a href="https://update.berlin/datenschutz" target="_blank">Datenschutzbedingungen</a>', 'upcon') . Html::nbsp() . '*') .
                Form::select('terms_accepted', $decision, $data['terms_accepted'], array('required' => 'required'));
            ?>
        </div>
        <div class="12u$">
            <ul class="actions align-center">
                <li><?php echo Form::submit('upcon_registration_submitted', __('UP damit', 'upcon'), array('class' => 'special')); ?></li>
            </ul>
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>
