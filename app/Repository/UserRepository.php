<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Job;
use App\Models\Business;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repository\Interfaces\BusinessRepositoryInterface;
use App\Traits\Response;

class UserRepository implements UserRepositoryInterface{

    use Response;

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

        public function search(Request $request){
            try{
            $job = Job::where('name','LIKE','%'.$request->data.'%')
                        ->orWhere('school','LIKE','%'.$request->data.'%')
                        ->orWhere('location','LIKE','%'.$request->data.'%')
                        ->orWhere('state','LIKE','%'.$request->data.'%')
                        ->orWhere('sharing','LIKE','%'.$request->data.'%')
                        ->orWhere('school','LIKE','%'.$request->data.'%')
                        ->orWhere('price','LIKE','%'.$request->data.'%')
                        ->orWhere('description','LIKE','%'.$request->data.'%')->get();

                if(count($job) > 0){
                    return $this->success(false, "Search Results", $job, 200);
                }else{
                    return $this->error(true, "No Details found. Try to search again!", 400);
                }
            }catch(Exception $e){
                return $this->error(true, "Error!", 400);
            }
        }



        public function apply(Request $request, $jobId){
            try{
                $validated = $request->validate([
                    'name' => "required|string",
                    'email' => "required|email",
                    'cv' => "required|mimes:docx, pdf"
                ]);

                if ($request->hasFile()){
                    $getFileName = $request->cv->getClientOriginalName();
                    $getFileNamewithoutExt = pathinfo($getFileName, PATHINFO_FILENAME);
                    $getFileExt = $request->cv->getClientOriginalExtension();
                    $file_to_store = $name . '_' . time() . '.' . $file_extension;
                    $path = $request->cv->storeAs('public/files', trim($file_to_store));


                    $application = new Application;
                    $application->name = $request->name;
                    $application->email = $request->email;
                    $application->cv = $file_to_store;
                    $application->job_id = $jobId;
                    $application->save();


                    return $this->success(false, "Application sent!", 200);

                }else{
                    return $this->error(true, "CV can't be found!", 400);
                }



            }catch(Exception $e){
                return $this->error(true, "Error!", 400);
            }
        }
}
