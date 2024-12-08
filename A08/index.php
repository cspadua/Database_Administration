<?php
include("connect.php");


$departureCode = $_GET['departureCode'] ?? '';
$arrivalCode = $_GET['arrivalCode'] ?? '';
$airline = $_GET['airline'] ?? '';
$sortBy = $_GET['sortBy'] ?? '';
$sortOrder = $_GET['sortOrder'] ?? 'ASC';


$flightQuery = "SELECT * FROM flightLogs";

$filters = [];
if (!empty($departureCode)) {
  $filters[] = "departureAirportCode = '$departureCode'";
}
if (!empty($arrivalCode)) {
  $filters[] = "arrivalAirportCode = '$arrivalCode'";
}
if (!empty($airline)) {
  $filters[] = "airlineName = '$airline'";
}

if (!empty($filters)) {
  $flightQuery .= " WHERE " . implode(" AND ", $filters);
}

if (!empty($sortBy)) {
  $flightQuery .= " ORDER BY $sortBy $sortOrder";
}


$flightResults = executeQuery($flightQuery);
$departureOptions = executeQuery("SELECT DISTINCT departureAirportCode FROM flightLogs");
$arrivalOptions = executeQuery("SELECT DISTINCT arrivalAirportCode FROM flightLogs");
$airlineOptions = executeQuery("SELECT DISTINCT airlineName FROM flightLogs");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PUP Airport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="images/logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg shadow">
    <div class="container d-flex justify-content-center align-items-center">
      <a class="navbar-brand">
        <img src="images/logo.png" width="80" height="auto">
      </a>
    </div>
  </nav>

  <div class="container">
    <h1 class="mt-4 text-center">PUP Airport Flight Explorer</h1>

    <form>
      <div class="row g-2">
        <div class="col">
          <label for="departureCode" class="form-label">Departure Airport</label>
          <select id="departureCode" name="departureCode" class="form-select">
            <option value="">Any</option>
            <?php while ($departure = mysqli_fetch_assoc($departureOptions)) { ?>
              <option value="<?= $departure['departureAirportCode'] ?>" <?= $departure['departureAirportCode'] == $departureCode ? 'selected' : '' ?>>
                <?= $departure['departureAirportCode'] ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col">
          <label for="arrivalCode" class="form-label">Arrival Airport</label>
          <select id="arrivalCode" name="arrivalCode" class="form-select">
            <option value="">Any</option>
            <?php while ($arrival = mysqli_fetch_assoc($arrivalOptions)) { ?>
              <option value="<?= $arrival['arrivalAirportCode'] ?>" <?= $arrival['arrivalAirportCode'] == $arrivalCode ? 'selected' : '' ?>>
                <?= $arrival['arrivalAirportCode'] ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col">
          <label for="airline" class="form-label">Airline</label>
          <select id="airline" name="airline" class="form-select">
            <option value="">Any</option>
            <?php while ($airlineOption = mysqli_fetch_assoc($airlineOptions)) { ?>
              <option value="<?= $airlineOption['airlineName'] ?>" <?= $airlineOption['airlineName'] == $airline ? 'selected' : '' ?>>
                <?= $airlineOption['airlineName'] ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="row g-2 mt-3">
        <div class="col">
          <label for="sortBy" class="form-label">Sort By</label>
          <select id="sortBy" name="sortBy" class="form-select">
            <option value="">None</option>
            <option value="flightNumber" <?= $sortBy == 'flightNumber' ? 'selected' : '' ?>>Flight Number</option>
            <option value="departureDatetime" <?= $sortBy == 'departureDatetime' ? 'selected' : '' ?>>Departure Time</option>
            <option value="arrivalDatetime" <?= $sortBy == 'arrivalDatetime' ? 'selected' : '' ?>>Arrival Time</option>
          </select>
        </div>

        <div class="col">
          <label for="sortOrder" class="form-label">Order</label>
          <select id="sortOrder" name="sortOrder" class="form-select">
            <option value="ASC" <?= $sortOrder == 'ASC' ? 'selected' : '' ?>>Ascending</option>
            <option value="DESC" <?= $sortOrder == 'DESC' ? 'selected' : '' ?>>Descending</option>
          </select>
        </div>
      </div>

      <div class="mt-3 text-center align-items-center justify-content-center">
        <button class="btn btn-success" type="submit" id="applyButton">APPLY</button>
        <button class="btn btn-secondary" type="button" id="resetButton">RESET</button>
      </div>
    </form>

    <div class="shadow-lg my-4 rounded-5">
      <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>Flight Number</th>
              <th>Departure Airport</th>
              <th>Arrival Airport</th>
              <th>Departure Time</th>
              <th>Arrival Time</th>
              <th>Airline</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($flight = mysqli_fetch_assoc($flightResults)) { ?>
              <tr>
                <td><?= htmlspecialchars($flight['flightNumber']) ?></td>
                <td><?= htmlspecialchars($flight['departureAirportCode']) ?></td>
                <td><?= htmlspecialchars($flight['arrivalAirportCode']) ?></td>
                <td><?= htmlspecialchars($flight['departureDatetime']) ?></td>
                <td><?= htmlspecialchars($flight['arrivalDatetime']) ?></td>
                <td><?= htmlspecialchars($flight['airlineName']) ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script>
    document.getElementById('resetButton').addEventListener('click', function () {
      document.querySelector('form').reset();
      window.location.href = window.location.pathname;
    });
  </script>
</body>

</html>
