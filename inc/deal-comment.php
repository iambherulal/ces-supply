<?php

/* 
* Deal Apply Fuctionalty
*/


// Comment Form Disable default textarea

add_filter('comment_form_defaults', 'ces_remove_commect_text_area', 10, 1);
function ces_remove_commect_text_area($defaults)
{
    $button = '<input name="deals-apply-now" type="submit" id="submit" class="btn btn-primary" value="Apply Now">';
    $defaults['comment_field'] = '';
    $defaults['must_log_in'] = '';
    $defaults['logged_in_as'] = '';
    $defaults['title_reply'] = '';
    $defaults['title_reply_to'] = '';
    $defaults['id_form'] = 'dealApplyForm';
    $defaults['title_reply_before'] = '';
    $defaults['title_reply_after'] = '';
    $defaults['cancel_reply_link'] = '';

    $defaults['submit_button'] = $button;

    return $defaults;
}

add_action('comment_form_logged_in_after', 'deals_apply_form_extra_field');
add_action('comment_form_after_fields', 'deals_apply_form_extra_field');

function deals_apply_form_extra_field()
{ ?>
    <div class="form-group row">
        <div class="col-md-6">
            <label for="pickup_date">Date</label>
            <div class="input-group date" id="deals_pickup_date">
                <input type="text" name="pickup_date" class="form-control" required />
            </div>
        </div>
        <div class="col-md-6">
            <label for="pickup_phone">Phone</label>
            <input type="tel" id="pickup_phone" name="pickup_phone" class="form-control" required />

        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label for="productQty">Quantity</label>
            <input type="text" id="productQty" name="product_qty" class="form-control" required />

        </div>
        <div class="col-md-6">
            <label for="vendor_address">Pickup Address</label>
            <select id="vendor_address" class="form-control custom-select" name="vendor_address" required>
                <option value="" selected="" disabled="">Select address</option>
                <option value="existing">Existing Address</option>
                <option value="new">New Address</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <textarea placeholder="Enter New Address" type="textarea" id="vendorNewAddress" name="vendor_new_address" rows="2" class="form-control mt-3" style="display: none;"></textarea>
    </div>
    <div class="form-group">
        <label for="vendor_extra_note">Note:</label>
        <textarea id="vendor_extra_note" class="form-control" rows="2" name="vendor_extra_note" spellcheck="false"></textarea>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" id="emailNotification" name="emailAddress" class="form-check-input" />
        <label for="emailNotification" class="form-check-label">Do you want to receive notification on another email.</label>
    </div>
    <div class="form-group row" id="emailAddressContainer" style="display: none;">
        <input type="email" id="emailAddress" name="emailAddress" class="form-control" placeholder="Email Address" />
    </div>



<?php }


// Allow Duplicate Comment;

add_filter('duplicate_comment_id', '__return_false');


