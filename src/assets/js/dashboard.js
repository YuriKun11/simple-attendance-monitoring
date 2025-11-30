const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const sidebarToggle = document.getElementById("sidebarToggle");

function toggleSidebar() {
    sidebar.classList.toggle("sidebar-hidden");
    overlay.classList.toggle("hidden");
}

sidebarToggle.addEventListener("click", toggleSidebar);
overlay.addEventListener("click", toggleSidebar);