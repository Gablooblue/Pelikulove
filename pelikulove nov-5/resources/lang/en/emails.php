<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Emails Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various emails that
    | we need to display to the user. You are free to modify these
    | language lines according to your application's requirements.
    |
    */

    /*
     * Activate new user account email.
     *
     */

    'activationSubject'  => 'Activation required',
    'activationGreeting' => 'Welcome to Pelikulove!',
    'activationMessage'  => 'To fully access the site, please verify your email account.',
    'activationButton'   => 'Activate',
    'activationThanks'   => "Thank you for signing up. We're glad you have chosen to be part of our growing community and we hope you enjoy your stay.",

	'paymentSubject'  => 'Payment Received',
    'paymentGreeting' => 'Dear :username,',
    'paymentMessage1'  => 'Welcome to :course!',
    'paymentMessage2'  => 'This is to confirm that we have received your :payment payment in the amount of ₱:amount with transaction ID :txnid.',
    'paymentMessage3'  => 'Access your account now.',
    'paymentButton'   => 'Login',
    'paymentThanks'   => "Thank you for your payment. Enjoy.",

 	'earlySubject'  => '[Pelikulove] Early Access',
    'earlyGreeting' => 'Dear :username,',
    'earlyMessage1'  => 'Welcome to :course!',
    'earlyMessage2'  => 'This is your access to the course. We hope you can help us make our service better. Feel free to get in touch with us at pelikuloveofficial@gmail.com. Thank you and enjoy.',
    'earlyMessage3'  => 'Access your account now.',
    'earlyButton'   => 'Login',
    'earlyThanks'   => "TXTID :txnid.",

	
 	'compliSubject'  => '[Pelikulove] Complimentary Access',
    'compliGreeting' => 'Dear :username,',
    'compliMessage1'  => 'Welcome to :course!',
    'compliMessage2'  => 'This is your access to the course. We hope you can help us make our service better. Feel free to get in touch with us at pelikuloveofficial@gmail.com. Thank you and enjoy.',
    'compliMessage3'  => 'Access your account now.',
    'compliButton'   => 'Login',
    'compliThanks'   => "TXTID :txnid.",


	'welcomeSubject'  => '[Pelikulove] Welcome to Pelikulove!',
    'welcomeGreeting' => 'Dear :username,',
    'welcomeMessage1'  => 'This is to confirm that we have created an account for you in learn.pelikulove.com site.',
    'welcomeMessage2'  => 'Please reset your password to activate your account',
    'welcomeMessage3'  => 'This password reset link will expire in :count days.',
    'welcomeButton'   => 'Reset',
    'welcomeThanks'   => "Thank you.",

	'registerNotifySubject'  => '[Pelikulove] User Stats for :day',
    'registerNotifyGreeting' => 'Here are the User Stats for :day:',
    'registerNotifyMessage1'  => 'Total number of Registered users: :rcount',
    'registerNotifyMessage2'  => 'Total number of Enrolled users (including non-paying): :ecount',
    'registerNotifyMessage3'  => 'Total number of Paid users: :pcount',
    'registerNotifyButton'   => 'Login to Orders',
   

	
	'registerWeeklyNotifySubject'  => '[Pelikulove] Stats for :start to :end',
    'registerWeeklyNotifyGreeting' => 'Here are the User Stats:',
    'registerWeeklyNotifyMessage' => 'Lifetime User Stats',
    'registerWeeklyNotifyMessage1'  => 'Total number of Registered users: :rcount1',
    'registerWeeklyNotifyMessage2'  => 'Total number of Enrolled users (including non-paying): :ecount1',
    'registerWeeklyNotifyMessage3'  => 'Total number of Paid users: :pcount1',
    'registerWeeklyNotifyMessage4' => 'User Stats from :start to :end',
    'registerWeeklyNotifyMessage5'  => 'Total number of Registered users : :rcount2',
    'registerWeeklyNotifyMessage6'  => 'Total number of Enrolled users (including non-paying): :ecount2',
    'registerWeeklyNotifyMessage7'  => 'Total number of Paid users: :pcount2',
    'registerWeeklyNotifyButton'   => 'Login to Orders',

    
    'billingMonthlyNotifySubject'  => '[Orangefix] Invoice for the month of :month',
    'billingMonthlyNotifyGreeting' => 'Here are the Monthly User Stats:',
    'billingMonthlyNotifyMessage1'  => 'Total number of Registered users : :rcount',
    'billingMonthlyNotifyMessage2'  => 'Total number of Enrolled users (including non-paying): :ecount',
    'billingMonthlyNotifyMessage3'  => 'Total number of Paid users: :pcount',
    'billingMonthlyNotifyMessage4' => 'Monthly Sales:',
    'billingMonthlyNotifyMessage5' =>  'Total Sales: :total',
    'billingMonthlyNotifyMessage6'  => 'Total Net Amount: :netamount',
    'billingMonthlyNotifyMessage7'  => 'Total Net Service Fee: :servicefee',
    'billingMonthlyNotifyButton'   => 'View invoices',
	'billingMonthlyNotifyMessage8' => 'Make all payments to:',
	'billingMonthlyNotifyMessage9' =>	'Orangefix Corporation',
	'billingMonthlyNotifyMessage10'  => 'Unionbank CA #002440004127 or',
	'billingMonthlyNotifyMessage11'  => 'Chinabank CA #1148-00-00175-2',
	'billingMonthlyNotifyThanks'   => 'Thank you for your business!',

	'paymentNotifySubject'  => '[Pelikulove] New Enrollee :username',
    'paymentNotifyGreeting' => 'Dear Pelikulove Admin,',
    'paymentNotifyMessage1'  => 'Received payment from :email in the amount of ₱:amount with Transaction ID :txnid.',
    'paymentNotifyMessage2'  => 'Description: :course - :service',
    'paymentNotifyMessage3'  => 'Promo Code: :promo',
    'paymentNotifyMessage4'  => 'Payment: :payment (:refno)',
    'paymentNotifyThanks'   => "Thank you.",


	'instructionSubject'  => '[Pelikulove] Payment Pending',
    'instructionGreeting' => 'Dear :username,',
    'instructionMessage1'  => 'Your enrollment to :course is pending.',
    'instructionMessage2'  => 'Please deposit the amount of ₱:amount to the following BDO bank account:',
    'instructionMessage3'  => 'Acct Name: Pelikulove Corp.',
    'instructionMessage4' =>  'Checking Acct #:0046 9802 8617',
    'instructionThanks'   => "Please don't forget to email us your bank deposit slip. Thank you.",


    /*
     * Goobye email.
     *
     */
    'goodbyeSubject'  => 'Sorry to see you go...',
    'goodbyeGreeting' => 'Hello :username,',
    'goodbyeMessage'  => 'We are very sorry to see you go. We wanted to let you know that your account has been deleted. Thank for the time we shared. You have '.config('settings.restoreUserCutoff').' days to restore your account.',
    'goodbyeButton'   => 'Restore Account',
    'goodbyeThanks'   => 'We hope to see you again!',

];
