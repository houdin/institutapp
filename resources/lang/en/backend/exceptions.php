<?php

return array (
  'backend' =>
  array (
    'access' =>
    array (
      'roles' =>
      array (
        'cant_delete_admin' => 'You can not delete the Administrator role.',
        'needs_permission' => 'You must select at least one permission for this role.',
        'create_error' => 'There was a problem creating this role. Please try again.',
        'update_error' => 'There was a problem updating this role. Please try again.',
        'already_exists' => 'That role already exists. Please choose a different name.',
        'delete_error' => 'There was a problem deleting this role. Please try again.',
        'has_users' => 'You can not delete a role with associated users.',
        'not_found' => 'That role does not exist.',
      ),
      'users' =>
      array (
        'already_confirmed' => 'This user is already confirmed.',
        'cant_delete_own_session' => 'You can not delete your own session.',
        'session_wrong_driver' => 'Your session driver must be set to database to use this feature.',
        'social_delete_error' => 'There was a problem removing the social account from the user.',
        'role_needed_create' => 'You must choose at lease one role.',
        'create_error' => 'There was a problem creating this user. Please try again.',
        'update_error' => 'There was a problem updating this user. Please try again.',
        'update_password_error' => 'There was a problem changing this users password. Please try again.',
        'cant_deactivate_self' => 'You can not do that to yourself.',
        'mark_error' => 'There was a problem updating this user. Please try again.',
        'cant_confirm' => 'There was a problem confirming the user account.',
        'not_confirmed' => 'This user is not confirmed.',
        'cant_unconfirm_admin' => 'You can not un-confirm the super administrator.',
        'cant_unconfirm_self' => 'You can not un-confirm yourself.',
        'delete_first' => 'This user must be deleted first before it can be destroyed permanently.',
        'delete_error' => 'There was a problem deleting this user. Please try again.',
        'cant_restore' => 'This user is not deleted so it can not be restored.',
        'restore_error' => 'There was a problem restoring this user. Please try again.',
        'email_error' => 'That email address belongs to a different user.',
        'not_found' => 'That user does not exist.',
        'cant_delete_admin' => 'You can not delete the super administrator.',
        'cant_delete_self' => 'You can not delete yourself.',
        'role_needed' => 'You must choose at least one role.',
      ),
    ),
  )
);
