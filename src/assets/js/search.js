function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('attendanceTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) { 
        let cells = rows[i].getElementsByTagName('td');
        if (cells.length > 0) {
            let nameCell = cells[0].textContent || cells[0].innerText;
            if (filter === '' || nameCell.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = ""; 
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}
