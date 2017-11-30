<nav class="navigation pagination" role="navigation">
    <h2 class="screen-reader-text"><?php _e('Posts navigation', 'fulcrum'); ?></h2>
    <div class="nav-links">
        <?php if ($prevUri) : ?>
            <a clas="prev page-numbers" href="<?php echo esc_url($prevUri); ?>"><?php _e('Previous', 'fulcrum'); ?></a>
        <?php endif; ?>

        <?php for ($pageNumber = 1; $pageNumber <= $this->totalPages; $pageNumber++) : ?>
            <a class="page-numbers<?php echo $this->get_page_class($pageNumber); ?>"
               href="<?php echo esc_url($this->getPageUri($pageNumber)); ?>">
                <span class="screen-reader-text">Page </span><?php echo (int) $pageNumber; ?>
            </a>
        <?php endfor; ?>

        <?php if ($nextUri) : ?>
            <a class="next page-numbers" href="<?php echo esc_url($nextUri); ?>"><?php _e('Next', 'fulcrum'); ?></a>
        <?php endif; ?>
    </div>
</nav>
