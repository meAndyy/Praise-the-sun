<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Bibliographie;
use AppBundle\BibliographieRepository;

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
     */
    public function newFormAction(Request $request)
    {
        $argsArray = [
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
     * @Route("/bibliographies/create/{name}")
     */
    public function createAction($name,$date,$info)
    {
        $bibliographie = new Bibliographie();
        $bibliographie->setName($name);
        $bibliographie->setPublishDate($date);
        $bibliographie->setInfo($info);

        // entity manager
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($bibliographie);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Created new bibliographie with id '.$bibliographie->getId());
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