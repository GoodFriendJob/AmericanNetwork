<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
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
        <p id="profileHandle" class="profile-handle">@loading</p>

        <p id="profileSport" class="profile-role">Sport — Class of ???</p>

        <p class="profile-location">
            Hometown: <span id="profileLocation">Loading...</span>
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

            <label>First Name</label>
            <input type="text" id="profile-name" placeholder="First Name">

            <label>Handle</label>
            <input type="text" id="profile-handle" placeholder="@username">

            <label>Sport</label>
            <input type="text" id="profile-role" placeholder="Football, Basketball, etc.">

            <label>Bio</label>
            <textarea id="profile-bio" placeholder="Tell us about yourself"></textarea>

            <label>City</label>
            <input type="text" id="profile-city" placeholder="City">

            <label>State</label>
            <input type="text" id="profile-state" placeholder="State">

            <label>Zip</label>
            <input type="text" id="profile-zip" placeholder="Zip Code">

            <label>Achievements</label>
            <textarea id="profile-achievements" placeholder="List your achievements"></textarea>

            <button type="submit" class="save-profile-btn">Save Profile</button>
            <button type="button" class="cancel-profile-btn" onclick="setAppStage('main')">Cancel</button>

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

                <p class="post-caption">
                    Corner route, 4th & goal. Trusted the work, trusted the QB.
                    All American moments are built on days like this.
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
                            <p class="comment-text">
                                Route discipline, separation, and hands. This is what we look for on Saturdays.
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
<script src="/assets/js/main.js"></script>

</body>
</html>
