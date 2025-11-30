<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SVG Hover with Tooltip</title>
<style>
  /* Make SVG responsive */
  svg {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    background-color: #e0f2f1;
  }

  /* Path styling */
  .hover-group path {
    fill: #f4c0c7; /* Original color */
    stroke: #000;
    stroke-width: 0.4;
    cursor: pointer;
    transition: fill 0.2s;
  }

  /* Hover effect */
  .hover-group path:hover,
  .hover-group text:hover {
    fill: #ff6b81; /* Highlight color */
  }

  /* Text styling */
  .hover-group text {
    font-family: 'Tahoma';
    font-size: 12px;
    pointer-events: all;
    cursor: pointer;
    fill: #000;
  }

  /* Tooltip styling */
  #tooltip {
    position: absolute;
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    pointer-events: none; /* So it doesn’t block hover */
    display: none;
    white-space: nowrap;
    z-index: 100;
  }
</style>
</head>
<body>

<div>
  <svg xmlns="http://www.w3.org/2000/svg" width="800" height="533">
    <!-- Hoverable group -->
    <g class="hover-group" data-tooltip="Bangar">
      <path d="M 409.5893 102.508 L 410.1281 100.8918 L 411.1158 101.4904 L 412.1484 100.5326 L 413.0464 101.9094 L 414.0341 102.9271 L 414.6177 101.4904 L 418.5687 85.6867 L 418.0748 81.9752 L 415.5157 74.0734 L 412.5525 70.1225 L 410.4423 62.6397 L 407.524 59.8261 L 404.7404 58.3296 L 401.5079 58.8085 L 398.0957 55.6358 L 400.6997 56.3541 L 399.8467 54.9773 L 398.1855 54.6181 L 396.659 56.1147 L 395.1325 56.2344 L 394.1448 55.8154 L 395.0876 55.5161 L 394.4591 54.7977 L 391.6306 53.3011 L 388.3082 60.1255 L 388.2184 62.2805 L 391.7204 60.6044 L 389.3857 63.4778 L 390.5082 64.3158 L 390.2388 65.2736 L 388.2633 65.1539 L 388.4878 71.9782 L 387.2756 75.8693 L 388.7123 77.1264 L 388.7572 80.8977 L 390.7775 82.4541 L 391.2265 85.0881 L 392.8428 86.4051 L 392.9326 88.8594 L 393.8754 90.8349 L 396.0754 93.409 L 396.5692 92.9301 L 400.8344 96.1028 L 402.4956 99.2755 L 402.8548 103.8849 L 404.1119 105.3814 L 406.0425 104.9624 L 408.0179 102.3883 L 409.5893 102.508 Z"></path>
      <text transform="matrix(0.4549 0.8905 -0.8905 0.4549 392.1925 63.8215)">Sudipen</text>
    </g>
  </svg>
</div>

<!-- Tooltip -->
<div id="tooltip"></div>

<script>
  const tooltip = document.getElementById('tooltip');

  document.querySelectorAll('.hover-group').forEach(group => {
    group.addEventListener('mousemove', (e) => {
      const text = group.getAttribute('data-tooltip');
      tooltip.style.display = 'block';
      tooltip.innerText = text;
      tooltip.style.left = e.pageX + 10 + 'px';
      tooltip.style.top = e.pageY + 10 + 'px';
    });

    group.addEventListener('mouseleave', () => {
      tooltip.style.display = 'none';
    });
  });
</script>

</body>
</html>
