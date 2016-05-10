<div class='upcon-admin'>
    <div class="vertical-align margin-bottom-1">
        <div class="text-left row-phone">
            <?php echo Html::heading(__('Configuration', 'upcon'), 2); ?>
        </div>
        <div class="text-right row-phone">
            <a href="index.php?id=upcon" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('List', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></span>
            </a>
            <a href="index.php?id=upcon&action=configuration" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('Configuration', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></span>
            </a>
            <a href="index.php?id=upcon&action=stats" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('Stats', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></span>
            </a>
            <a href="#" class="btn btn-default readme-plugin" title="<?php echo __('Documentation', 'upcon'); ?>" data-toggle="modal" data-target="#modal-documentation" readme-plugin="upcon">
                <span class="hidden-sm hidden-xs"><?php echo __('Documentation', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo Html::heading(__('Options', 'upcon'), 3); ?>
            <?php echo
                Form::open() .
                Form::hidden('csrf', Security::token()) .
                HTML::br();
            ?>
            <div class="row">
                <div class="col-md-6">
                    <!-- config image directory -->
                    <?php echo
                        Form::label('upcon_image_directory', __('Image directory for upcon', 'upcon'), array('data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Existing directory for event images, that will be displayed in the select list of the upcon add/edit form', 'upcon'))) .
                        Form::select('upcon_image_directory', $directories, Option::get('upcon_image_directory'), array('class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <!-- config archive description placeholder -->
                    <?php echo
                        Form::label('upcon_placeholder_archive', __('Archive description field', 'upcon'), array('data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Custom placeholder text for "Archive description" textarea in the upcon add/edit form', 'upcon'))) .
                        Form::input('upcon_placeholder_archive', Option::get('upcon_placeholder_archive'), array('class' => 'form-control'));
                    ?>
                </div>
            </div>
            <div class="row margin-top-1">
                <div class="col-sm-12">
                    <button
                        type="submit"
                        name="upcon_options_update"
                        class="btn btn-primary"
                        value="1"
                        title="<?php echo __('Save', 'upcon'); ?>"
                    >
                        <?php echo __('Save', 'upcon'); ?>
                    </button>
                </div>
            </div>
            <?php echo Form::close(); ?>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>

<!-- modal: README markup -->
<div id="modal-documentation" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title" id="myModalLabel">README.md</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
