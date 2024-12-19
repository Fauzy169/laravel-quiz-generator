<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm rounded-3">
            <div class="card-header text-center">
                <h1 class="h3 text-dark">Generate Quiz</h1>
            </div>
            <div class="card-body">
                <form id="quiz-form" method="POST" action="/generate-quiz">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" id="kategori" name="kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kesulitan" class="form-label">Kesulitan</label>
                        <input type="text" id="kesulitan" name="kesulitan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <input type="text" id="level" name="level" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Generate Quiz</button>
                </form>

                <!-- This div will display the quiz results -->
                <div id="quiz-result" class="mt-4 p-3 border rounded-3 shadow-sm bg-white"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#quiz-form').on('submit', function (e) {
                e.preventDefault();

                $.post($(this).attr('action'), $(this).serialize())
                    .done(function (data) {
                        // Ambil konten soal dari respons JSON
                        var quizContent = data.quizContent;

                        // Tampilkan hasil di #quiz-result
                        $('#quiz-result').html('<pre>' + quizContent + '</pre>');
                    })
                    .fail(function () {
                        alert('Failed to generate quiz.');
                    });
            });
        });
    </script>
</body>

</html>
