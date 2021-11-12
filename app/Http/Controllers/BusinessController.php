<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\Interfaces\BusinessRepositoryInterface;

class BusinessController extends Controller
{

    public $repository;

    public function __construct(BusinessRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function signup(Request $request){
        return $this->repository->signup($request);
    }

    public function login(Request $request){
        return $this->repository->login($request);
    }

    public function addJob(Request $request){
        return $this->repository->addJob($request);
    }

    public function updateJob(Request $request, $id){
        return $this->repository->updateJob($request, $id);
    }

    public function removeJob($id){
        return $this->repository->removeJob($id);
    }

    public function getJob($id){
        return $this->repository->getJob($id);
    }

    public function getAllJobs(){
        return $this->repository->getAllJobs();
    }


}
