<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\T001Contact;
use App\Repository\T001ContactRepository;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $contactDetails = $this->getDoctrine()->getRepository(T001Contact::class)->getContactDetails($em);
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController','contacts'=>$contactDetails
        ]);
    }
    /**
     * @Route("/create_contact", name="create_contact")
     */
    public function create_contact(Request $request,EntityManagerInterface $entityManager): Response
    {
        $contactDetails='';
        $id = $request->get('id');
        if($id!=''){
            $contactDetails = $this->getDoctrine()->getRepository(T001Contact::class)->findOneBy(array('id' => $id));
        }
    
        return $this->render('contact/Create_contact.twig', [
            'controller_name' => 'ContactController','contacts'=>$contactDetails
        ]);
    }
    /**
     * @Route("/save_contact", name="save_contact")
     */
    public function save_contact(Request $request,EntityManagerInterface $entityManager): Response
    {
        $name = $request->get('name');
        $age = $request->get('age');
        $mobile = $request->get('mobile');
        $id = $request->get('editId');
        $em = $this->getDoctrine()->getManager();
        if($id==''){
            $contact = new T001Contact();
            $contact->setContactName($name);
            $contact->setAge($age);
            $contact->setMobileNumber($mobile);
            $contact->setStatus(0);
        }else{
            $contact = $this->getDoctrine()->getRepository(T001Contact::class)->findOneBy(array('id' => $id));
            $contact->setContactName($name);
            $contact->setAge($age);
            $contact->setMobileNumber($mobile);
            $contact->setStatus(0);
        }
        $em->persist($contact);
        $em->flush();
        $response = new Response("success");
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/delete_contact", name="delete_contact")
     */
    public function delete_contact(Request $request,EntityManagerInterface $entityManager): Response
    {     
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        if($id!=''){
            $contact = $this->getDoctrine()->getRepository(T001Contact::class)->findOneBy(array('id' => $id));
            $contact->setStatus(1);
        }
        $em->persist($contact);
        $em->flush();
        $response = new Response("success");
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
