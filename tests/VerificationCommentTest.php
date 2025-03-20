<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\VerificationComment;
use App\Entity\Comment;

class VerificationCommentTest extends TestCase
{

    protected $comment;
    protected function setUp(): void
    {
        $this->comment = new Comment();
    }

    public function testContientMotInterdit()
    {
        $service = new VerificationComment();

        $this->comment->setContenu('Ceci est un mauvais commentaire');

        $result = $service->commentaireNonAutorise($this->comment);

        $this->assertTrue($result);
    }

    public function testNeContientPasDeMotInterdit()
    {
        $service = new VerificationComment();
        $this->comment->setContenu('Ceci est un bon commentaire');

        $result = $service->commentaireNonAutorise($this->comment);

        $this->assertFalse($result);
    }
}
