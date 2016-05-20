<?php //Debug::dump($persons); ?>
<!-- i18n PHP output for JS -->
<?php echo
    Form::hidden('output_add', __('Add', 'upcon')) .
    Form::hidden('output_editevent', __('Edit event', 'upcon')) .
    Form::hidden('output_addevent', __('Add event', 'upcon')) .
    Form::hidden('output_editcategory', __('Edit category', 'upcon')) .
    Form::hidden('output_addcategory', __('Add category', 'upcon')) .
    Form::hidden('output_update', __('Update', 'upcon'));
?>


<!-- content -->
<div class='upcon-admin'>

    <div class="vertical-align margin-bottom-1">
        <div class="text-left row-phone">
            <?php echo Html::heading(__('UPcon', 'upcon'), 2); ?>
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
<!--             <a href="index.php?id=upcon&action=stats" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('Stats', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></span>
            </a> -->
            <a href="#" class="btn btn-default readme-plugin" title="<?php echo __('Documentation', 'upcon'); ?>" data-toggle="modal" data-target="#modal-documentation" readme-plugin="upcon">
                <span class="hidden-sm hidden-xs"><?php echo __('Documentation', 'upcon'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></span>
            </a>
        </div>
    </div>

    <!-- Main tab navigation -->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#confirmed" data-toggle="tab">
                <span class="hidden-sm hidden-xs"><?php echo __('Confirmed', 'upcon') . ' (' . sizeof($persons_confirmed) . ')'; ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
            </a>
        </li>
        <li>
            <a href="#pending" data-toggle="tab">
                <span class="hidden-sm hidden-xs"><?php echo __('Pending', 'upcon') . ' (' . sizeof($persons_pending) . ')'; ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
            </a>
        </li>
    </ul>

    <!-- Main tab content -->
    <div class="tab-content">

        <!-- Tab: confirmed -->
        <div class="tab-pane active" id="confirmed">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'upcon'); ?></th>
                        <th><?php echo __('Birthday', 'upcon'); ?></th>
                        <th><?php echo __('Email', 'upcon'); ?></th>
                        <th><?php echo __('Status', 'upcon'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (sizeof($persons_confirmed) > 0) {
                        foreach ($persons_confirmed as $person) { ?>
                            <tr>
                                <td>
                                    <?php echo $person['prename'] . ' ' . $person['lastname']; ?>
                                </td>
                                <td>
                                    <?php echo $person['birthday']; ?>
                                </td>
                                <td>
                                    <?php echo $person['email']; ?>
                                </td>
                                <td>
                                    <?php echo $person['status']; ?>
                                </td>
                                <td>
                                    <div class="pull-right">
                                        <?php echo
                                            Form::open() .
                                            Form::hidden('csrf', Security::token()) .
                                            Form::hidden('delete_person', $person['id']);
                                        ?>
                                            <button
                                                class="btn btn-danger"
                                                value="1"
                                                onclick="return confirmDelete('<?php echo __('Delete person »:name«', 'upcon', array(':name' => $person['prename'] . ' ' . $person['lastname'])); ?>')"
                                                title="<?php echo __('Delete', 'upcon'); ?>"
                                            >
                                                <?php echo __('Delete', 'upcon'); ?>
                                            </button>
                                        <?php echo Form::close(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">
                                <?php echo __('No confirmed persons available.', 'upcon'); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Tab: pending -->
        <div class="tab-pane" id="pending">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'upcon'); ?></th>
                        <th><?php echo __('Birthday', 'upcon'); ?></th>
                        <th><?php echo __('Email', 'upcon'); ?></th>
                        <th><?php echo __('Status', 'upcon'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (sizeof($persons_pending) > 0) {
                        foreach ($persons_pending as $person) { ?>
                            <tr>
                                <td>
                                    <?php echo $person['prename'] . ' ' . $person['lastname']; ?>
                                </td>
                                <td>
                                    <?php echo $person['birthday']; ?>
                                </td>
                                <td>
                                    <?php echo $person['email']; ?>
                                </td>
                                <td>
                                    <?php echo $person['status']; ?>
                                </td>
                                <td>
                                    <div class="pull-right">
                                        <?php echo
                                            Form::open() .
                                            Form::hidden('csrf', Security::token()) .
                                            Form::hidden('delete_person', $person['id']);
                                        ?>
                                            <button
                                                class="btn btn-danger"
                                                value="1"
                                                onclick="return confirmDelete('<?php echo __('Delete person »:name«', 'upcon', array(':name' => $person['prename'] . ' ' . $person['lastname'])); ?>')"
                                                title="<?php echo __('Delete', 'upcon'); ?>"
                                            >
                                                <?php echo __('Delete', 'upcon'); ?>
                                            </button>
                                        <?php echo Form::close(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">
                                <?php echo __('No pending persons available.', 'upcon'); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
