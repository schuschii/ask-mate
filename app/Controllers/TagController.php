<?php

namespace App\Controllers;


use App\Repositories\QuestionRepository;
use App\Core\Controller;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    private TagRepository $tagRepository;
    private QuestionRepository $questionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->tagRepository = new TagRepository();
        $this->questionRepository = new QuestionRepository();
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