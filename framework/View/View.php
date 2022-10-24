<?php

namespace MfaFast\View;

class View
{
    const TEMPLATE_PREFIX = '.mfa.php';

    /**
     * @param $view
     * @param $params
     * @return string all view content with main layout
     */
    public static function make($view, $params = [])
    {
        //to get base content of master main page
        $baseContent = self::getBaseViewContent();
        //to get view content
        $viewContent = self::getViewContent($view, $params);
        return (str_replace('{{content}}', $viewContent, $baseContent));
    }

    /**
     * @return string view of main layout
     */
    protected static function getBaseViewContent()
    {
        ob_start();
        include view_path()."layouts/main".self::TEMPLATE_PREFIX;
        return ob_get_clean();
    }

    /**
     * @param $view
     * @param $params
     * @return false|string get view content after processing path with $params
     */
    protected static function getViewContent($view, $params = [])
    {
        $path = view_path();

        if (str_contains($view, '.')) {
            $views = explode('.', $view);
            foreach ($views as $view) {
                if (is_dir($path.$view)) {
                    $path = $path.$view.DIRECTORY_SEPARATOR;
                }
            }
            $view = $path.end($views).self::TEMPLATE_PREFIX;
        } else {
            $view = $path.$view.self::TEMPLATE_PREFIX;
        }

        if(count($params)){
            extract($params);
        }
        ob_start();
        include $view;
        return ob_get_clean();
    }
}