add_action('comment_post', 'ces_insert_form_save_data', 10, 1);
function ces_insert_form_save_data($comment_id)
{
    global $wpdb;
    if (isset($_POST['deals-apply-now'])) {

        $apply_now = array(
            'pickup_date'    => esc_attr($_POST['pickup_date']),
            'pickup_phone'    => esc_attr($_POST['pickup_phone']),
            'product_qty'    => esc_attr($_POST['product_qty']),
            'vendor_address'    => esc_attr($_POST['vendor_address']),
            'vendor_new_address'    => esc_attr($_POST['vendor_new_address']),
            'vendor_extra_note'    => esc_attr($_POST['vendor_extra_note']),
        );

        update_comment_meta($comment_id, 'vendor_apply_data', $apply_now);


        // Admin Email Notification

        if ($comment_approved == 0) {

            $comment = get_comment($comment_id);

            $post   = get_post($comment->comment_post_ID);

            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $post_title = $post->post_title;
            $admin_email = get_option('admin_email');

            // $deal_waiting = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0'");

            $deal_form_data = get_comment_meta($comment_id, 'vendor_apply_data', true);
            $vendor_detail = get_user_meta($comment->user_id, 'vendor_detail', true);

            if ($deal_form_data['vendor_address'] === 'existing') {
                $vendor_address = sprintf(__('%1$s City: %2$s State: %3$s ZIP: %4$s'), $vendor_detail['business_address'], $vendor_detail['city'], $vendor_detail['state'], $vendor_detail['zipcode']);
            } else {
                $vendor_address = $deal_form_data['vendor_new_address'];
            }

            $subject = "New Deal Submission on {$post_title} Qty {$deal_form_data['product_qty']}";
            $headers = array('Content-Type: text/html; charset=UTF-8');
            // $message = "A new Submission on the deal {$post_title} " . "\r\n\r\n";
            // $message .= sprintf(__('Name: %1$s'), $comment->comment_author) . "\r\n";
            // $message .= sprintf(__('Email: %1$s'), $comment->comment_author_email) . "\r\n";
            // $message .= sprintf(__('Phone: %1$s'), $deal_form_data['pickup_phone']) . "\r\n";
            // $message .= sprintf(__('Date: %1$s'), $deal_form_data['pickup_date']) . "\r\n";
            // $message .= sprintf(__('Quantity: %1$s'), $deal_form_data['product_qty']) . "\r\n";
            // $message .= sprintf(__('Address: %1$s'), $vendor_address) . "\r\n";
            // $message .= sprintf(__('Note: %1$s'), $deal_form_data['vendor_extra_note']) . "\r\n\r\n";


            $message = <<<EOD
            <p>Hello, CES Supply</p>
            <p>Please find below details of the latest deal submission.</p>
            <table style="border-collapse: collapse; width: auto;text-align: left;">
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Deal Name: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$post_title}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Deal Qty: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['product_qty']}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Pickup Date: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['pickup_date']}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Vendor Address: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$vendor_address}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Vendor Name: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$comment->comment_author}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Vendor Email: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$comment->comment_author_email}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Vendor Phone: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['pickup_phone']}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Extra Note: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['vendor_extra_note']}</td>
                </tr>
            </table>
            
            <p>Thanks</p>
            CES Supply
            EOD;

            wp_mail($admin_email, $subject, $message, $headers);

            // Deal Author Notification 

            $notificationEmail = esc_attr($_POST['emailAddress']);
            $author_email = $comment->comment_author_email;

            $author_name = $comment->comment_author;
            $notificationReceipt = array($author_email, $notificationEmail);
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: {$blogname} <{$admin_email}>");

            $message = <<<EOD
            <p>Hello, {$author_name}</p>
            <p>Please find below details of the latest deal submission.</p>
            <table style="border-collapse: collapse; width: auto;text-align: left;">
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Deal: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$post_title}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Qty: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['product_qty']}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Date: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['pickup_date']}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Address: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$vendor_address}</td>
                </tr>
                <tr>
                <th style="border: 1px solid #dddddd; padding: 5px;">Note: </th>
                <td style="border: 1px solid #dddddd; padding: 5px;">{$deal_form_data['vendor_extra_note']}</td>
                </tr>
            </table>
            
            <p>Thanks</p>
            CES Supply
            EOD;
            wp_mail($notificationReceipt, $subject, $message, $headers);
        }
    }
}


/* To include a legal message at the end of every comment notification */

function custom_notificaion($notify_message, $comment_id)
{
    $comment_obj = get_comment($comment_id); //Get comment object
    $comment_post = get_post($comment_obj->comment_post_ID); //Get post object

    //Check if it is your post type
    if (isset($comment_post->post_type) && $comment_post->post_type == 'deals') {
        return __('This is Custom text', 'ext-domain'); //Return the custom message here
    }

    return $notify_message; //Return default message for rest of the posts
}
add_filter('comment_notification_text', 'custom_notificaion', 10, 2);




add_action('set_comment_cookies', function ($comment, $user) {
    setcookie('ces_deals_approval', '1', 0, '/');
}, 10, 2);

add_action('init', function () {
    if (isset($_COOKIE['ces_deals_approval']) && $_COOKIE['ces_deals_approval'] === '1') {
        setcookie('ces_deals_approval', '0', 0, '/');
        add_action('comment_form_before', function () {
            echo "<div id='wait_approval' class='alert alert-success' role='alert'>Form Submitted Successfully</div>";
        });
    }
});

add_filter('comment_post_redirect', function ($location, $comment) {
    $location = get_permalink($comment->comment_post_ID) . '#wait_approval';
    return $location;
}, 10, 2);
