<?php

namespace app\repositories;

use app\entities\Comment;

class CommentRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'comments';
    }

    protected function getEntityName(): string
    {
        return Comment::class;
    }
}