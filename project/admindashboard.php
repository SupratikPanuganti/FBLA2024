<?php
include("header.php");
include_once 'dbconnection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SESSION['username']!=='admin')
header("Location: index.php");

// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

$sql = "SELECT * FROM partners order by id desc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$partners = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM students order by username desc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);
?>

    <h1>All Partners</h1>
    <a href="addpartner.php" id="addPartnerButton">+ Add Partner</a>
    <hr>
    <input type="text" id="searchInput" placeholder="Search...">
    <br>
    <table id="dataPartners">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Partner Name<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(1)">Description<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(2)">Type<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(3)">Resources Available<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(4)">Phone Number<span class="sort-arrow">&#x2195;</span></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            foreach ($partners as $partner) {
                echo '<tr>';
                echo '<td>' .  $partner['name'] . '</td>';
                echo '<td>' . $partner['description'] . '</td>';
                echo '<td>' . $partner['type'] . '</td>';
                echo '<td>' . $partner['resources_available'] . '</td>';
                echo '<td>' . $partner['phone_number'] . '</td>';
                echo '<td class="actions-column">' . 
                '<a href="addpartner.php?id=' . $partner['id'] . '"><i class="fas fa-pencil-alt edit-icon"></i></a>' .
                '<span class="icon-spacing"></span>' .
                '<i class="fas fa-trash-alt delete-icon" onclick="deletePartnerConfirmation(' . $partner['id'] . ')"></i>' .
                '</td>';
        echo '</tr>';
            }
            ?>
        </tbody>    
    </table>

    <br/>
    <h1>All Students</h1>
    <hr>
    <input type="text" id="searchInput" placeholder="Search...">
    <br>
    <table id="dataStudents">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Student Name<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(1)">Email<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(2)">Phn Num<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(3)">DOB<span class="sort-arrow">&#x2195;</span></th>
                <th onclick="sortTable(4)">Grade<span class="sort-arrow">&#x2195;</span></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            foreach ($students as $student) {
                echo '<tr>';
                echo '<td>' . $student['firstname'] .', '.$student['lastname']. '</td>';
                echo '<td>' . $student['email'] . '</td>';
                echo '<td>' . $student['phonenumber'] . '</td>';
                echo '<td>' . $student['dob'] . '</td>';
                echo '<td>' . $student['grade'] . '</td>';
        echo '</tr>';
            }
            ?>
        </tbody>    
    </table>

    <script>
        var sortDirection = {};
        function sortTable(columnIndex) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("dataPartners");
    rows = table.getElementsByTagName("tr");
    switching = true;

    if (!sortDirection[columnIndex]) {
        sortDirection[columnIndex] = 'asc';
    } else {
        sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
    }

    // Reset arrow indicators
    var arrowElements = document.querySelectorAll('.sort-arrow');
    arrowElements.forEach(function (arrowElement) {
        arrowElement.innerHTML = '&#x2195;';
    });

    // Find or create the arrow element within the th
    var th = table.querySelector("thead th:nth-child(" + (columnIndex + 1) + ")");
    var arrowElement = th.querySelector('.sort-arrow');
    if (!arrowElement) {
        arrowElement = document.createElement('span');
        arrowElement.className = 'sort-arrow';
        th.appendChild(arrowElement);
    }

    while (switching) {
        switching = false;

        for (i = 0; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];

            // Check if x and y are defined
            if (x && y) {
                var comparison = x.textContent.localeCompare(y.textContent);

                if ((sortDirection[columnIndex] === 'asc' && comparison > 0) ||
                    (sortDirection[columnIndex] === 'desc' && comparison < 0)) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
    var arrowElement = table.querySelector("thead th:nth-child(" + (columnIndex + 1) + ") .sort-arrow");
    arrowElement.innerHTML = sortDirection[columnIndex] === 'asc' ? '&#x2191;' : '&#x2193;';
}


var input = document.getElementById('searchInput');
input.addEventListener('input', function () {
    var filter = input.value.toUpperCase();
    var tableBody = document.getElementById('tableBody');
    var rows = tableBody.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var shouldDisplay = false;

        for (var j = 0; j < cells.length; j++) {
            var cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toUpperCase().indexOf(filter) > -1) {
                shouldDisplay = true;
                break;
            }
        }

        rows[i].style.display = shouldDisplay ? '' : 'none';
    }
});

  // Add this function
  function deletePartnerConfirmation(id) {
    var confirmation = confirm("Are you sure you want to delete this partner?");
    if (confirmation) {
      deletePartner(id);
    }
    else{
        location.reload(); 
    }
  }

  function deletePartner(id) {
    // Send an AJAX request to delete the record
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'deletepartner.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Reload the page or update the table after successful deletion
        location.reload(); // This will refresh the page
      }
    };
    xhr.send('id=' + id);
  }

  // Attach the click event to the delete icons
  var deleteIcons = document.querySelectorAll('.delete-icon');
  deleteIcons.forEach(function (icon) {
    icon.addEventListener('click', function () {
      var partnerId = this.getAttribute('data-id');
      deletePartnerConfirmation(partnerId);
    });
  });

</script>
<?php include("footer.html")?>