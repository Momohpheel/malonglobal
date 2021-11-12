<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Job;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repository\Interfaces\BusinessRepositoryInterface;
use App\Traits\Response;

class BusinessRepository implements BusinessRepositoryInterface{

    use Response;

    public function signup(Request $request){
        try{

            $validated = $request->validate([
                'email' => "required|string|unique:users",
                "password" => "required|string"
            ]);

            $check_business = Business::where('email', $validated['email'])->where('phone', $validated['phone'])->first();
            if (!$check_business){
                $business = new Business;
                $business->email = $validated['email'];
                $business->password = Hash::make($validated['password']);
                $business->save();

                $access_token = $business->createToken('authToken')->accessToken;
                $business['access_token'] = $access_token;

                return $this->success(false, "Business created", $user, 201);
            }else{
                return $this->error(true, "Business exists", 400);
            }
        }catch(Exception $e){
            return $this->error(true, "Error creating business", 400);
        }

    }

    public function login(Request $request){
        try{
            $validated = $request->validate([
                'email' => "required|string",
                "password" => "required|string"
            ]);

            $business = Business::where('email', $validated['email'])->first();
            if ($business){
                $check = Hash::check($validated['password'], $business->password);
                if ($check){
                    $access_token = $business->createToken('authToken')->accessToken;
                    $business['access_token'] = $access_token;
                    return $this->success(false, "business found", $business, 200);
                }else{
                    return $this->error(true, "Incorrect Password", 400);
                }
            }else{
                return $this->error(true, "business with email not found", 400);
            }

        }catch(Exception $e){
            return $this->error(true, "Error logging business", 400);
        }
    }


    public function addJob(Request $request){
        try{

            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'category' => 'required',
                'jobType' => 'required',
                'workCondition' => 'required'
            ]);

            $job = new Job;
            $job->title = $request->title;
            $job->description = $request->description;
            $job->jobType = $request->jobType;
            $job->workCondition = $request->workCondition;
            $job->category = $request->category;
            $job->business_id = auth()->user()->id;
            $job->save();


            return $this->success(false, "job added!", $job, 200);
        }catch(Exception $e){
            return $this->error(true, "Error adding job!", 400);
        }
    }

    public function updateJob(Request $request, $id){
        try{

            $validated = $request->validate([
                'title' => 'string',
                'description' => 'string',
                'category' => 'string',
                'jobType' => 'string',
                'workCondition' => 'string'
            ]);
            $job = Job::where('id', $id)->first();
            $job->title = $request->title ?? $job->title;
            $job->description = $request->description ?? $job->description;
            $job->jobType = $request->jobType ?? $job->jobType;
            $job->workCondition = $request->workCondition ?? $job->workCondition;
            $job->category = $request->category ?? $job->category;
            $job->author = auth()->user()->id;
            $job->save();



            return $this->success(false, "job updated!", $job, 200);
        }catch(Exception $e){
            return $this->error(true, "Error adding job!", 400);
        }
    }

    public function removeJob($id){
        try{

            $job = Job::where('id', $id)->first();

            $jobCategory = $job->category->detach();

            $job->delete();

            return $this->success(false, "Job deleted!", [], 204);
        }catch(Exception $e){
            return $this->error(true, "Error adding job!", 400);
        }
    }

    public function getJob($id){
        try{

            $job = Job::where('id', $id)->first();

            return $this->success(false, "Job!", $job, 200);
        }catch(Exception $e){
            return $this->error(true, "Error getting job!", 400);
        }
    }

    public function getAllJobs(){
        try{

            $jobs = Job::all();

            return $this->success(false, "Jobs!", $jobs, 200);
        }catch(Exception $e){
            return $this->error(true, "Error getting jobs!", 400);
        }
    }


}
