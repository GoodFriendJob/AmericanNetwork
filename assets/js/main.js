const appShell = document.querySelector('.app-shell[data-view="main"]');
const profileShell = document.querySelector('.profile-shell[data-view="profile"]');

function setAppStage(stage) {
  if (appShell) appShell.style.display = stage === "main" ? "block" : "none";
  if (profileShell) profileShell.style.display = stage === "profile" ? "block" : "none";
}

const params = new URLSearchParams(window.location.search);
setAppStage(params.get("stage") === "profile" ? "profile" : "main");

function setView(view) {
  document.querySelectorAll(".main-nav .nav-link[data-view]").forEach((btn) => {
    btn.classList.toggle("is-active", btn.dataset.view === view);
  });

  document.querySelectorAll("[data-view]").forEach((el) => {
    if (el === appShell || el === profileShell) return;
    const elView = el.getAttribute("data-view");
    if (!elView) return;
    el.style.display = elView === view ? "" : (view === "general" && elView === "general" ? "" : "none");
  });
}

document.querySelectorAll(".main-nav .nav-link[data-view]").forEach((btn) => {
  btn.addEventListener("click", () => {
    const view = btn.dataset.view || "general";
    setAppStage("main");
    setView(view);
  });
});
setView("general");

const profileForm = document.getElementById("profile-form");
if (profileForm) {
  profileForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = document.getElementById("profile-name").value.trim();
    const handle = document.getElementById("profile-handle").value.trim();
    const role = document.getElementById("profile-role").value;
    const bio = document.getElementById("profile-bio").value.trim();
    const city = document.getElementById("profile-city").value.trim();
    const state = document.getElementById("profile-state").value.trim();
    const zip = document.getElementById("profile-zip").value.trim();
    const achievements = document.getElementById("profile-achievements").value.trim();
    if (!name || !handle || !role || !bio) return;

    const profileNameEl = document.querySelector(".profile-name");
    const profileHandleEl = document.querySelector(".profile-handle");
    const profileRoleEl = document.querySelector(".profile-role");
    const profileBioEl = document.querySelector(".profile-bio");
    const profileLocationEl = document.getElementById("profile-location-display");
    const profileAchievementsEl = document.getElementById("profile-achievements-display");

    if (profileNameEl) profileNameEl.textContent = name;
    if (profileHandleEl) profileHandleEl.textContent = handle;
    if (profileBioEl) profileBioEl.textContent = bio;

    if (profileRoleEl) {
      const laneMap = {
        sports: "All American in Sports",
        video: "All American Video Maker",
        dating: "All American Dating",
        truth: "All American Truth Teller",
        business: "All American in Business",
      };
      profileRoleEl.textContent = laneMap[role] || "All American";
    }

    if (profileLocationEl) {
      const parts = [];
      if (city) parts.push(city);
      if (state) parts.push(state);
      profileLocationEl.textContent = zip ? `${parts.join(", ")} ${zip}` : parts.join(", ") || "Hometown not set yet";
    }

    if (profileAchievementsEl) {
      profileAchievementsEl.innerHTML = achievements
        ? `<h3 class="profile-achievements-title">Achievements</h3><p class="profile-achievements-list">${achievements}</p>`
        : `<h3 class="profile-achievements-title">Achievements</h3><p class="profile-achievements-empty">No achievements added yet.</p>`;
    }

    setAppStage("main");
  });
}

const editProfileBtn = document.getElementById("btn-edit-profile");
if (editProfileBtn) editProfileBtn.addEventListener("click", () => setAppStage("profile"));

const avatarInput = document.getElementById("profile-avatar-input");
const avatarDisplay = document.getElementById("profile-avatar");
if (avatarInput && avatarDisplay) {
  avatarInput.addEventListener("change", (e) => {
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
      avatarDisplay.style.backgroundImage = `url(${ev.target.result})`;
      avatarDisplay.textContent = "";
      avatarDisplay.classList.add("has-image");
    };
    reader.readAsDataURL(file);
  });
}

const generalTabs = document.querySelectorAll(".general-tab");
generalTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    generalTabs.forEach((t) => t.classList.remove("is-active"));
    tab.classList.add("is-active");
  });
});

const sportsTabs = document.querySelectorAll(".sports-tab");
const sportsSubtabs = document.querySelectorAll(".sports-subtab");
const horseSubcategoriesContainer = document.querySelector(".sports-subcategories");

