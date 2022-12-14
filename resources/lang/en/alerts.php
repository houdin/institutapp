<?php

return array(
    'backend' =>
    array(
        'general' =>
        array(
            'created' => 'Created successfully.',
            'error' => 'Something went wrong. Try Again',
            'updated' => 'Updated successfully.',
            'deleted' => 'Deleted successfully.',
            'restored' => 'Restored successfully.',
            'cancelled' => 'Update Cancelled.',
            'unverified' => 'Unverified Update files.',
            'backup_warning' => 'Please fill necessary details for backup',
            'delete_warning' => 'You can not delete formation. Students are already enrolled. Unpublish the formation instead',
            'delete_warning_bundle' => 'You can not delete Bundle. Students are already enrolled. Unpublish the Bundle instead',
        ),
        'roles' =>
        array(
            'created' => 'The role was successfully created.',
            'updated' => 'The role was successfully updated.',
            'deleted' => 'The role was successfully deleted.',
        ),
        'users' =>
        array(
            'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
            'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.',
            'confirmed' => 'The user was successfully confirmed.',
            'unconfirmed' => 'The user was successfully un-confirmed',
            'created' => 'The user was successfully created.',
            'updated' => 'The user was successfully updated.',
            'deleted' => 'The user was successfully deleted.',
            'updated_password' => 'The user\'s password was successfully updated.',
            'session_cleared' => 'The user\'s session was successfully cleared.',
            'social_deleted' => 'Social Account Successfully Removed',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored' => 'The user was successfully restored.',
        ),
    ),
    'frontend' =>
    array(
        'contact' =>
        array(
            'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
        ),
        'formation' =>
        array(
            'completed' => 'Congratulations! You\'ve successfully completed formation. Checkout your certificate in dashboard',
        ),
        'duplicate_formation' => 'is already formation purchased.',
        'duplicate_bundle' => 'is already bundle purchased.',
        'duplicate_tutorial' => 'is already tutorial purchased.',
        'duplicate_premium' => 'is already premium purchased.',
    ),
);
