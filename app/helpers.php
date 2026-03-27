<?php

const NO_SLUG_ROUTE_SUFFIX = ".default";

if (!function_exists('company_route')) {
    function company_route($name, $params = []): string
    {
        $params['companySlug'] = $params['companySlug'] ?? request()->route('companySlug');

        if (!$params['companySlug']) {
            $name = $name . NO_SLUG_ROUTE_SUFFIX;
        }
        return route($name, $params);
    }
}
