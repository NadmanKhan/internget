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
            if (file_exists($path_to_layout)) {
                require_once($path_to_layout);
            } else {
                die('Layout not found: ' . $path_to_layout);
            }
        }
        // otherwise, just render the view
        else {
            require_once($view);
        }
        return ob_get_clean();
    } else {
        die('View not found: ' . $path_to_view);
    }
}

function render_error_page($error_code, $error_message): bool|string
{
    // set the response status code
    http_response_code($error_code);
    http_build_query(['error' => $error_message]);

    // render the error page
    return render('error-view', [
        'page_layout' => 'default',
        'page_title' => 'Error ' . $error_code,
        'page_description' => 'Error',

        'error_code' => $error_code,
        'error_message' => $error_message
    ]);
}
