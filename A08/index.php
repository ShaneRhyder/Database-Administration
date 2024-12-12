<?php
include("connect.php");

$filterColumn = isset($_GET['filterColumn']) ? $_GET['filterColumn'] : '';
$filterValue = isset($_GET['filterValue']) ? $_GET['filterValue'] : '';
$sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : '';
$sortOrder = isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'DESC' ? 'DESC' : 'ASC';

$query = "SELECT * FROM flightlogs";
$conditions = [];

if (!empty($filterColumn) && !empty($filterValue)) {
  $conditions[] = "$filterColumn = '$filterValue'";
}

if (!empty($conditions)) {
  $query .= " WHERE " . implode(' AND ', $conditions);
}

if (!empty($sortColumn)) {
  $query .= " ORDER BY $sortColumn $sortOrder";
}

$result = executeQuery($query);

$filterOptions = [];
if (!empty($filterColumn)) {
  $filterOptionsQuery = "SELECT DISTINCT $filterColumn FROM flightlogs";
  $filterOptionsResult = executeQuery($filterOptionsQuery);

  while ($row = mysqli_fetch_assoc($filterOptionsResult)) {
    $filterOptions[] = $row[$filterColumn];
  }
}

$columnNames = [
  "flightNumber",
  "departureAirportCode",
  "arrivalAirportCode",
  "departureDatetime",
  "arrivalDatetime",
  "flightDurationMinutes",
  "airlineName",
  "aircraftType",
  "passengerCount",
  "ticketPrice",
  "creditCardNumber",
  "creditCardType",
  "pilotName"
];

$columnTitles = [
  "Flight Number",
  "Departure Airport Code",
  "Arrival Airport Code",
  "Departure Date-Time",
  "Arrival Date-Time",
  "Flight Duration",
  "Airline Name",
  "Aircraft Type",
  "Passenger Count",
  "Ticket Price",
  "Credit Card Number",
  "Credit Card Type",
  "Pilot Name"
];

$entries = 0;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activity 8 DA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

  <div class="container-fluid border rounded-3 p-3">
    <form method="GET" class="mb-3">
      <div class="row g-3 align-items-center justify-content-center">

        <div class="col-md-4">
          <label for="filterColumn" class="form-label">Filter By</label>
          <select name="filterColumn" id="filterColumn" class="form-select" onchange="this.form.submit()">
            <option value="">Choose Filter Column</option>
            <?php foreach ($columnNames as $index => $name) { ?>
              <option value="<?php echo $name; ?>" <?php echo ($filterColumn === $name) ? 'selected' : ''; ?>>
                <?php echo $columnTitles[$index]; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label for="filterValue" class="form-label">Select Value</label>
          <select name="filterValue" id="filterValue" class="form-select">
            <option value="">Choose Value</option>
            <?php foreach ($filterOptions as $value) { ?>
              <option value="<?php echo $value; ?>" <?php echo ($filterValue === $value) ? 'selected' : ''; ?>>
                <?php echo $value; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md-2">
          <label for="sortColumn" class="form-label">Sort By</label>
          <select name="sortColumn" id="sortColumn" class="form-select">
            <option value="">Choose Column</option>
            <?php foreach ($columnNames as $index => $name) { ?>
              <option value="<?php echo $name; ?>" <?php echo ($sortColumn === $name) ? 'selected' : ''; ?>>
                <?php echo $columnTitles[$index]; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-2">
          <label for="sortOrder" class="form-label">Order</label>
          <select name="sortOrder" id="sortOrder" class="form-select">
            <option value="ASC" <?php echo ($sortOrder === 'ASC') ? 'selected' : ''; ?>>Ascending</option>
            <option value="DESC" <?php echo ($sortOrder === 'DESC') ? 'selected' : ''; ?>>Descending</option>
          </select>
        </div>
        <div class="col-md-2 mt-4 d-flex justify-content-center">
          <button type="submit" class="btn btn-primary">Apply</button>
        </div>
      </div>
    </form>

    <div class="table-responsive text-center">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th scope="col">#</th>
            <?php foreach ($columnTitles as $title) { ?>
              <th scope="col"><?php echo $title; ?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($flightRow = mysqli_fetch_assoc($result)) {
              $entries++;
          ?>
              <tr>
                <th scope="row"><?php echo $entries; ?></th>
                <?php foreach ($columnNames as $name) { ?>
                  <td><?php echo $flightRow[$name]; ?></td>
                <?php } ?>
              </tr>
            <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="<?php echo count($columnNames) + 1; ?>">No results found.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>