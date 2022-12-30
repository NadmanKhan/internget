<?php

function render(string $view, array $options = []): bool|string
{
    // separate the options into page and data
    $page = $options['page'] ?? [];
    $data = $options['data'] ?? [];

    // get the view file path
    $path_to_view = getenv('APP_VIEWS_DIR') . '/' . $view . '.php';

    // if the specified view file does not exist, die with an error message
    if (!file_exists($path_to_view)) {
        die('View not found: ' . $path_to_view);
    }

    // view file exists, so render its content

    // extract data into variables
    extract($data);

    // start output buffering
    ob_start();

    // if a page layout is specified, use it
    if (isset($page['layout'])) {

        require_once($path_to_view);
        $page['content'] = ob_get_clean();

        $path_to_layout = getenv('APP_VIEW_LAYOUTS_DIR') . '/' .
            $page['layout'] . '.php';

        // if the specified layout file does not exist, die with an error message
        if (!file_exists($path_to_layout)) {
            die('Layout not found: ' . $path_to_layout);
        }

        require_once($path_to_layout);
    }
    // otherwise, just render the view
    else {
        require_once($view);
    }

    // return the render content from the buffer
    return ob_get_clean();
}

function respond_error_page($error_code, $error_message): bool|string
{
    // set the response status code
    http_response_code($error_code);
    http_build_query(['error' => $error_message]);

    // render the error page
    return render('error-view', [
        'page' => [
            'layout' => 'default',
            'title' => 'Error ' . $error_code,
            'description' => 'Error'
        ],
        'data' => [
            'error_code' => $error_code,
            'error_message' => $error_message
        ],
    ]);
}
