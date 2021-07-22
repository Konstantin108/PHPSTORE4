<?php

namespace app\controllers;

use app\entities\Comment;

class CommentController extends Controller
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addAction()
    {
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        $commentId = $this->getCommentId();
        $comment = $this->container->commentRepository->getOne($commentId);
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $selfId = $_SESSION['user_true']['id'];
        $user_avatar = $_SESSION['user_true']['avatar'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->render(
                'commentEdit',
                [
                    'comment' => $comment,
                    'good' => $good,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'self_id' => $selfId,
                    'user_avatar' => $user_avatar
                ]);
        }
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function updateAction()
    {
        $id = $_POST['id'];
        $goodId = $_POST['good_id'];
        $userId = $_POST['user_id'];
        $userName = $_POST['user_name'];
        $userAvatar = $_POST['user_avatar'];
        $title = $_POST['title'];
        $text = $_POST['text'];

        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $comment = new Comment();
        $comment->id = $id;
        $comment->good_id = $goodId;
        $comment->user_id = $userId;
        $comment->user_name = $userName;
        $comment->user_avatar = $userAvatar;
        $comment->title = $title;
        $comment->text = $text;

        if ($is_auth) {
            if (!empty($title) && !empty($text)) {
                $this->container->commentRepository->save($comment);
                header('Location: /good/one?id=' . $goodId);
                return '';
            } else {
                return $this->render(
                    'emptyFields',
                    [
                        'is_auth' => $is_auth,
                        'user_name' => $userName,
                        'user_is_admin' => $userIsAdmin,
                    ]);
            }
        } else {
            return $this->render(
                'accessDenied',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function delAction()
    {
        $commentId = $this->getCommentId();
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        $comment = $this->container->commentRepository->getOne($commentId);
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userId = $_SESSION['user_true']['id'];
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->render(
                'commentDel',
                [
                    'comment' => $comment,
                    'good' => $good,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId
                ]);
        }
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function getDelAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $id = $this->getId();

        $commentId = $this->getCommentId();
        $comment = new Comment();
        $comment->id = $commentId;
        $this->request->clearUsersOrderId();


        if ($is_auth) {
            $this->container->commentRepository->delete($comment);
            header('Location: /good/one?id=' . $id);
            return '';
        } else {
            return $this->render(
                'fail',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }
}