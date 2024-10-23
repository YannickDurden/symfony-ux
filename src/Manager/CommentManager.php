<?php

namespace App\Manager;

use App\Entity\Comment;
use App\Repository\CommentRepository;

class CommentManager
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
    ) {
    }

    public function persistAndFlush(Comment $comment): void
    {
        $this->commentRepository->persistAndFlush($comment);
    }

    public function removeAndFlush(Comment $comment): void
    {
        $this->commentRepository->removeAndFlush($comment);
    }
}
