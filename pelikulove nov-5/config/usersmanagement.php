<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-users setting
    |--------------------------------------------------------------------------
    */

    // Users List Pagination
    'enablePagination'              => true,
    'paginateListSize'              => env('USER_LIST_PAGINATION_SIZE', 25),

    // Enable Search Users- Uses jQuery Ajax
    'enableSearchUsers'             => true,

    // Users List JS DataTables - not recommended use with pagination
    'enabledDatatablesJs'           => true,
    'datatablesJsStartCount'        => 25,
    'datatablesCssCDN'              => 'https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
    'datatablesJsCDN'               => 'https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js',
    'datatablesJsPresetCDN'         => 'https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js',

    // Bootstrap Tooltips
    'tooltipsEnabled'               => true,
    'enableBootstrapPopperJsCdn'    => true,
    'bootstrapPopperJsCdn'          => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',

];
