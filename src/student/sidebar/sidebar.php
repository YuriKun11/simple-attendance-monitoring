<!-- SIDEBAR -->
<section id="sidebar">
  <a href="#" class="brand">
  <i class='bx bxs-user-check'></i>
    <span class="text">Attendance Monitoring</span>
  </a>
  <ul class="side-menu top">
  <li id="menu-dashboard">
    <a href="dashboard.php">
      <i class='bx bxs-dashboard'></i>
      <span class="text">Dashboard</span>
    </a>
  </li>
</ul>

  <ul class="side-menu">
    <li>
      <a href="#">
        <i class='bx bxs-cog'></i>
        <span class="text">Settings</span>
      </a>
    </li>
    <li>
      <a href="../student_logout.php" class="logout">
        <i class='bx bxs-log-out-circle'></i>
        <span class="text">Logout</span>
      </a>
    </li>
  </ul>
</section>
<!-- SIDEBAR -->

<script>
  // Function to check the current URL and set the active class accordingly
  window.addEventListener('load', function() {
    const currentPage = window.location.pathname.split('/').pop();
    const menuItems = document.querySelectorAll('.side-menu li');
    menuItems.forEach(item => {
      const link = item.querySelector('a');
      if (link && link.getAttribute('href').includes(currentPage)) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  });
</script>
