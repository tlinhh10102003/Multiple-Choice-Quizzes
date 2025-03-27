<?php
// Start session
session_start();

// Initialize questions and feedback
$questions = [
    1 => [
        'question' => 'What is the biggest stadium in Europe?',
        'options' => ['A' => 'Parc de Princes', 'B' => 'Allianz Arena', 'C' => 'Spotify Camp Nou', 'D' => 'Santiago Bernabéu'],
        'answer' => 'C',
    ],
    2 => [
        'question' => 'How many UCL titles do FC Barcelona have?',
        'options' => ['A' => '1', 'B' => '5', 'C' => '4', 'D' => '6'],
        'answer' => 'B',
    ],
    3 => [
        'question' => 'When was the last season did FC Barcelona win an UCL title?',
        'options' => ['A' => '2014/2015', 'B' => '2018/2019', 'C' => '2013/2014', 'D' => '2019/2020'],
        'answer' => 'A',
    ],
    4 => [
        'question' => 'Who is the recent manager of FC Barcelona?',
        'options' => ['A' => 'Pep Guardiola', 'B' => 'Hansi Flick', 'C' => 'Donald Trump', 'D' => 'Taylor Swift'],
        'answer' => 'B',
    ],
    5 => [
        'question' => 'What is the name of matches between FC Barcelona and Real Madrid?',
        'options' => ['A' => 'Derby Madrid', 'B' => 'Derby London', 'C' => 'Le Classique', 'D' => 'El Clásico'],
        'answer' => 'D',
    ],
];

// Initialize feedback array
if (!isset($_SESSION['feedback'])) {
    $_SESSION['feedback'] = [];
}

// Get the current question
$curr_quest = $_SESSION['quest'] ?? 1;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answer = $_POST['answer'];
    $is_correct = $user_answer === $questions[$curr_quest]['answer'];

    // Save the feedback
    $_SESSION['feedback'][$curr_quest] = [
        'question' => $questions[$curr_quest]['question'],
        'user_answer' => $user_answer,
        'is_correct' => $is_correct,
        'correct_answer' => $questions[$curr_quest]['answer'],
    ];

    // Move to the next question
    $curr_quest++;
    $_SESSION['quest'] = $curr_quest;

    // If all questions are answered, redirect to results
    if ($curr_quest > count($questions)) {
        header("Location: result.php");
        exit;
    }
}

// Current question data
$curr_quest_data = $questions[$curr_quest];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FC Barcelona Quiz</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body id="questions-page">
    <section id="question">
        <img src="./FC_Barcelona_(crest).svg.png" alt="FC Barcelona Logo">
        <div id="question-container">
            <h2>Question <?= $curr_quest; ?> of 5</h2>
        </div>
        <p><?= htmlspecialchars($curr_quest_data['question']); ?></p>
    </section>

    <section>
        <form method="post">
            <div id="answers">
                <?php foreach ($curr_quest_data['options'] as $index => $option): ?>
                    <label>
                        <input type="radio" name="answer" value="<?= htmlspecialchars($index); ?>" required>
                        <?= htmlspecialchars($option); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
            <div id="button">
                <button type="submit">Next</button>
            </div>
        </form>
    </section>
    <div id="progress-bar" style="--current-question: <?= $curr_quest; ?>;"></div>
</body>
</html>
