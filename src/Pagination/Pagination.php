<?php

namespace Fulcrum\Foundation\Pagination;

class Pagination implements PaginationContract
{
    public $view = 'views/pagination.php';
    protected $currentPageNumber;
    protected $perPage;
    protected $total;
    protected $totalPages;
    protected $permalink;
    protected $permalinkQueryString;

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
    public function render($query, $currentPageNumber, $perPage, $echo = false, $total = false)
    {
        $this->initProperties($query, $currentPageNumber, $perPage, $total);
        if ($this->totalPages < 2) {
            return '';
        }

        $this->permalink            = get_permalink();
        $this->permalinkQueryString = $this->removeQueryStringArg();
        $prevUri                    = $this->getPreviousUri();
        $nextUri                    = $this->getNextUri();

        if ($echo) {
            ob_start();
        }

        include $this->view;

        if ($echo) {
            $pagination = ob_get_clean();

            return $pagination;
        }
    }

    /**
     * Initialize the properties.
     *
     * @since 3.0.0
     *
     * @param string $query
     * @param integer $currentPageNumber
     * @param integer $perPage
     * @param bool $total
     *
     * @return void
     */
    protected function initProperties($query, $currentPageNumber, $perPage, $total)
    {
        $this->currentPageNumber = (int) $currentPageNumber;
        $this->perPage           = (int) $perPage;
        $this->total             = $this->validateTotal($query, $total);

        $this->totalPages = $this->perPage > 0 ? ceil($this->total / $this->perPage) : 0;
    }

    /**
     * Remove query string arg
     *
     * Note: need to strip off the page from the incoming query string
     *
     * @param  string $argToRemove Default 'page'
     *
     * @return string Returns the query string
     */
    protected function removeQueryStringArg($argToRemove = 'pageNum')
    {
        $queryString = $_SERVER['QUERY_STRING'];
        $qsargs      = explode('&', $queryString);

        foreach ($qsargs as $key => $arg) {
            if (false === strpos($arg, $argToRemove)) {
                continue;
            }

            unset($qsargs[$key]);

            return implode('&', $qsargs);
        }

        return $queryString;
    }

    /**
     * Build the URI with all of the query strings (including the original)
     *
     * @since  3.0.0
     *
     * @param  integer $pageNumber Page number to append
     *
     * @return string URI
     */
    protected function buildUri($pageNumber)
    {
        $query = $this->permalinkQueryString
            ? "{$this->permalinkQueryString}&"
            : '';

        return sprintf('%s?%spageNum=%s', $this->permalink, $query, $pageNumber);
    }

    /**
     * Validate the total
     *
     * @since 3.0.0
     *
     * @param $query
     * @param $total
     *
     * @return int
     */
    protected function validateTotal($query, $total)
    {
        if (false !== $total) {
            return $total;
        }

        global $wpdb;

        $total = 0 === strpos($query, 'SELECT')
            ? count($wpdb->get_results($query))
            : absint($wpdb->get_var("SELECT COUNT(*) {$query}"));

        return $total;
    }

    /**
     * Get Previous URI.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function getPreviousUri()
    {
        if ($this->currentPageNumber > 2) {
            return $this->buildUri($this->currentPageNumber - 1);
        }

        return sprintf('%s:%s', $this->permalink, $this->permalinkQueryString);
    }

    /**
     * Get the "next" URI.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function getNextUri()
    {
        return $this->currentPageNumber < $this->totalPages
            ? $this->buildUri($this->currentPageNumber + 1)
            : '';
    }

    /**
     * Get the page URI.
     *
     * @since 3.0.0
     *
     * @param int $pageNumber
     *
     * @return string
     */
    protected function getPageUri($pageNumber)
    {
        if ($pageNumber > 1) {
            return $this->buildUri($pageNumber);
        }

        return sprintf('%s?%s', $this->permalink, $this->permalinkQueryString);
    }

    /**
     * Get the page class.
     *
     * @since 3.0.0
     *
     * @param int $pageNumber
     *
     * @return string
     */
    protected function getPageClass($pageNumber)
    {
        return $pageNumber == $this->currentPageNumber ? 'active' : '';
    }
}
