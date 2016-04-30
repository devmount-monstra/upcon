<div class="upcon-plugin">
    <h4><?php echo Option::get('upcon_title'); ?></h4>
    <?php echo
        Form::open(Null, array('role' => 'form')) .
        Form::hidden('csrf', Security::token()) .
        Form::hidden('upcon_id', Option::get('upcon_id'));
    ?>
    <div class="row uniform">
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_prename', __('Vorname', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_prename', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_lastname', __('Nachname', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_lastname', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_gender', __('Du bist...', 'upcon') . Html::nbsp() . '*') .
                Form::select('event_gender', $gender, Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_birthday', __('Geburtstag', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_birthday', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_email', __('E-Mail', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_email', '', array('type' => 'email', 'required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_address', __('Adresse / Hausnummer', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_address', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_zip', __('PLZ', 'upcon')) .
                Form::input('event_zip', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_country', __('Land', 'upcon') . Html::nbsp() . '*') .
                Form::input('event_country', Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_mobile', __('Telefon', 'upcon')) .
                Form::input('event_mobile', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_status', __('Status', 'upcon') . Html::nbsp() . '*') .
                Form::select('event_status', $status, Null, array('required' => 'required'));
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_youthgroup', __('Jugendgruppe', 'upcon')) .
                Form::input('event_youthgroup', Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_safecom_visited', __('Sichere Gemeinde besucht (für Mitarbeiter)', 'upcon')) .
                Form::select('event_safecom_visited', $decision, Null);
            ?>
        </div>
        <div class="6u 12u$(xsmall)">
            <?php echo
                Form::label('event_arrival', __('Anreisedatum (für Tagesgäste)', 'upcon')) .
                Form::input('event_arrival', '');
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('event_message', __('Hinweis', 'upcon')) .
                Form::textarea('event_message', Null, array('class' => 'input-xxlarge', 'placeholder' => __('Essen, Sport, Krankheiten...', 'upcon')));
            ?>
        </div>
        <div class="12u$">
            <?php echo
                Form::label('event_terms_accepted', __('Ich akzeptiere AGB und Datenschutzbedingungen', 'upcon') . Html::nbsp() . '*') .
                Form::select('event_terms_accepted', $decision, Null, array('required' => 'required'));
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