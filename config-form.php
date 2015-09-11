<?php $view = get_view(); ?>
<div id="pdf-embed-settings">
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('fontsize', __('Font Size')); ?>
        </div>
        <div class="inputs five columns omega">
            <p class="explanation">
                <?php
                echo __(
                    'Font size of the source code, in pixels.  '
                );
                ?>
            </p>
            <?php echo $view->formText('fontsize', $settings['fontsize']); ?>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <?php echo $view->formLabel('highlighting_style', __('Highlighting Style')); ?>
        </div>
        <div class="inputs five columns omega">
            <p class="explanation">
                <?php
                echo __(
                    'Choose the style to use for syntax highlighting'
                );
                ?>
            </p>
            <?php
            echo $view->formSelect('highlighting_style', $settings['highlighting_style'], array(), array(
                'default' => 'Default',
                'github' => 'GitHub',
                'obsidian' => 'Obsidian',
                'sunburst' => 'Sunburst',
                'tomorrow-night' => 'Tomorrow Night'
            ));
            ?>
        </div>
    </div>
</div>
