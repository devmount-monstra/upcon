<div class="upcon-plugin">
    <?php echo
        Form::open(Null, array('role' => 'form')) .
        Form::hidden('csrf', Security::token());
    ?>
    <div class="row uniform">
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('prename', __('Vorname', 'upcon') . Html::nbsp() . '*') .
                Form::input('prename', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('lastname', __('Nachname', 'upcon') . Html::nbsp() . '*') .
                Form::input('lastname', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('gender', __('Du bist...', 'upcon') . Html::nbsp() . '*') .
                Form::select('gender', $gender, Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('birthday', __('Geburtstag', 'upcon') . Html::nbsp() . '*');
            ?>
        </div>
        <div class="2u 4u(xsmall) stacked">
            <?php echo
                Form::select('birthday_d', array_combine(range(1,31), range(1,31)), Null, array('required' => 'required'));
            ?>
        </div>
        <div class="2u 4u(xsmall) stacked small-gap">
            <?php echo
                Form::select('birthday_m', array_combine(range(1,12), array('Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez')), Null, array('required' => 'required'));
            ?>
        </div>
        <div class="2u 4u$(xsmall) stacked small-gap">
            <?php echo
                Form::select('birthday_y', array_combine(range(2010,1910), range(2010,1910)), Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('email', __('E-Mail', 'upcon') . Html::nbsp() . '*') .
                Form::input('email', '', array('type' => 'email', 'required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('address', __('Adresse / Hausnummer', 'upcon') . Html::nbsp() . '*') .
                Form::input('address', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('zip', __('PLZ', 'upcon')) .
                Form::input('zip', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('country', __('Land', 'upcon') . Html::nbsp() . '*') .
                Form::input('country', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('mobile', __('Telefon', 'upcon')) .
                Form::input('mobile', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('status', __('Status', 'upcon') . Html::nbsp() . '*') .
                Form::select('status', $status, Null, array('id' => 'upcon-status', 'required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('youthgroup', __('Jugendgruppe', 'upcon')) .
                Form::input('youthgroup', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall) upcon-staff">
            <?php echo
                Form::label('safecom_visited', __('Sichere Gemeinde besucht', 'upcon')) .
                Form::select('safecom_visited', $decision, Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall) upcon-guest">
            <?php echo
                Form::label('arrival', __('Anreisedatum', 'upcon')) .
                Form::input('arrival', '');
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('message', __('Hinweis', 'upcon')) .
                Form::textarea('message', Null, array('class' => 'input-xxlarge', 'placeholder' => __('Essen, Sport, Krankheiten...', 'upcon')));
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('terms_accepted', __('Ich akzeptiere AGB und Datenschutzbedingungen', 'upcon') . Html::nbsp() . '*') .
                Form::select('terms_accepted', $decision, Null, array('required' => 'required'));
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