function filterSportsPosts(sport) {
  document.querySelectorAll(".post[data-sport]").forEach((post) => {
    const postSport = post.getAttribute("data-sport");
    post.style.display = sport === "all" || sport === postSport ? "" : "none";
  });
  if (horseSubcategoriesContainer) {
    horseSubcategoriesContainer.style.display = sport === "horse-racing" ? "flex" : "none";
  }
}

sportsTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    sportsTabs.forEach((t) => t.classList.remove("is-active"));
    tab.classList.add("is-active");
    filterSportsPosts(tab.dataset.sport || "all");
  });
});

sportsSubtabs.forEach((subtab) => {
  subtab.addEventListener("click", () => {
    sportsSubtabs.forEach((s) => s.classList.remove("is-active"));
    subtab.classList.add("is-active");
  });
});
filterSportsPosts("all");

const postMediaInput = document.getElementById("post-media");
const fileLabel = document.getElementById("file-label");
const mediaPreview = document.getElementById("media-preview");

if (postMediaInput && fileLabel && mediaPreview) {
  postMediaInput.addEventListener("change", (e) => {
    const file = e.target.files && e.target.files[0];
    if (!file) {
      fileLabel.textContent = "Upload video, photos, or moments";
      mediaPreview.innerHTML = "";
      return;
    }
    fileLabel.textContent = file.name;
    mediaPreview.innerHTML = "";
    const url = URL.createObjectURL(file);
    let el = null;
    if (file.type.startsWith("image/")) {
      el = document.createElement("img");
      el.src = url;
      el.alt = "Uploaded preview";
    } else if (file.type.startsWith("video/")) {
      el = document.createElement("video");
      el.src = url;
      el.controls = true;
    }
    if (el) {
      el.classList.add("media-preview-item");
      mediaPreview.appendChild(el);
    }
  });
}

const addFriendForm = document.getElementById("add-friend-form");
const friendsList = document.getElementById("friends-list");
if (addFriendForm && friendsList) {
  addFriendForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const nameInput = document.getElementById("friend-name");
    const roleInput = document.getElementById("friend-role");
    const name = nameInput.value.trim();
    const role = roleInput.value.trim();
    if (!name) return;
    const li = document.createElement("li");
    li.className = "friend";
    li.innerHTML = `<button class="friend-row" type="button"><div class="avatar">${name.charAt(0).toUpperCase()}</div><div class="friend-meta"><p class="friend-name">${name}</p><p class="friend-role">${role || ""}</p></div><span class="friend-status">New</span></button>`;
    friendsList.appendChild(li);
    nameInput.value = "";
    roleInput.value = "";
  });
}

document.querySelectorAll(".post-rating").forEach((ratingBlock) => {
  const stars = ratingBlock.querySelectorAll(".rating-star");
  stars.forEach((star) => {
    star.addEventListener("click", () => {
      const value = Number(star.dataset.value || "0");
      stars.forEach((s) => s.classList.toggle("is-active", Number(s.dataset.value || "0") <= value));
    });
  });
});

document.querySelectorAll(".comment-form").forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const input = form.querySelector('input[type="text"]');
    if (!input) return;
    const text = input.value.trim();
    if (!text) return;
    const commentsContainer = form.previousElementSibling;
    if (!commentsContainer || !commentsContainer.classList.contains("comments")) return;
    const comment = document.createElement("div");
    comment.className = "comment";
    comment.innerHTML = `<div class="avatar avatar-small">You</div><div><p class="comment-author">You</p><p class="comment-body">${text}</p></div>`;
    commentsContainer.appendChild(comment);
    input.value = "";
  });
});

function addRevealAttributes() {
  document.querySelectorAll(".main-nav, .sidebar, .card, .post, .friend").forEach((el, idx) => {
    if (!el.hasAttribute("data-reveal")) {
      el.setAttribute("data-reveal", "");
      el.style.transitionDelay = `${Math.min(idx * 40, 280)}ms`;
    }
  });
}

function setupRevealObserver() {
  addRevealAttributes();
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add("in-view");
      });
    },
    { threshold: 0.12 }
  );

  document.querySelectorAll("[data-reveal]").forEach((el) => observer.observe(el));
}

setupRevealObserver();
