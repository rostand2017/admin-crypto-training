<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 10:05
 */

namespace App\Controller\Courses;


use App\Entity\Course;
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
    public function indexAction(Course $course){
        $modules = $this->getDoctrine()->getRepository(Module::class)->findBy(['course'=>$course], ['createdat'=>'asc']);
        $totalDuration = $this->calculateDuration($modules);
        return $this->render("courses/modules.html.twig", array(
            "modules" => $modules,
            "course" => $course,
            "totalDuration" => $totalDuration
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
    public function editModuleAction(Request $request, Course $course){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;

        $title = $post->get("title");
        $duration = $post->get("duration");
        $id = $post->get('id');
        if($id > 0 ){
            $module = $em->getRepository(Module::class)->find($id);
            if( $title != '' && $module && $duration > 0)
            {
                $module->setTitle($title);
                $module->setDuration($duration);
                $em->persist($module);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Module modifié avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez tous les champs requis"
                ));
            }

        }else{
            if($title != '' && $duration > 0){
                $module = new Module();
                $module->setTitle($title);
                $module->setDuration($duration);
                $module->setCourse($course);
                $em->persist($module);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Module ajouté avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez tous les champs requis"
                ));
            }
        }
    }

    /**
     * @Route("courses/{course}/modules/{module}/delete", name="delete_module", requirements={"module"="\d+", "course"="\d+"})
     */
    public function deleteModuleAction(Module $module, Course $course){

        $em = $this->getDoctrine()->getManager();
        $em->remove($module);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Catégorie supprimée avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status" => 1,
                "mes" => "Impossible de supprimer ce module",
                "error" => $e->getMessage(),
            ));
        }
    }
    
}