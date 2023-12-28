<!DOCTYPE html>
<html>

<head>
  <title>Загрузка файла</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container">
    <h1>Загрузка файла .txt</h1>
    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
      <label for="fileInput" class="custom-file-upload">
        Выбери файл пожалуйста.
      </label>
      <input type="file" name="file" id="fileInput" />
    </form>

    <div class="result hidden">
      <div id="errorMsg" class="error"></div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#fileInput').on('change', function(e) {
        e.preventDefault();

        var formData = new FormData($('#uploadForm')[0]);

        $.ajax({
          type: 'POST',
          url: 'upload.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            var resultElement = $('.result');

            if (response) {
              resultElement.html(response);
            } else {
              resultElement.html('<br><div class="error">Ошибка загрузки: ' + response.statusText + '</div>');
            }
            resultElement.removeClass('hidden');
          },
          error: function() {
            $('.result').html('<br><div class="error">Произошла ошибка</div>');
          }
        });
      });
    });
  </script>
</body>

</html>
