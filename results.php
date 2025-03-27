<?php
session_start();

// Redirect if no feedback
if (!isset($_SESSION['feedback'])) {
    header('Location: index.php');
    exit;
}

// Retrieve feedback and calculate score
$feedback = $_SESSION['feedback'];
$total_quest = count($feedback);
$score = 0;

foreach ($feedback as $item) {
    if ($item['is_correct']) {
        $score++;
    }
}

// Generate feedback message
if ($score == 5) {
    $fb_msg = "Great! You love FCB. You must have suffered a lot!! 😭";
} elseif ($score >= 2) {
    $fb_msg = "Hmm! You somehow like FCB.";
} else {
    $fb_msg = "Congrats for not being a fan of this club yayyy! 🎊🎉";
}

// Clear session after results
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FC Barcelona Quiz Result</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body id="results-page">
    <section id="results">
        <div id="score">
            <img src="./FC_Barcelona_(crest).svg.png" alt="FC Barcelona Logo">
            <h2>FC Barcelona Quiz Results</h2>
            <div id="overall-score">
                <p><strong><?= $score ?> out of <?= $total_quest ?></strong></p>
            </div>
        </div>
        <div id="feedback">
            <h2>Answer for each question:</h2>
            <?php foreach ($feedback as $index => $item): ?>
                <h3>Question <?= $index; ?>: <?= htmlspecialchars($item['question']); ?></h3>
                <?php if ($item['is_correct']): ?>
                    <p><em>Correct answer: <?= htmlspecialchars($item['correct_answer']); ?></em></p>
                    <div id="correct-answer">
                        <p class="correct">Your answer is correct! (1/1)</p>
                    </div>
                <?php else: ?>
                    <p><em>Your answer: <?= htmlspecialchars($item['user_answer']); ?></em></p>
                    <div id="incorrect-answer">
                        <p class="incorrect">Your answer is incorrect! The correct answer is: <?= htmlspecialchars($item['correct_answer']); ?> (0/1)</p>
                    </div>
                <?php endif; ?>
                <hr>
            <?php endforeach; ?>
        </div>
        <div id="summary">
            <h2>Summary Feedback of the Quiz</h2>
            <p><strong><?= htmlspecialchars($fb_msg); ?></strong></p>
        </div>
        <a href="index.php"><strong>Retake the quiz</strong></a>
    </section>
</body>
</html>
