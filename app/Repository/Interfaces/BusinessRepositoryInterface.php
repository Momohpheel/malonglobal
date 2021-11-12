<?php
namespace App\Repository\Interfaces;


use Illuminate\Http\Request;

interface BusinessRepositoryInterface{

    public function signup(Request $request);

    public function login(Request $request);

    public function addJob(Request $request);

    public function updateJob(Request $request, $id);

    public function removeJob($id);

    public function getJob($id);

    public function getAllJobs();


}
