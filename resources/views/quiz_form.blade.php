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
            </div>
        </div>

        <div id="quiz-results" class="mt-4"></div>
    </div>

    <div id="question-template" class="d-none">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">Question <span class="question-index"></span></h5>
            </div>
            <div class="card-body">
                <form class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control question-text" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer Options</label>
                        <div>
                            <input type="text" class="form-control mb-2 option-a" placeholder="A) Option A" required>
                            <input type="text" class="form-control mb-2 option-b" placeholder="B) Option B" required>
                            <input type="text" class="form-control mb-2 option-c" placeholder="C) Option C" required>
                            <input type="text" class="form-control mb-2 option-d" placeholder="D) Option D" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correct Answer</label>
                        <input type="text" class="form-control correct-answer" required>
                    </div>
                </form>
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
                        var quizContent = data.quizContent;

                        var questions = quizContent.split("\n\n");

                        $('#quiz-results').html('');

                        questions.forEach(function (question, index) {
                            var questionParts = question.split("\n");

                            var questionText = questionParts[0].replace(/^\d+\.\s/, ''); 
                            var optionA = questionParts[1].replace(/^A\)\s/, '');
                            var optionB = questionParts[2].replace(/^B\)\s/, '');
                            var optionC = questionParts[3].replace(/^C\)\s/, '');
                            var optionD = questionParts[4].replace(/^D\)\s/, '');
                            var correctAnswer = questionParts[5].replace(/^Jawaban Benar:\s/, '');

                            var questionCard = $('#question-template').clone();
                            questionCard.removeClass('d-none');   

                            questionCard.find('.question-index').text(index + 1);
                            questionCard.find('.question-text').val(questionText);
                            questionCard.find('.option-a').val(optionA);
                            questionCard.find('.option-b').val(optionB);
                            questionCard.find('.option-c').val(optionC);
                            questionCard.find('.option-d').val(optionD);
                            questionCard.find('.correct-answer').val(correctAnswer);

                            $('#quiz-results').append(questionCard);
                        });
                    })
                    .fail(function () {
                        alert('Failed to generate quiz.');
                    });
            });
        });
    </script>
</body>

</html>
