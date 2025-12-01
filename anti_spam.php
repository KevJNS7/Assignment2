<?php
/**
 * Filename: anti_spam.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Anti-spam protection system functions.
 * Date: 2025
 */


/**
 * Get user IP or ID
 */
function get_user_identifier() {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        return 'user_' . $_SESSION['user_id'];
    }
    
    // Get IP address
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return 'ip_' . $ip;
}

/**
 * Check if user is blocked
 */
function check_spam_block($identifier, $conn) {
    $identifier = mysqli_real_escape_string($conn, $identifier);
    
    // Check spam_blocks table
    $sql = "SELECT * FROM spam_blocks 
            WHERE user_identifier = '$identifier' 
            AND block_until > NOW()
            ORDER BY block_until DESC 
            LIMIT 1";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $minutes_left = ceil((strtotime($row['block_until']) - time()) / 60);
        
        return [
            'blocked' => true,
            'message' => "You have been temporarily blocked due to too many submissions. Please try again in {$minutes_left} minute(s)."
        ];
    }
    
    return ['blocked' => false];
}

/**
 * Record submission and check limit
 */
function record_submission($identifier, $form_type, $conn) {
    $identifier = mysqli_real_escape_string($conn, $identifier);
    $form_type = mysqli_real_escape_string($conn, $form_type);
    
    // Count recent submissions (10 mins)
    $sql = "SELECT COUNT(*) as submission_count 
            FROM submission_logs 
            WHERE user_identifier = '$identifier' 
            AND form_type = '$form_type'
            AND submitted_at > DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $submission_count = $row['submission_count'];
    
    // Block if limit reached
    if ($submission_count >= 4) {
        // Block for 10 minutes
        $block_sql = "INSERT INTO spam_blocks (user_identifier, reason, block_until) 
                      VALUES ('$identifier', 
                              'Exceeded rate limit for $form_type form', 
                              DATE_ADD(NOW(), INTERVAL 10 MINUTE))";
        mysqli_query($conn, $block_sql);
        
        return [
            'allowed' => false,
            'message' => "You have exceeded the submission limit (5 submissions per 10 minutes). You have been temporarily blocked."
        ];
    }
    
    // Log submission
    $log_sql = "INSERT INTO submission_logs (user_identifier, form_type) 
                VALUES ('$identifier', '$form_type')";
    mysqli_query($conn, $log_sql);
    
    $remaining = 5 - ($submission_count + 1);
    $message = '';
    
    if ($remaining == 2) {
        $message = "Warning: You have 2 submissions remaining in the next 10 minutes.";
    } elseif ($remaining == 1) {
        $message = "Warning: You have 1 submission remaining in the next 10 minutes.";
    } elseif ($remaining == 0) {
        $message = "This is your last allowed submission for the next 10 minutes.";
    }
    
    return [
        'allowed' => true,
        'message' => $message,
        'remaining' => $remaining
    ];
}

/**
 * Display block message and exit
 */
function display_block_message($message) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/style.css">
        <title>Access Blocked - Root Flower</title>
    </head>
    <body>
        <div class="process">
            <div class="processcontainer">
                <div class="processcard">
                    <h1>⚠️ Submission Blocked</h1>
                    <p><?php echo htmlspecialchars($message); ?></p>
                    <br>
                    <div class="button-membership-process">
                        <a href="index.php">Back to Website</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

/**
 * Clean up old records
 */
function cleanup_old_records($conn) {
    // Delete submission logs older than 1 hour
    $sql1 = "DELETE FROM submission_logs 
             WHERE submitted_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    mysqli_query($conn, $sql1);
    
    // Delete expired blocks
    $sql2 = "DELETE FROM spam_blocks 
             WHERE block_until < NOW()";
    mysqli_query($conn, $sql2);
}
?>
