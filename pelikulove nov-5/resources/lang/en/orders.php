<?php

return [

    // Titles
    'showing-all-orders'     => 'Showing All Orders',
    'orders-menu-alt'        => 'Show Orders Management Menu',
    'create-new-order'       => 'Create New Order',
    'show-deleted-orders'    => 'Show Deleted Order',
    'editing-order'          => 'Editing Order',
    'showing-order'          => 'Showing Order',
    'showing-order-title'    => ':order\'s Information',

    // Flash Messages
    'createSuccess'   => 'Successfully created order! ',
    'updateSuccess'   => 'Successfully updated order! ',
    'createFail'   => 'Failed to create order! ',
    'updateFail'   => 'Failed to update order! ',
    'deleteSuccess'   => 'Successfully deleted order! ',
    'deleteSelfError' => 'You cannot delete yourself! ',

    // Show Order Tab
    'editOrder'               => 'Edit Order',
    'deleteOrder'             => 'Delete Order',
    'ordersBackBtn'           => 'Back to Orders',
    'ordersPanelTitle'        => 'Order Information',
    'labelOrder'         	  => 'Order :',
    'labelEmail'             => 'Email:',
    'labelFirstName'         => 'First Name:',
    'labelLastName'          => 'Last Name:',
    'labelStatus'            => 'Status:',
    'labelCourse'		      => 'Course',
    'labelService'      	 => 'Service:',
    'labelAmount'      	 	 => 'Amount:',
    'labelPayment'      	 => 'Payment:',
    'labelTxnId'      		 => 'Transaction ID:',
    'labelRefNo'      		 => 'Ref No:',
    'labelCreatedAt'         => 'Created At:',
    'labelUpdatedAt'         => 'Updated At:',
   

    'successRestore'    => 'Order successfully restored.',
    'successDestroy'    => 'Order record successfully destroyed.',
    'errorOrderNotFound' => 'Order not found.',

    'labelOrderLevel'  => 'Level',
    'labelOrderLevels' => 'Levels',

    'orders-table' => [
        'caption'   => '{1} :orderscount Order(s) Total|[2,*] :orderscount Total Orders',
        'id'        => 'ID',
        'transaction_id'      => 'Txn ID',
        'email'     => 'Email',
         'lname'     => 'Last Name',
         'fname'     => 'First Name',
        'service'     => 'Service',
        'ref_no'     => 'Ref No',
        'status'      => 'Status',
        'amount'      => 'Amount',
        'course'      => 'Course',
        'payment'      => 'Payment',
        'code'      => 'Code',
        'created'   => 'Created',
        'updated'   => 'Updated',
        'actions'   => 'Actions',
        'updated'   => 'Updated',
    ],

    'buttons' => [
        'create-new'    => 'New Order',
        'delete'        => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs hidden-sm">Delete</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'show'          => '<i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'edit'          => '<i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'back-to-orders' => '<span class="hidden-sm hidden-xs">Back to </span><span class="hidden-xs">Orders</span>',
        'back-to-order'  => 'Back  <span class="hidden-xs">to Order</span>',
        'delete-order'   => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs">Delete</span><span class="hidden-xs"> Order</span>',
        'edit-order'     => '<i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> <span class="hidden-xs">Edit</span><span class="hidden-xs"> Order</span>',
    ],

    'tooltips' => [
        'delete'        => 'Delete',
        'show'          => 'Show',
        'edit'          => 'Edit',
        'create-new'    => 'Create New Order',
        'back-orders'    => 'Back to orders',
        'email-order'    => 'Email :order',
        'submit-search' => 'Submit Orders Search',
        'clear-search'  => 'Clear Search Results',
    ],

    'messages' => [
       'order-creation-success'  => 'Successfully created order!',
        'update-order-success'    => 'Successfully updated order!',
        'delete-success'         => 'Successfully deleted the order!',
        'cannot-delete-yourself' => 'You cannot delete yourself!',
    ],

    'show-order' => [
        'id'                => 'Order ID',
        'name'              => 'Ordername',
        'email'             => '<span class="hidden-xs">Order </span>Email',
        'role'              => 'Order Role',
        'created'           => 'Created <span class="hidden-xs">at</span>',
        'updated'           => 'Updated <span class="hidden-xs">at</span>',
        'labelRole'         => 'Order Role',
        'labelAccessLevel'  => '<span class="hidden-xs">Order</span> Access Level|<span class="hidden-xs">Order</span> Access Levels',
    ],

    'search'  => [
        'title'             => 'Showing Search Results',
        'found-footer'      => ' Record(s) found',
        'no-results'        => 'No Results',
        'search-orders-ph'   => 'Search Orders',
    ],

    'modals' => [
        'delete_order_message' => 'Are you sure you want to delete :order?',
    ],
];
