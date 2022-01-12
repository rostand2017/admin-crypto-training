<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 10:05
 */

namespace App\Controller\Coursess;


use App\Entity\Courses;
use App\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("courses/{course}/modules", name="modules", requirements={"course"="\d+"})
     */
    public function indexAction(Courses $course){
        $modules = $this->getDoctrine()->getRepository(Module::class)->findBy(['course'=>$course], ['createdat'=>'asc']);
        return $this->render("courses/modules.html.twig", array(
            "modules" => $modules,
            "course" => $course,
            "totalDuration" => $course->getDuration()
        ));
    }

    private function calculateDuration($modules): string {
        $duration = 0;
        if(empty($modules))
            return $duration." Minute";
        foreach ($modules as $module ){
            $duration += $module->getDuration();
        }
        if($duration > 59){
            $hours = floor($duration/60);
            $mins = $duration%60;
            return "$hours H $mins minutes";
        }
        return "$duration minutes";
    }

    /**
     * @Route("courses/{course}/modules/edit", name="edit_module", requirements={"course"="\d+"})
     */
    public function editModuleAction(Request $request, Courses $course){

        $em = $this->getDoctrine()->getManager();
        $this->validateModuleForm($request);
        $id = $request->request->get("id", -1);
        if($id > 0 ){
            $module = $em->getRepository(Module::class)->find($id);
            $module = $this->validateModuleForm($request, $module);
            if(get_class($module) != Module::class)
                return $module;
            $em->persist($module);
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Module modifié avec succès"
            ));

        }else{
            $module = new Module();
            $module = $this->validateModuleForm($request, $module);
            if(get_class($module) != Module::class)
                return $module;
            $module->setCourses($course);
            $em->persist($module);
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Module ajouté avec succès"
            ));
        }
    }

    /**
     * @Route("courses/{course}/modules/{module}/delete", name="delete_module", requirements={"module"="\d+", "course"="\d+"})
     */
    public function deleteModuleAction(Module $module, Courses $course){

        $em = $this->getDoctrine()->getManager();
        $em->remove($module);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Module supprimé avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status" => 1,
                "mes" => "Impossible de supprimer ce module",
                "error" => $e->getMessage(),
            ));
        }
    }

    private function validateModuleForm(Request $request, Module $module){
        $post = $request->request;
        $title = $post->get("title");
        $duration = $post->get("duration");

        if($title == "" || $title ==  null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez le titre du module"));
        if( $duration == "" || $duration == null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez la durée du module"));
        return $this->saveModule($module, $title, $duration);
    }

    private function saveModule(Module $module, $title, $duration): Module{
        $module->setTitle($title);
        $module->setDuration($duration);
        return $module;
    }

}