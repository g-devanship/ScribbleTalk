<?php

require_once 'assets/php/functions.php';

// Clear temporary session data if needed
if (isset($_GET['newfp'])) {
    unset($_SESSION['auth_temp'], $_SESSION['forgot_email'], $_SESSION['forgot_code']);
}

// Fetch user and related data if authenticated
if (isset($_SESSION['Auth'])) {
    $user = getUser($_SESSION['userdata']['id']);
    $posts = filterPosts();
    $follow_suggestions = filterFollowSuggestion();
}

$pagecount = count($_GET);

// Manage pages based on user status and page requests
if (isset($_SESSION['Auth'])) {
    if ($user['ac_status'] == 1 && !$pagecount) {
        showPage('header', ['page_title' => 'Home']);
        showPage('navbar');
        showPage('wall');
    } elseif ($user['ac_status'] == 0 && !$pagecount) {
        showPage('header', ['page_title' => 'Verify Your Email']);
        showPage('verify_email');
    } elseif ($user['ac_status'] == 2 && !$pagecount) {
        showPage('header', ['page_title' => 'Blocked']);
        showPage('blocked');
    } elseif (isset($_GET['editprofile']) && $user['ac_status'] == 1) {
        showPage('header', ['page_title' => 'Edit Profile']);
        showPage('navbar');
        showPage('edit_profile');
    } elseif (isset($_GET['topt'])) {
        $usern = isset($_GET['u']) ? $_GET['u'] : $user['username'];
        
        showPage('header', ['page_title' => 'TopTalk']);
        showPage('navbar');
        showPage('top_t', ['username' => $usern]);
    } elseif (isset($_GET['u']) && $user['ac_status'] == 1) {
        $profile = getUserByUsername($_GET['u']);
        if (!$profile) {
            showPage('header', ['page_title' => 'User Not Found']);
            showPage('navbar');
            showPage('user_not_found');
        } else {
            $profile_post = getPostById($profile['id']);  
            $profile['followers'] = getFollowers($profile['id']);
            $profile['following'] = getFollowing($profile['id']);
            showPage('header', ['page_title' => $profile['first_name'] . ' ' . $profile['last_name']]);
            showPage('navbar');
            showPage('profile');
        }
    } else {
        // Default to home page if authenticated and no specific request
        showPage('header', ['page_title' => 'Home']);
        showPage('navbar');
        showPage('wall');
    }
} else {
    // Handle non-authenticated page requests
    if (isset($_GET['signup'])) {
        showPage('header', ['page_title' => 'Scribble-Talk - SignUp']);
        showPage('signup');
    } elseif (isset($_GET['login'])) {
        showPage('header', ['page_title' => 'Scribble-Talk - Login']);
        showPage('login');
    } elseif (isset($_GET['forgotpassword'])) {
        showPage('header', ['page_title' => 'Scribble-Talk - Forgot Password']);
        showPage('forgot_password');
    } else {
        // Default to login page for non-authenticated users
        showPage('header', ['page_title' => 'Scribble-Talk - Login']);
        showPage('login');
    }
}

showPage('footer');
unset($_SESSION['error'], $_SESSION['formdata']);
?>
