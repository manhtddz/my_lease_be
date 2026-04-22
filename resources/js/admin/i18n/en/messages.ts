export default {
    // add
    create_success : 'Registration completed.',
    create_failed : 'Registration failed.',

    // update
    update_success : 'Edited successfully.',
    update_failed : 'Update failed.',
    amount_dont_match : 'The amounts do not match.',

    // delete
    delete_success : 'Deleted successfully.',
    delete_failed : 'Deletion failed.',

    // change
    change_success : 'Changed successfully.',
    change_failed : 'Change failed.',

    // search
    no_result_found : 'No data found for the specified search criteria.',
    db_not_connect : 'Failed to connect to the database. An unexpected error has occurred, please contact the system administrator.',
    url_not_found : 'The specified page (URL) was not found.',
    not_permission : 'You do not have permission to access.',
    no_data : 'No data available.',
    record_does_not_exists : 'The record does not exist.',
    owner_does_not_exists : 'There is no owner information.',

    // download
    download_failed : 'Download failed.',
    no_file_download : 'No :type file available.',

    // mail subject
    mail_reset_password_title : 'Password Reset',
    mail_register_complete_title : 'Partner Drive Membership Registration Complete',

    // send mail
    send_success : 'Sent successfully.',
    send_failed : 'Failed to send.',
    reset_password_success : 'Password reset completed.',
    reset_password_fail : 'Failed to reset password.',
    send_reset_link_success : 'Password reset email sent. Please check :email.',

    // upload file
    file_does_not_exist : 'File does not exist.',
    file_upload_failed : 'Failed to upload file.',
    file_upload_blacklist : 'The uploaded file is on the blacklist.',

    // errors
    system_error : 'An unexpected error has occurred. Please contact the system administrator.',
    failed : 'Please try again.',

    // action
    page_action : {
        index : 'List',
        edit : 'Edit',
        show : 'Details',
        confirm : 'Confirm',
        create : 'Register',
        store : 'Store',
        update : 'Update',
        destroy : 'Delete',
    },

    // page title
    page_title : {
        errors : 'Error',
        admin : {
            login : 'Login',
            forgot_password : 'Forgot Password',
            reset_password : 'Reset Password',
            home : 'Home',
            users : 'User',
            expense_item : 'Expense Item',
        }
    },

    page_title_admin : 'Rental Management System',

    // subject mails
    subject_mails : {
        password : {
            forgot : 'Password reissue',
            reset_password : 'Password Reset',
        }
    },

    // messages
    token_expiration : 'Your session has expired, please try again.',
    curl_api_error : 'A curl error occurred while calling a remote API.',
    push_messages_error : 'An error occurred while sending a message to the device.',
    push_messages_success : 'The message was sent to the device successfully.',

    // API
    api_not_connect : 'Failed to connect to the destination server',

    email_exist : 'The email address has already been taken.',
    slug_exist : 'The slug has already been taken.',

    full_size_tel : 'Please enter the telephone number in half-width numbers.',
    zip_with_hyphen_invalid : 'The postal code (with hyphens) is invalid.',
    full_size_zip_with_hyphen : 'Please enter the postal code (with hyphens) in half-width numbers.',
    zip_invalid : 'The postal code is invalid.',
    full_size_zip : 'Please enter the postal code in half-width numbers.',
    csv_data_invalid : 'The data format is invalid.',
    csv_data_number_no_invalid : 'Line :no the data format is invalid.',

    // GI CSV
    gi_csv_deposit_date_no_invalid : 'Line :no The date data is incorrectly formatted.',
    gi_csv_view_id_no_invalid : 'Line :no The Cust ID data is incorrectly formatted.',
    gi_csv_amount_no_invalid : 'Line :no The amount data is incorrectly formatted.',

    // holiday check date
    holidays : {
        date_unique : 'The holidays have already been registered.',
    },
}
