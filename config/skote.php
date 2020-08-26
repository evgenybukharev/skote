<?php

return [
    'base' => [
        'default_date_format'     => 'D MMM YYYY',
        'default_datetime_format' => 'D MMM YYYY, HH:mm',
    ],
    'path' => [
        'logo-small' => '/assets/favicon-32x32.png',
        'logo-big' => '/assets/img/svg/logo.svg?ver=1.1',
        'favicon' => '/assets/favicon.ico',
        'favicon-apple' => '/assets/favicon-apple-touch-icon.png',
        'favicon-16' => '/assets/favicon-16x16.png',
        'favicon-32' => '/assets/favicon-32x32.png',
    ],
    'url' => [
        'login' => 'admin.login',
        'logout' => 'admin.logout',
        'dashboard' => 'admin.dashboard',
        'settings' => 'admin.settings',
    ],
    'crud' => [
        'operations' => [
            'list' => [
                // Define the size/looks of the content div for all CRUDs
                // To override per view use $this->crud->setListContentClass('class-string')
                'contentClass' => 'col-md-12',

                // enable the datatables-responsive plugin, which hides columns if they don't fit?
                // if not, a horizontal scrollbar will be shown instead
                'responsiveTable' => false,

                // stores pagination and filters in localStorage for two hours
                // whenever the user tries to see that page, backpack loads the previous pagination and filtration
                'persistentTable' => true,

                // show search bar in the top-right corner?
                'searchableTable' => true,

                // the time the table will be persisted in minutes
                // after this the table info is cleared from localStorage.
                // use false to never force localStorage clear. (default)
                // keep in mind: User can clear his localStorage whenever he wants.

                'persistentTableDuration' => false,

                // How many items should be shown by default by the Datatable?
                // This value can be overwritten on a specific CRUD by calling
                // $this->crud->setDefaultPageLength(50);
                'defaultPageLength' => 10,

                // A 1D array of options which will be used for both the displayed option and the value, or
                // A 2D array in which the first array is used to define the value options and the second array the displayed options
                // If a 2D array is used, strings in the right hand array will be automatically run through trans()
                'pageLengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'backpack::crud.all']],

                // How important is it for the action buttons to be visible?
                // - 0 - most important
                // - 1 - as important as bulk buttons
                // - 2-3 - more important than the rest of the columns
                // - 4 - less important than most columns
                'actionsColumnPriority' => 1,

                // Show a "Reset" button next to the List operation subheading
                // (Showing 1 to 25 of 9999 entries. Reset)
                // that allows the user to erase local storage for that datatable,
                // thus clearing any searching, filtering or pagination that has been
                // remembered and persisted using persistentTable
                'resetButton' => true,
            ],
        ],
    ],
];
