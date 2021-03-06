<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Bibliographie;
use AppBundle\BibliographieRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class BibliographieController extends Controller
{
        /**
         * @Route("/bibliographies/list", name="bibliographies_list")
         */
        public function listAction(Request $request)
    {
        $bibliographieRepository = $this->getDoctrine()->getRepository('AppBundle:Bibliographie');
        $bibliographies = $bibliographieRepository->findAll();

        $argsArray = [
            'bibliographies' => $bibliographies
        ];

        $templateName = 'bibliographies/list';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

     /**
     * @Route("/bibliographies/new", name="bibliographies_new_form")
     * 
     */
    public function newFormAction(Request $request)
    {
       // create a task and give it some dummy data for this example
        $bibliographie = new Bibliographie();

        $form = $this->createFormBuilder($bibliographie)
            ->add('name', TextType::class)
            ->add('PublishDate', TextType::class)
            ->add('Info', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Bibliographie'))
            ->getForm();

            $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $bibliographie = $form->getData();
            $name = $bibliographie->getName();
            $date = $bibliographie->getPublishDate();
            $info = $bibliographie->getInfo();

            return $this->createAction($bibliographie);
        }


        $argsArray = [
            'form' => $form->createView(),
        ];

        $templateName = 'bibliographies/new';
        return $this->render($templateName . '.html.twig', $argsArray);
       
    }

    /**
    * @Route("/bibliographies/processNewForm", name="bibliographies_process_new_form")
    */
    public function processNewFormAction(Request $request)
    {
        // extract 'name' parameter from POST data
        $name = $request->request->get('name');
        $date = $request->request->get('date');
        $info = $request->request->get('info');

        if(empty($name)||empty($date)){
            $this->addFlash(
                'error',
                'Please fill all fields'
            );

            // forward this to the createAction() method
            return $this->newFormAction($request);
        }

        // forward this to the createAction() method
        return $this->createAction($name,$date,$info);
    }

         /**
     * @Route("/bibliographies/create/{name}/{date}/{info}")
     */
    public function createAction(Bibliographie $bibliographie)
    {
        

        // entity manager
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($bibliographie);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->redirectToRoute('bibliographies_list');
    }

    /**
     * @Route("/bibliographies/delete/{id}")
     */
    public function deleteAction($id)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        $bibliographieRepository = $this->getDoctrine()->getRepository('AppBundle:Bibliographie');

        // find thge student with this ID
        $bibliographie = $bibliographieRepository->find($id);

        // tells Doctrine you want to (eventually) delete the Student (no queries yet)
        $em->remove($bibliographie);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Deleted bibliographie with id '.$id);
    }

    /**
     * @Route("/bibliographies/update/{id}/{newName}")
     */
    public function updateAction($id, $newName)
    {
        $em = $this->getDoctrine()->getManager();
        $bibliographie = $em->getRepository('AppBundle:Bibliographie')->find($id);

        if (!$bibliographie) {
            throw $this->createNotFoundException(
                'No bibliographie found for id '.$id
            );
        }

        $bibliographie->setName($newName);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/bibliographies/show/{id}", name="bibliographies _show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Bibliographie')->find($id);

        if (!$bibliographie) {
            throw $this->createNotFoundException(
                'No bibliographie found for id '.$id
            );
        }
        $argsArray = [
            'bibliographie' => $bibliographie
        ];

        $templateName = 'bibliographies/show';
        return $this->render($templateName . '.html.twig', $argsArray);
    }
}