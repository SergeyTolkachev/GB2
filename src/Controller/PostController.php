<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\PostRepository;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        $currentUserName = $this->getUser()->getUsername();
        $userRepos = $this->getDoctrine()->getManager()->getRepository(User::class);
        $currentUser = $userRepos->findOneBy(['email' => $currentUserName]);

        $posts = $postRepository->findBy(['user'=>$currentUser]);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if ($this->getUser()) {
            $currentUserName = $this->getUser()->getUsername();

            $userRepos = $this->getDoctrine()->getManager()->getRepository(User::class);
            $currentUser = $userRepos->findOneBy(['email' => $currentUserName]);

            $post = new Post();
            $post->setUser($currentUser);
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('post_index');
            }

            return $this->render('post/new.html.twig', [
                'post' => $post,
                'form' => $form->createView(),
            ]);
        }
        $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
            return $this->render('post/show.html.twig', [
                'post' => $post,
            ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $user = $post->getUser();
        $userEmail = $user->getEmail();
        $currentUserEmail = $this->getUser()->getUsername();

        if ($userEmail === $currentUserEmail) {
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('post_index');
            }

            return $this->render('post/edit.html.twig', [
                'post' => $post,
                'form' => $form->createView(),
            ]);
        } else
            return $this->redirectToRoute('wall');
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
