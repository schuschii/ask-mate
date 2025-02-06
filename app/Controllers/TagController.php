<?php

namespace App\Controllers;


use App\Contracts\QuestionRepository;
use App\Core\Controller;
use App\Core\Database;
use App\Repositories\TagRepository;
use PDO;

class TagController extends Controller
{
    private TagRepository $tagRepository;
    private QuestionRepository $questionRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();
        $this->tagRepository = new TagRepository();
        $this->questionRepository = new QuestionRepository($connection);
    }

    public function showTags(): void
    {
        $tags = $this->tagRepository->findAll();

        foreach ($tags as $tag) {
            $tag->question_count = $this->questionRepository->countQuestionsByTag($tag->id);

        }

        $this->render('tag.tags', ['tags' => $tags]);
    }

    public function showCreateTagForm(): void
    {
        $this->render("create");
    }

    public function createTag(): void
    {
        $tagName = $_POST['name'] ?? '';

        if (!empty($tagName)) {
            $this->tagRepository->save($tagName);
        }

        header("Location: /tags");
        exit();
    }
}