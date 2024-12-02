<?php
require_once __DIR__ . '/../models/QuestionModel.php';
require_once __DIR__ . '/../models/QuestionTestMappingModel.php'; // Include the mapping model
require_once __DIR__ . '/../models/ScoreModel.php'; // Include the score model
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Location of vendor autoloader

use Dotenv\Dotenv;

class QuestionController extends BaseController
{
    private $questionModel;
    private $questionTestMappingModel; // Add the mapping model
    private $scoreModel; // Add the score model

    public function __construct()
    {
        parent::__construct(); // Call the BaseController constructor
        $this->questionModel = new QuestionModel();
        $this->questionTestMappingModel = new QuestionTestMappingModel(); // Initialize the mapping model
        $this->scoreModel = new ScoreModel(); // Initialize the score model
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Display all questions.
     */
    public function index()
    {
        $this->authorize('admin'); // Ensure the user is authorized
        $questions = $this->questionModel->getAllQuestions(); // Fetch all questions

        require_once __DIR__ . '/../views/pages/management/question/list.php'; // Load the list view

        return $questions;
    }

    /**
     * Show the page to create a new question.
     */
    public function create($id)
    {
        $this->authorize('admin'); // Ensure the user is authorized
        $tests_id = $id;
        // var_dump($tests_id);die;
        require_once __DIR__ . '/../views/pages/management/question/add.php'; // Load the add question view

        return $tests_id;
    }

    /**
     * Show the page to edit an existing question.
     */
    public function edit($id)
    {
        $this->authorize('admin'); // Ensure the user is authorized
        $question = $this->questionModel->getQuestionById($id); // Fetch the question by ID
        
        if (!$question) {
            $_SESSION['flash'] = 'Question not found.'; // Set flash message if question not found
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Redirect to questions list
            exit;
        }

        require_once __DIR__ . '/../views/pages/management/question/edit.php'; // Load the edit question view

        return $questions;
    }

    /**
     * Store a new question in the database.
     */
    public function store()
    {
        $this->authorize('admin'); // Ensure the user is authorized

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStore(); // Handle the store operation
        }
    }

    private function handleStore()
    {
        $errors = $this->validateQuestionInputs($_POST); // Validate inputs

        // If there are errors, return to view with errors
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/questions-create');
        }

        // Save question to database
        $question = $this->questionModel->createQuestion(
            trim($_POST['title']),
            trim($_POST['optionA']),
            trim($_POST['optionB']),
            trim($_POST['optionC']),
            trim($_POST['optionD']),
            trim($_POST['correctAns']),
            trim($_POST['score'])
        );

        // var_dump($question['id'], $_POST['tests_id']);die;
        if ($question) {
            $question_id = $question['id']; // Get the last inserted question ID

            $this->questionTestMappingModel->createMapping($question_id, trim($_POST['tests_id'])); // Create mapping
            $this->scoreModel->createScore(trim($_POST['tests_id']), $question_id); // Create score entry

            $_SESSION['flash'] = 'Question successfully created.'; // Set success message
            header('Location: ' . $_ENV['BASE_URL'] . '/tests-detail/' . $_POST['tests_id']); // Redirect to questions list
            exit;
        } else {
            $_SESSION['flash'] = 'Failed to create question.'; // Set failure message
            header('Location: ' . $_ENV['BASE_URL'] . '/questions-create'); // Redirect back to create form
            exit;
        }
    }

    /**
     * Update an existing question.
     */
    public function update($id)
    {
        $this->authorize('admin'); // Ensure the user is authorized

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id); // Handle the update operation
        }
    }

    private function handleUpdate($id)
    {
        $errors = $this->validateQuestionInputs($_POST); // Validate inputs

        // If there are errors, return to view with errors
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/questions-edit/' . $id);
        }

        // Update question in database
        $updated = $this->questionModel->updateQuestion(
            $id,
            trim($_POST['title']),
            trim($_POST['optionA']),
            trim($_POST['optionB']),
            trim($_POST['optionC']),
            trim($_POST['optionD']),
            trim($_POST['correctAns']),
            trim($_POST['score'])
        );

        if ($updated) {
            $_SESSION['flash'] = 'Question successfully updated.'; // Set success message
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Redirect to questions list
            exit;
        } else {
            $_SESSION['flash'] = 'Failed to update question.'; // Set failure message
            header('Location: ' . $_ENV['BASE_URL'] . '/questions-edit/' . $id); // Redirect back to edit form
            exit;
        }
    }

    /**
     * Delete a question from the database.
     */
    public function delete($id)
    {
        $this->authorize('admin'); // Ensure the user is authorized

        if ($this->questionModel->deleteQuestion($id)) {
            $this->questionTestMappingModel->deleteMapping($id, null); // Optionally delete mappings
            $_SESSION['flash'] = 'Question successfully deleted.'; // Set success message
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Redirect to questions list
            exit;
        } else {
            die('Failed to delete question.'); // Handle failure
        }
    }

    public function showQuestions($test_id)
    {
        $this->authorize('student'); // Ensure the user is authorized

        // Fetch questions for the specified test
        $questions = $this->questionTestMappingModel->getQuestionsByTestId($test_id);

        // Load the view to display questions
        require_once __DIR__ . '/../views/pages/management/question/show.php';

        return $questions;
    }

    public function submitAnswers()
    {
        $this->authorize('student'); // Ensure the user is authorized as a student

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['student_id']; // Assuming student ID is stored in session
            $total_score = 0;

            foreach ($_POST['q_answer'] as $question_id => $selected_option) {
                // Fetch the correct answer and score for the question
                $question = $this->questionModel->getQuestionById($question_id);
                if ($question) {
                    // Check if the selected option is correct
                    if ($question['correctAns'] == $selected_option) {
                        // Update correct count in the score table
                        $this->scoreModel->updateCorrectCount($question_id);

                        // Calculate score earned
                        $score_earned = $question['score'];
                        $total_score += $score_earned;

                        // Update the student's total score
                        $this->scoreModel->updateStudentScore($student_id, $score_earned);
                    }
                }
            }

            // Redirect to the dashboard after processing
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
            exit;
        }
    }

    /**
     * Validate question inputs.
     */
    private function validateQuestionInputs($data)
    {
        $errors = [];
        if (empty(trim($data['title']))) {
            $errors['title'] = 'Question title is required.';
        }
        if (empty(trim($data['optionA']))) {
            $errors['optionA'] = 'Option A is required.';
        }
        if (empty(trim($data['optionB']))) {
            $errors['optionB'] = 'Option B is required.';
        }
        if (empty(trim($data['optionC']))) {
            $errors['optionC'] = 'Option C is required.';
        }
        if (empty(trim($data['optionD']))) {
            $errors['optionD'] = 'Option D is required.';
        }
        if (empty(trim($data['correctAns']))) {
            $errors['correctAns'] = 'Correct answer is required.';
        }
        if (empty(trim($data['score']))) {
            $errors['score'] = 'Score is required.';
        }
        return $errors;
    }

    /**
     * Handle validation errors.
     */
    private function handleValidationErrors($errors, $oldData, $redirectPath)
    {
        $_SESSION['errors'] = $errors; // Store errors in session
        $_SESSION['old'] = $oldData;    // Store old input data
        header('Location: ' . $_ENV['BASE_URL'] . $redirectPath); // Redirect back to the form
        exit;
    }
}
?>
