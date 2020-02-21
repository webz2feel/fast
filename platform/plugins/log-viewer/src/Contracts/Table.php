<?php

namespace Fast\LogViewer\Contracts;

interface Table
{
    /**
     * Get table header.
     *
     * @return array
     * @author ARCANEDEV
     */
    public function header();

    /**
     * Get table rows.
     *
     * @return array
     * @author ARCANEDEV
     */
    public function rows();

    /**
     * Get table footer.
     *
     * @return array
     * @author ARCANEDEV
     */
    public function footer();
}
