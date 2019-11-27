<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
            ]);
    }

    /**
     * @Route("/user/show/{id}",name="user_show")
     */
    public function show(string $id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        return $this->render('user/show.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/add",name="user_add",methods={"GET","POST"})
     */

     public function add(Request $request){
        $user = new User();
        $form=$this->createForm(UserType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_show',[
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/add.html.twig',[
            'form'=>$form->createView()
        ]);
     }

     /**
     * @Route("/user/edit/{id}",name="user_edit",methods={"GET","POST"})
     */

    public function edit(string $id,Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        
        $form=$this->createForm(UserType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('user_show',[
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/edit.html.twig',[
            'form'=>$form->createView()
        ]);
     }
}
