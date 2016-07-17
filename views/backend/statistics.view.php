<?php //Debug::dump($categories_years_visitors); ?>
<div class='events-admin'>
    <div class="vertical-align margin-bottom-1">
        <div class="text-left row-phone">
            <?php echo Html::heading(__('Statistics', 'events'), 2); ?>
        </div>
        <div class="text-right row-phone">
            <div class="btn-group text-left">
                <button
                    class="btn btn-primary new-event"
                    title="<?php echo __('New', 'events'); ?>"
                >
                    <span class="hidden-sm hidden-xs"><?php echo __('Add', 'events'); ?></span>
                    <span class="glyphicon glyphicon-plus visible-sm visible-xs" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" class="new-event" title="<?php echo __('New Event', 'events'); ?>"><?php echo __('Add event', 'events'); ?></a></li>
                    <li><a href="#" class="new-category" title="<?php echo __('New Category', 'events'); ?>"><?php echo __('Add Category', 'events'); ?></a></li>
                    <li><a href="#" class="new-location" title="<?php echo __('New Location', 'events'); ?>"><?php echo __('Add Location', 'events'); ?></a></li>
                </ul>
            </div>
            <a href="index.php?id=events" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('List', 'events'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></span>
            </a>
            <a href="index.php?id=events&action=configuration" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('Configuration', 'events'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></span>
            </a>
            <a href="index.php?id=events&action=stats" class="btn btn-default">
                <span class="hidden-sm hidden-xs"><?php echo __('Stats', 'events'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></span>
            </a>
            <a href="#" class="btn btn-default readme-plugin" title="<?php echo __('Documentation', 'events'); ?>" data-toggle="modal" data-target="#modal-documentation" readme-plugin="events">
                <span class="hidden-sm hidden-xs"><?php echo __('Documentation', 'events'); ?></span>
                <span class="visible-sm visible-xs"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo Html::heading(__('Events', 'events'), 3); ?>
            <?php echo Html::heading(__('Number of archived events per year', 'events'), 4); ?>
            <canvas id="year-events" height="400" width="500"></canvas>
            <?php echo Html::heading(__('Number of participants per year', 'events'), 4, array('class' => 'margin-top-2')); ?>
            <canvas id="year-visitors" height="400" width="500"></canvas>
            <p><?php echo __('Note that events without information about the number of participants cannot be included in years evaluation.', 'events'); ?></p>
            <?php foreach ($participants as $category => $events) { ?>
                <?php echo Html::heading(__('Participants', 'events') . ' in ' . $categories[$category]['title'], 4, array('class' => 'margin-top-2')); ?>
                <canvas id="event-visitors-<?php echo $category; ?>" height="400" width="500"></canvas>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <hr class="visible-sm visible-xs"/>
            <?php echo Html::heading(__('Categories', 'events'), 3); ?>
            <?php echo Html::heading(__('Total number of assigned events (drafts included)', 'events'), 4); ?>
            <canvas id="category-events" height="400" width="500"></canvas>
            <hr />
            <?php echo Html::heading(__('Locations', 'events'), 3); ?>
            <?php echo Html::heading(__('Map of all existing locations', 'events'), 4); ?>
            <div id="mapdiv" style="height: 400px; width: 100%;"></div>
            <?php echo Html::heading(__('Total number of assigned events (drafts included)', 'events'), 4, array('class' => 'margin-top-2')); ?>
            <canvas id="location-events" height="400" width="500"></canvas>
        </div>
    </div>
    <div class="row margin-top-2">
        <div class="col-md-6">
            <?php echo Html::anchor(__('Back', 'events'), 'index.php?id=events', array('title' => __('Back', 'events'), 'class' => 'btn btn-default')); ?>
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
