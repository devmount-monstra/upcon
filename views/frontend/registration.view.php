<div class="upcon-plugin">
    <h4 class="modal-title"><?php echo Option::get('upcon_title'); ?></h4>
    <?php echo
        Form::open(Null, array('role' => 'form')) .
        Form::hidden('csrf', Security::token());
        Form::hidden('upcon_id', Option::get('upcon_id'));
    ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_prename', __('Vorname', 'upcon')) .
                    Form::input('event_prename', Null, array('class' => 'form-control', 'required' => 'required'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_lastname', __('Nachname', 'upcon')) .
                    Form::input('event_lastname', Null, array('class' => 'form-control', 'required' => 'required'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_gender', __('Geschlecht', 'upcon')) .
                    Form::select('event_gender', $gender, Null, array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_birthday', __('Geburtstag', 'upcon')) .
                    Form::input('event_birthday', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_email', __('E-Mail', 'upcon')) .
                    Form::input('event_email', '', array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_address', __('Adresse / Hausnummer', 'upcon')) .
                    Form::input('event_address', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_zip', __('PLZ', 'upcon')) .
                    Form::input('event_zip', '', array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_country', __('Land', 'upcon')) .
                    Form::input('event_country', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_mobile', __('Telefon', 'upcon')) .
                    Form::input('event_mobile', '', array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_status', __('Status', 'upcon')) .
                    Form::input('event_status', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_youthgroup', __('Jugendgruppe', 'upcon')) .
                    Form::input('event_youthgroup', '', array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_safecom_visited', __('Sichere Gemeinde besucht (für Mitarbeiter)', 'upcon')) .
                    Form::input('event_safecom_visited', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_arrival', __('Anreisedatum (für Tagesgäste)', 'upcon')) .
                    Form::input('event_arrival', '', array('class' => 'form-control'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_message', __('Hinweis (Essen, Sport, Krankheiten)', 'upcon')) .
                    Form::input('event_message', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo
                    Form::label('event_terms_accepted', __('Ich akzeptiere AGB und Datenschutzbedingungen', 'upcon')) .
                    Form::input('event_terms_accepted', '', array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_category', __('Category', 'upcon')) .
                    Form::select('event_category', $categories_active_title, Null, array('class' => 'form-control', 'required' => 'required'));
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo Form::label('event-color', __('Color', 'upcon')); ?>
                <div class="input-group">
                    <span class="input-group-addon" id="event-color-addon">#</span>
                    <?php echo Form::input('event_color', Null, array('class' => 'form-control', 'id' => 'event-color', 'aria-describedby' => 'event-color-addon')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo Form::label('event_location', __('Location', 'upcon')); ?>
                <div class="input-group">
                    <span class="input-group-addon" id="event-location-addon">@</span>
                    <?php echo Form::input('event_location', Null, array('class' => 'form-control', 'aria-describedby' => 'event-location-addon')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo Form::label('event_address', __('address', 'upcon')); ?>
                <div class="input-group">
                    <span class="input-group-addon" id="event-address-addon"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></span>
                    <?php echo Form::input('event_address', Null, array('class' => 'form-control', 'aria-describedby' => 'event-address-addon')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo
                    Form::label('event_short', __('Short description', 'upcon')) .
                    Form::input('event_short', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo
                    Form::label('event_description', __('Description', 'upcon')) .
                    Form::textarea('event_description', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo Form::label('event_hashtag', __('Hashtag', 'upcon')); ?>
                <div class="input-group">
                    <span class="input-group-addon" id="event-hashtag-addon">#</span>
                    <?php echo Form::input('event_hashtag', Null, array('class' => 'form-control', 'aria-describedby' => 'event-hashtag-addon')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_facebook', __('Facebook URL', 'upcon')) .
                    Form::input('event_facebook', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php
                    echo Form::label('event_image', __('Image file', 'upcon'));
                    if (sizeof($files)>1) {
                        echo Form::select('event_image', $files, Null, array('class' => 'form-control'));
                    } else {
                        echo Form::select('event_image', array(), Null, array('class' => 'form-control', 'disabled' => 'disabled', 'title' => __('No file available in configured image directory', 'upcon')));
                    }
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_audio', __('Audio file', 'upcon')) .
                    Form::input('event_audio', Null, array('class' => 'form-control'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo
                    Form::label('event_imagesection', __('Clip image', 'upcon')) . Html::br();
                ?>
                <label class="image-section-label" title="Clip to top"><?php echo Form::radio('event_imagesection', 't'); ?>
                    <span class="image-section section-portrait section-top"></span>
                </label>
                <label class="image-section-label" title="Clip to middle"><?php echo Form::radio('event_imagesection', 'm', True); ?>
                    <span class="image-section section-portrait section-middle"></span>
                </label>
                <label class="image-section-label" title="Clip to bottom"><?php echo Form::radio('event_imagesection', 'b'); ?>
                    <span class="image-section section-portrait section-bottom"></span>
                </label>
                <label class="image-section-label" title="Clip to left"><?php echo Form::radio('event_imagesection', 'l'); ?>
                    <span class="image-section section-landscape section-left"></span>
                </label>
                <label class="image-section-label" title="Clip to center"><?php echo Form::radio('event_imagesection', 'c'); ?>
                    <span class="image-section section-landscape section-center"></span>
                </label>
                <label class="image-section-label" title="Clip to right"><?php echo Form::radio('event_imagesection', 'r'); ?>
                    <span class="image-section section-landscape section-right"></span>
                </label>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button
            type="button"
            class="btn btn-default"
            data-dismiss="modal"
        >
            <?php echo __('Cancel', 'upcon'); ?>
        </button>
        <button
            type="submit"
            name="add_event"
            id="add-edit-submit-event"
            class="btn btn-primary"
            value="1"
            title="<?php echo __('Add', 'upcon'); ?>"
        >
            <?php echo __('Add', 'upcon'); ?>
        </button>
    </div>
    <?php echo Form::close(); ?>

</div>