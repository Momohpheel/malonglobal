<?php
namespace App\Repository\Interfaces;


use Illuminate\Http\Request;

interface UserRepositoryInterface{

    public function getJob($id);

    public function getAllJobs();

    public function search(Request $request);

    public function apply(Request $request, $jobId);


}
