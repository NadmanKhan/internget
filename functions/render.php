<?php

function render($view, $data = []): bool|string
{
    // get the view file path
    $path_to_view = $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $view . '.php';
    if (file_exists($path_to_view)) {
        extract($data);
        ob_start();
        // if a page layout is specified, use it
        if (isset($page_layout)) {
            require_once($path_to_view);
            $page_content = ob_get_clean();
            $path_to_layout = $_SERVER['DOCUMENT_ROOT'] . '/../views/layouts/' .
                $page_layout . '.php';
            require_once($path_to_layout);
        }
        // otherwise, just render the view
        else {
            require_once($view);
        }
        return ob_get_clean();
    }
    return false;
}