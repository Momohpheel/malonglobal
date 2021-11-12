<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{

    public $repository;

    public function __construct(UserRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function getJob($id){
        return $this->repository->getJob($id);
    }

    public function getAllJobs(){
        return $this->repository->getAllJobs();
    }

    public function search(Request $request){
        return $this->repository->search($request);
    }

    public function apply(Request $request, $jobId){
        return $this->repository->apply($request, $jobId);
    }

}
