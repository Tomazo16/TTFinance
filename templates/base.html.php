<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomazo - Finanse</title>
    <link rel="icon" type="image/x-icon" href="assets/media/euro.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>BASE</h1>
    <!-- Offcanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="editSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Edytuj użytkownika</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body" id="editSidebarContent">
      <p>Wczytywanie...</p>
    </div>
  </div>
    <img src="assets/media/euro.png">
    <?php echo htmlspecialchars($content); ?>

    <a href="#" class="btn btn-sm btn-primary"
           data-bs-toggle="offcanvas"
           data-bs-target="#editSidebar"
           onclick="loadEditForm(1)">Edytuj</a>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script>
    function loadEditForm(id) {
      const target = document.getElementById('editSidebarContent');
      target.innerHTML = '<p>Wczytywanie...</p>';
      fetch('/ttfinance/edit/' + id)
        .then(res => res.text())
        .then(html => {
          target.innerHTML = html;
        });
    }
  </script>

</body>
</html>