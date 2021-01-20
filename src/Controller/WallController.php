<?php


namespace App\Controller;


use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WallController extends AbstractController
{
    /**
     * @Route("/wall", name="wall")
     */
    public function show()
    {
        $em = $this->getDoctrine()->getManager();
        $postsRepos = $em->getRepository(Post::class);
        $posts = $postsRepos->findAll();
        return $this->render('wall/wall.html.twig', ['posts'=> $posts]);
    }

}