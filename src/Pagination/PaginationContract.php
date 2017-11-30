<?php

namespace Fulcrum\Foundation\Pagination;

interface PaginationContract
{
    /**
     * Render the pagination
     *
     * @since 3.0.0
     *
     * @param string $query
     * @param integer $currentPageNumber
     * @param integer $perPage
     * @param bool $echo
     * @param bool $total
     *
     * @return string
     */
    public function render($query, $currentPageNumber, $perPage, $echo = false, $total = false);
}
