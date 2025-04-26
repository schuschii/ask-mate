<?php

namespace Tests\Repositories;

use App\Core\Database;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use Exception;
use PHPUnit\Framework\TestCase;
use PDO;

class QuestionRepositoryTest extends TestCase
{
    protected static ?PDO $pdo = null;
    protected ?QuestionRepository $repository = null;

    // Runs before all tests
    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        // Hardcode the environment to 'test' for the testing environment
        putenv('ENV=test');

        Database::connect();
        self::$pdo = Database::getConnection();
    }

    // Runs before each test method
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {

        $this->loadTestDatabase();

        // Create a new repository instance before each test
        $this->repository = new QuestionRepository();
    }

    // Load schema and sample data for testing
    /**
     * @throws Exception
     */
    protected function loadTestDatabase(): void
    {

        $loadScript = __DIR__ . '/../../script/load_database.php';
        if (file_exists($loadScript)) {
            require $loadScript;
        } else {
            throw new Exception("Database load script not found.");
        }
    }

    // Truncate tables to ensure a clean database before each test
    protected function truncateTables(): void
    {
        // Disable foreign key checks
        self::$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

        $tables = ['rel_question_tag', 'answer', 'question', 'tag', 'image', 'registered_user'];

        foreach ($tables as $table) {
            $sql = "TRUNCATE TABLE {$table}";
            self::$pdo->exec($sql);
        }

        // Re-enable foreign key checks
        self::$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }

    // Test the findAll method of QuestionRepository

    /**
     * @throws Exception
     */
    public function testFindAll(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $questions = $this->repository->findAll();

        $this->assertIsArray($questions);
        $this->assertGreaterThan(0, count($questions), 'No questions found in the database.');

        $this->assertTrue(property_exists($questions[0], 'id'));
        $this->assertTrue(property_exists($questions[0], 'submission_time'));
    }

    public function testFind(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $question = $this->repository->find(1);
        $this->assertIsObject($question);

        $this->assertTrue(property_exists($question, 'id'));
        $this->assertTrue(property_exists($question, 'title'));
        $this->assertTrue(property_exists($question, 'message'));

        $this->assertEquals(1, $question->id);
        $this->assertNotEmpty($question->title);
        $this->assertNotEmpty($question->message);

        $questionNotFound = $this->repository->find(999);
        $this->assertNull($questionNotFound);
    }

    public function testSave(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $question = new Question(
            1,
            1,
            'Test Question Title',
            'This is a test message for the question.',
            0
        );

        $this->repository->save($question);

        $stmt = self::$pdo->prepare("SELECT * FROM question WHERE title = :title");
        $stmt->bindParam(':title', $question->title);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        $this->assertNotNull($result);
        $this->assertEquals($question->title, $result->title);
        $this->assertEquals($question->message, $result->message);
        $this->assertEquals(0, $result->vote_number);
        $this->assertEquals($question->id_registered_user, $result->id_registered_user);
    }

    public function testUpdate(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $question = $this->repository->find(1);
        $question->title = 'Updated Title';
        $question->message = 'Updated message for the question.';
        $this->repository->update($question);

        $stmt = self::$pdo->prepare("SELECT * FROM question WHERE id = :id");
        $stmt->bindParam(':id', $question->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        $this->assertNotNull($result);
        $this->assertEquals($question->title, $result->title);
        $this->assertEquals($question->message, $result->message);
        $this->assertEquals($question->id_registered_user, $result->id_registered_user);
        $this->assertEquals($question->id_image, $result->id_image);
    }

public function testDelete(): void
{
    $this->truncateTables();
    $this->loadTestDatabase();

    $question = $this->repository->find(1);
    $questionId = $question->id;
    $this->repository->delete($questionId);


    $stmt = self::$pdo->prepare("SELECT * FROM question WHERE id = :id");
    $stmt->bindParam(':id', $questionId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    $this->assertFalse($result, 'The question should be deleted.');


    $stmt = self::$pdo->prepare("SELECT * FROM rel_question_tag WHERE id_question = :id");
    $stmt->bindParam(':id', $questionId);
    $stmt->execute();
    $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
    $this->assertEmpty($tags, 'Related tags should be deleted.');

    $stmt = self::$pdo->prepare("SELECT * FROM answer WHERE id_question = :id");
    $stmt->bindParam(':id', $questionId);
    $stmt->execute();
    $answers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $this->assertEmpty($answers, 'Related answers should be deleted.');
}


    public function testCountQuestionsByTag(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $question = $this->repository->find(1);
        $questionId = $question->id;
        $tagId = 1;

        $stmt = self::$pdo->prepare("INSERT INTO rel_question_tag (id_question, id_tag) VALUES (:id_question, :id_tag)");
        $stmt->bindParam(':id_question', $questionId);
        $stmt->bindParam(':id_tag', $tagId);
        $stmt->execute();

        $questionCount = $this->repository->countQuestionsByTag($tagId);

        $this->assertEquals(1, $questionCount, 'The count of questions for the tag should be 1.');
    }


    public function testFindQuestionsByTag(): void
    {
        $this->truncateTables();
        $this->loadTestDatabase();

        $question1 = $this->repository->find(1);
        $questionId1 = $question1->id;

        $question2 = $this->repository->find(2);
        $questionId2 = $question2->id;

        $tagId = 1;

        $stmt = self::$pdo->prepare("INSERT INTO rel_question_tag (id_question, id_tag) VALUES (:id_question, :id_tag)");

        $stmt->bindParam(':id_question', $questionId1);
        $stmt->bindParam(':id_tag', $tagId);
        $stmt->execute();

        $stmt->bindParam(':id_question', $questionId2);
        $stmt->bindParam(':id_tag', $tagId);
        $stmt->execute();

        $questions = $this->repository->findQuestionsByTag($tagId);

        $this->assertIsArray($questions);
        $this->assertGreaterThan(0, count($questions), 'No questions found for the tag.');
        $this->assertEquals($question1->title, $questions[0]->title);
        $this->assertEquals($question2->title, $questions[1]->title);
        $this->assertTrue(property_exists($questions[0], 'id'));
        $this->assertTrue(property_exists($questions[0], 'title'));
    }

    public function testSearchQuestion(): void
    {
        $searchTerm = 'PHP';
        $questions = $this->repository->searchQuestion($searchTerm);

        $this->assertIsArray($questions);
        $this->assertGreaterThan(0, count($questions));
    }

    // Clean up the test database after all tests
    public static function tearDownAfterClass(): void
    {
        self::$pdo = null;
    }


}