<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <script>
        $(document).ready(function() {
  var table = $('#example').DataTable({
    "columnDefs": [{      "targets": 0,      "data": null,      "defaultContent": "<button> Show details </button>"    }]
  });

  $('#example tbody').on('click', 'button', function() {
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      row.child(format(row.data())).show();
      tr.addClass('shown');
    }
  });

  function format(d) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
      '<tr>' +
      '<td>Full name:</td>' +
      '<td>' + d[0] + ' ' + d[1] + '</td>' +
      '</tr>' +
      '<tr>' +
      '<td>Extension number:</td>' +
      '<td>' + d[2] + '</td>' +
      '</tr>' +
      '<tr>' +
      '<td>Extra info:</td>' +
      '<td>And any further details here (images etc)...</td>' +
      '</tr>' +
      '</table>';
  }
});

    </script>
<table id="example" class="display" style="width:100%">
  <thead>
    <tr>
      <th>Name</th>
      <th>Position</th>
      <th>Office</th>
      <th>Age</th>
      <th>Start date</th>
      <th>Salary</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tiger Nixon</td>
      <td>System Architect</td>
      <td>Edinburgh</td>
      <td>61</td>
      <td>2011/04/25</td>
      <td>$320,800</td>
    </tr>
    <tr>
      <td>Tiger Nixon</td>
      <td>System Architect</td>
      <td>Edinburgh</td>
      <td>61</td>
      <td>2011/04/25</td>
      <td>$320,800</td>
    </tr>
    <tr>
      <td>Tiger Nixon</td>
      <td>System Architect</td>
      <td>Edinburgh</td>
      <td>61</td>
      <td>2011/04/25</td>
      <td>$320,800</td>
    </tr>
    <!-- other rows... -->
  </tbody>
</table>
</body>
</html>