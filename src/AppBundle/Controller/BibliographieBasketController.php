<?php
 namespace AppBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use AppBundle\Entity\Bibliographie;
    use Symfony\Component\HttpFoundation\Session\Session;

    /**
     * Basket controller.
     *
     * @Route("/basket")
     */
    class BibliographieBasketController extends Controller
    {
        /**
     * @Route("/", name="bibliographies_basket_index")
     */
    public function indexAction()
    {
        // no need to put electives array in Twig argument array - Twig can get data direct from session
        $argsArray = [
        ];

        $templateName = 'basket/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/clear", name="bibliographies_basket_clear")
     */
    public function clearAction()
    {
        $session = new Session();
        $session->remove('basket');

        return $this->redirectToRoute('bibliographies_basket_index');
    }

    /**
     * @Route("/add/{id}", name="bibliographies_basket_add")
     */
    public function addToBibliographieCart(Bibliographie $bibliographie)
    {
        // default - new empty array
        $bibliographies = [];

        // if no 'electives' array in the session, add an empty array
        $session = new Session();
        if($session->has('basket')){
            $bibliographies = $session->get('basket');
        }

         // get ID of elective
        $id = $bibliographie->getId();

        // only try to add to array if not already in the array
        if(!array_key_exists($id, $bibliographies)){
            // append $elective to our list
            $bibliographies[$id] = $bibliographie;

            // store updated array back into the session
            $session->set('basket', $bibliographies);
        }

        return $this->redirectToRoute('bibliographies_basket_index');
    }

    /**
     * @Route("/delete/{id}", name="bibliographies_basket_delete")
     */
    public function deleteAction(int $id)
    {
        // default - new empty array
        $bibliographies = [];

        // if no 'electives' array in the session, add an empty array
        $session = new Session();
        if($session->has('basket')){
            $bibliographies = $session->get('basket');
        }

        // only try to remove if it's in the array
        if(array_key_exists($id, $bibliographies)){
            // remove entry with $id
            unset($bibliographies[$id]);

            if(sizeof($bibliographies) < 1){
                return $this->redirectToRoute('bibliographies_basket_clear');
            }

            // store updated array back into the session
            $session->set('basket', $bibliographies);
        }

          return $this->redirectToRoute('bibliographies_basket_index');
    }

}
