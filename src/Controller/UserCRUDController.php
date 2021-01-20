<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserCRUDController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit_user", name = "edit_user")
     */
    public function edit()
    {
        if($this->getUser()) {
            $currentUser = $this->getUser();
            $form = $this->createForm(UserType::class, $currentUser);
            return $this->render('user/edit_user.html.twig', ['form' => $form->createView(), 'user' => $currentUser]);
        } return $this->redirectToRoute('app_login');
    }
}