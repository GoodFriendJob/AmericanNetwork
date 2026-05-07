<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$__app_base = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
if ($__app_base === "." || $__app_base === "/") {
    $__app_base = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All American Network</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- ================= TOP BAR ================= -->
<header class="topbar">

    <div class="topbar-left">
        <img src="assets/icons/aaa_logo_dark.png" alt="AAA" class="mini-logo">
    </div>

    <div class="topbar-center">
        <div class="topbar-pill-buttons">
            <button class="pill-btn">All American Network</button>
            <button class="pill-btn">All American Sports</button>
        </div>

        <div class="topbar-slogan-row">
            <span class="slogan">Be best of the best in every category</span>
        </div>

        <div class="topbar-actions">
            <button class="action-btn small">Daily Goal</button>
            <button class="action-btn">New Highlight Reel of the Day</button>
        </div>
    </div>

    <div class="topbar-right">
        <img src="assets/icons/aaa_logo_dark.png" alt="AAA logo" class="main-logo">
    </div>

</header>

<!-- ================= MAIN LAYOUT ================= -->
<div class="app-shell" data-view="main">
    <div class="layout">

    <!-- ========== LEFT SIDEBAR: PROFILE ========== -->
  <!-- ========== LEFT SIDEBAR: PROFILE ========== -->
<aside class="sidebar-left">
    <div class="profile-card">

        <div class="profile-photo-wrapper">
            <div class="profile-photo-inner">
                <img id="profilePic" src="assets/img/charles.jpg" class="profile-photo">
            </div>
        </div>

        <h2 id="profileName" class="profile-name">Loading...</h2>
        <a id="profileHandle" class="profile-handle" href="#">@loading</a>

        <p id="profileSport" class="profile-role">Sport — Position not set</p>

        <p class="profile-location">
            From: <span id="profileLocation">Loading...</span>
        </p>

        <div class="profile-stats">
            <div class="stat-card">
                <span id="statHighlights" class="stat-value">0</span>
                <span class="stat-label">Highlights</span>
            </div>
            <div class="stat-card">
                <span id="statScouts" class="stat-value">0</span>
                <span class="stat-label">Scouts Saved</span>
            </div>
            <div class="stat-card">
                <span id="statRating" class="stat-value">0.0</span>
                <span class="stat-label">Rating</span>
            </div>
        </div>

        <p id="profileBio" class="profile-description">
            Loading bio...
        </p>

        <p id="profileGoals" class="profile-goals" hidden></p>

        <div class="achievements">
            <h4>Achievements</h4>
            <p>Likes: <span id="badgeLikes">0</span></p>
        </div>

        <button id="btn-edit-profile" class="edit-profile-btn">Edit Profile</button>

    </div>
</aside>
<!-- ========== PROFILE EDITOR (HIDDEN BY DEFAULT) ========== -->
<div class="profile-shell" data-view="profile" style="display:none;">

    <div class="profile-edit-card">

        <h2>Edit Profile</h2>

        <form id="profile-form">

            <p id="profile-form-error" class="profile-form-error" style="display:none;"></p>

            <div class="profile-row">
                <div>
                    <label for="profile-first-name">First name</label>
                    <input type="text" id="profile-first-name" name="first_name" placeholder="First name" required>
                </div>
                <div>
                    <label for="profile-last-name">Last name</label>
                    <input type="text" id="profile-last-name" name="last_name" placeholder="Last name">
                </div>
            </div>

            <label for="profile-username">Username</label>
            <input type="text" id="profile-username" name="username" placeholder="username (appears as @username)" required autocomplete="username">

            <label for="profile-sport">Sport</label>
            <input type="text" id="profile-sport" name="sport" placeholder="Football, basketball, etc.">

            <label for="profile-position">Position</label>
            <input type="text" id="profile-position" name="position" placeholder="e.g. WR, Point guard">

            <div class="profile-row">
                <div>
                    <label for="profile-city">City</label>
                    <input type="text" id="profile-city" name="city" placeholder="City">
                </div>
                <div>
                    <label for="profile-state">State</label>
                    <input type="text" id="profile-state" name="state" placeholder="State">
                </div>
            </div>

            <label for="profile-bio">Bio</label>
            <textarea id="profile-bio" name="bio" placeholder="Tell us about yourself"></textarea>

            <label for="profile-rating">Rating (0–10)</label>
            <input type="number" id="profile-rating" name="rating" min="0" max="10" step="0.1" placeholder="0.0">

            <label for="profile-goals-input">Goals</label>
            <textarea id="profile-goals-input" name="goals" placeholder="Your athletic or season goals"></textarea>

            <div class="profile-form-actions">
                <button type="submit" class="save-profile-btn">Save profile</button>
                <button type="button" class="cancel-profile-btn" onclick="setAppStage('main')">Cancel</button>
            </div>

        </form>

    </div>

</div>


    <!-- ========== CENTER FEED ========== -->
    <main class="center-feed">

        <!-- Sports Tabs -->
        <div class="sports-tabs">
            <button class="tab active">All Sports</button>
            <button class="tab">Football</button>
            <button class="tab">Basketball</button>
            <button class="tab">Baseball</button>
            <button class="tab">Soccer</button>
            <button class="tab">Hockey</button>
            <button class="tab">Tennis</button>
            <button class="tab">Golf</button>
            <button class="tab">Track & Field</button>
            <button class="tab">Wrestling</button>
            <button class="tab">Volleyball</button>
        </div>

        <!-- Stories / Feed toggle -->
        <div class="feed-toggle">
            <button class="toggle-btn active">Feed</button>
            <button class="toggle-btn active">Stories</button>
        </div>

        <!-- Stories area (hidden by default, we can wire later with JS) -->
        <section class="stories-panel">
            <p>Stories from your network will show here (videos, photos, reels).</p>
        </section>

        <!-- Posts feed -->
        <section class="posts-panel">

            <article class="post-card">
                <header class="post-header">
                    <div class="post-user">
                        <div class="avatar">JW</div>
                        <div>
                            <h3 class="post-author">Jordan Walker</h3>
                            <p class="post-meta">Varsity • 4.8 avg • 2h ago</p>
                        </div>
                    </div>
                    <span class="post-tag">Friday Night Lights</span>
                </header>

                <p class="post-caption js-link-mentions">
                    Corner route, 4th & goal. Trusted the work, trusted the QB.
                    Shoutout to @charles_test for the scout notes. All American moments are built on days like this.
                </p>

                <div class="post-media-wrapper">
                    <img src="https://images.unsplash.com/photo-1518604666860-9ed391f76460?auto=format&fit=crop&w=1400&q=80"
                         class="post-media" alt="Highlight">
                </div>

                <div class="post-rating-row">
                    <span class="rating-label">Community Rating:</span>
                    <span class="rating-stars">★★★★☆</span>
                </div>

                <div class="post-actions">
                    <button class="post-btn active">Comment</button>
                    <button class="post-btn active">Share</button>
                    <button class="post-btn active">Save</button>
                    <button class="post-btn active">Message</button>
                </div>

                <div class="post-comments">
                    <div class="comment-row">
                        <div class="avatar-small">SC</div>
                        <div>
                            <p class="comment-author">Scout Central</p>
                            <p class="comment-text js-link-mentions">
                                Route discipline, separation, and hands. Ask @fletch if you want a second look.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

        </section>

    </main>

    <!-- ========== RIGHT SIDEBAR: NETWORK ========== -->
    <aside class="sidebar-right">
        <h3 class="sidebar-title">Your Network</h3>
        <p class="sidebar-subtitle">Circle of friends across sports, video creation, business, and life.</p>

        <ul class="friends-list">
            <li class="friend-row">
                <div class="avatar">QB</div>
                <div>
                    <p class="friend-name">Miles Carter</p>
                    <p class="friend-status online">Online • Game ready</p>
                </div>
            </li>
            <li class="friend-row">
                <div class="avatar">RB</div>
                <div>
                    <p class="friend-name">Tariq Jones</p>
                    <p class="friend-status grinding">Grinding it out</p>
                </div>
            </li>
            <li class="friend-row">
                <div class="avatar">DB</div>
                <div>
                    <p class="friend-name">Alex Rivera</p>
                    <p class="friend-status film">Film study mode</p>
                </div>
            </li>
        </ul>

        <div class="add-friend-card">
            <h4>Add to your circle</h4>
            <input type="text" placeholder="Search or add by name">
            <input type="text" placeholder="Role / Sport / Trade">
            <button class="add-friend-btn">Add / Look Up Friend</button>
        </div>
    </aside>

</div> <!-- end layout -->
</div>  <!-- end app-shell -->
<script>window.__APP_BASE__ = <?= json_encode($__app_base, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<script src="assets/js/main.js"></script>

</body>
</html>
