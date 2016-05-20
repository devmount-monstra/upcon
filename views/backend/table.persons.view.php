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
        <?php if (sizeof($persons) > 0) {
            foreach ($persons as $person) { ?>
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
                            <a href="#" class="btn btn-info upcon-person-info" data-toggle="modal" data-target="#modal-person-info" upcon-person="<?php echo $person['id']; ?>">
                                <?php echo __('Info', 'upcon'); ?>
                            </a>
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
                    <?php echo __('No ' . $type . ' persons available.', 'upcon'); ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
