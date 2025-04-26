<?php
namespace Tests\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Exception;
use PHPUnit\Framework\TestCase;
use App\Controllers\QuestionController;
use App\Repositories\QuestionRepository;
use App\Repositories\TagRepository;
use App\Repositories\AnswerRepository;
use Mockery;

class QuestionControllerTest extends TestCase
{
    private $questionRepositoryMock;
    private $tagRepositoryMock;
    private $answerRepositoryMock;
    private $controller;

    protected function setUp(): void
    {
        $this->questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $this->tagRepositoryMock = $this->createMock(TagRepository::class);
        $this->answerRepositoryMock = $this->createMock(AnswerRepository::class);

        //partial mock
        $this->controller = $this->getMockBuilder(QuestionController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render']) // We override only 'render'
            ->getMock();

        // Manually inject mocks
        $this->controller->questionRepository = $this->questionRepositoryMock;
        $this->controller->tagRepository = $this->tagRepositoryMock;
        $this->controller->answerRepository = $this->answerRepositoryMock;
    }

    public function testSearchNoResultsRendersNoResultsTemplate(): void
    {
        $_GET['q'] = 'nonexistent';

        $this->questionRepositoryMock
            ->method('searchQuestion')
            ->with('nonexistent')
            ->willReturn([]);

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('no_results', ['searchTerm' => 'nonexistent']);

        $this->controller->search();
    }

    public function testSearchWithResultsRendersQuestionsTemplate(): void
    {
        $_GET['q'] = 'php';

        $fakeQuestion = new Question(1,1,'What is PHP?','Explain PHP basics', 0);
        $fakeQuestion->id = 1;


        $fakeQuestions = [$fakeQuestion];

        $this->questionRepositoryMock
            ->method('searchQuestion')
            ->with('php')
            ->willReturn($fakeQuestions);

        $this->tagRepositoryMock
            ->method('findAll')
            ->willReturn(['php', 'web']);

        $this->tagRepositoryMock
            ->method('find')
            ->with(1)
            ->willReturn(['php']);

        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with('questions', [
                'title' => 'List all matching questions',
                'questions' => $fakeQuestions,
                'allTags' => ['php', 'web'],
            ]);

        $this->controller->search();
    }

    public function testShowQuestionsRendersWithQuestionsAndTags(): void
    {

        $fakeQuestion1 = new Question(1, 1, 'What is PHP?', 'Explain PHP basics', 0);
        $fakeQuestion1->id = 1;
        $fakeQuestion2 = new Question(2, 1, 'What is Laravel?', 'Explain Laravel basics', 0);
        $fakeQuestion2->id = 2;

        $fakeQuestions = [
            $fakeQuestion1,
            $fakeQuestion2,
        ];

        $fakeTags = ['PHP', 'Laravel'];


        $this->questionRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($fakeQuestions);

        $this->tagRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($fakeTags);

        $this->tagRepositoryMock
            ->expects($this->exactly(count($fakeQuestions))) // Call find() for each question
            ->method('find')
            ->willReturnOnConsecutiveCalls(['PHP'], ['Laravel']);


        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with(
                'question.questions',
                [
                    'title' => 'List all questions',
                    'questions' => $fakeQuestions,
                    'allTags' => $fakeTags,
                ]
            );

        $this->controller->showQuestions();
    }

    public function testAddQuestionWithValidData(): void
    {

        $superGlobalMock = Mockery::mock('alias:App\Core\SuperGlobalManager');

        $superGlobalMock->shouldReceive('getRequest')
            ->with('title', '')
            ->andReturn('What is PHP?');

        $superGlobalMock->shouldReceive('getRequest')
            ->with('message', '')
            ->andReturn('Explain PHP basics');

        $superGlobalMock->shouldReceive('getRequest')
            ->with('tag_ids', [])
            ->andReturn([1, 2]);

        $superGlobalMock->shouldReceive('getSession')
            ->with('user')
            ->andReturn(1);


        $this->questionRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Question::class));

        $this->questionRepositoryMock
            ->expects($this->once())
            ->method('getLastInsertId')
            ->willReturn(1);

        $this->tagRepositoryMock
            ->expects($this->exactly(2))
            ->method('assignTagToQuestion')
            ->with(
                $this->equalTo(1),
                $this->callback(function ($tagId) {
                    return in_array($tagId, [1, 2], true);
                })
            );

        // Act
        try {
            $this->controller->addQuestion();
        } catch (Exception $e) {
        }
    }

    public function testShowQuestionRendersCorrectView(): void
    {

        $fakeQuestion = new Question(1, 1, 'What is PHP?', 'Explain PHP basics', 0);
        $fakeQuestion->id = 1;

        $fakeAnswer1 = new Answer(1, 1,'Answer 1', 0);
        $fakeAnswer2 = new Answer(1, 2, 'Answer 2', 0);

        $fakeAnswers = [
          $fakeAnswer1, $fakeAnswer2,
        ];
        $fakeTags = ['PHP', 'Backend'];


        $this->questionRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($fakeQuestion);

        $this->answerRepositoryMock
            ->expects($this->once())
            ->method('findByQuestion')
            ->with(1)
            ->willReturn($fakeAnswers);

        $this->tagRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($fakeTags);

        $this->tagRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(['PHP']);


        $this->controller
            ->expects($this->once())
            ->method('render')
            ->with(
                'question.details',
                [
                    'title' => 'View Question',
                    'question' => $fakeQuestion,
                    'answers' => $fakeAnswers,
                    'tags' => $fakeTags,
                ]
            );


        $this->controller->showQuestion(1);
    }



}