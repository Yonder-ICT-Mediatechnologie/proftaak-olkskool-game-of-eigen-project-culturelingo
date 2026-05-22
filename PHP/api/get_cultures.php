<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../db.php';

try {
    $conn = get_db_connection();

    $cultures = [];
    $cultureQuery = 'SELECT id, name, emoji, flag_path, description FROM cultures ORDER BY name';
    $lessonQuery = 'SELECT culture_id, title, body, sort_order FROM lessons ORDER BY culture_id, sort_order';
    $quizQuestionQuery = 'SELECT id, culture_id, question, sort_order FROM quiz_questions ORDER BY culture_id, sort_order';
    $choiceQuery = 'SELECT question_id, choice_order, choice_text, is_correct FROM quiz_choices ORDER BY question_id, choice_order';

    $cultureResult = $conn->query($cultureQuery);
    if (!$cultureResult) {
        throw new RuntimeException('Failed to fetch cultures: ' . $conn->error);
    }

    while ($row = $cultureResult->fetch_assoc()) {
        $cultures[$row['id']] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'emoji' => $row['emoji'],
            'flag' => $row['flag_path'],
            'description' => $row['description'],
            'lessons' => [],
            'quiz' => []
        ];
    }
    $cultureResult->free();

    $lessonResult = $conn->query($lessonQuery);
    if (!$lessonResult) {
        throw new RuntimeException('Failed to fetch lessons: ' . $conn->error);
    }

    while ($lesson = $lessonResult->fetch_assoc()) {
        if (!isset($cultures[$lesson['culture_id']])) {
            continue;
        }
        $cultures[$lesson['culture_id']]['lessons'][] = [
            'title' => $lesson['title'],
            'text' => $lesson['body']
        ];
    }
    $lessonResult->free();

    $questions = [];
    $questionResult = $conn->query($quizQuestionQuery);
    if (!$questionResult) {
        throw new RuntimeException('Failed to fetch quiz questions: ' . $conn->error);
    }

    while ($question = $questionResult->fetch_assoc()) {
        $questions[$question['id']] = [
            'id' => (int) $question['id'],
            'culture_id' => $question['culture_id'],
            'question' => $question['question'],
            'choices' => []
        ];

        if (isset($cultures[$question['culture_id']])) {
            $cultures[$question['culture_id']]['quiz'][] = & $questions[$question['id']];
        }
    }
    $questionResult->free();

    $choiceResult = $conn->query($choiceQuery);
    if (!$choiceResult) {
        throw new RuntimeException('Failed to fetch quiz choices: ' . $conn->error);
    }

    while ($choice = $choiceResult->fetch_assoc()) {
        $questionId = (int) $choice['question_id'];
        if (!isset($questions[$questionId])) {
            continue;
        }
        $questions[$questionId]['choices'][] = [
            'choiceText' => $choice['choice_text'],
            'isCorrect' => (bool) $choice['is_correct']
        ];
    }
    $choiceResult->free();

    foreach ($cultures as &$culture) {
        foreach ($culture['quiz'] as &$question) {
            $correctIndex = null;
            foreach ($question['choices'] as $index => $choice) {
                if ($choice['isCorrect']) {
                    $correctIndex = $index;
                    break;
                }
            }
            $formattedChoices = array_map(function ($choice) {
                return $choice['choiceText'];
            }, $question['choices']);

            $question['choices'] = $formattedChoices;
            $question['answer'] = $correctIndex !== null ? $correctIndex : 0;
            unset($question['culture_id']);
        }
        unset($question);
    }
    unset($culture);

    echo json_encode(array_values($cultures));
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => $error->getMessage()]);
    exit;
}
