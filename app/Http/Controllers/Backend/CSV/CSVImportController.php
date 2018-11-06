<?php

namespace App\Http\Controllers\Backend\CSV;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Infrastructure\Forms\CsvEntryRequest;
use App\RMS\CSV\CSVRepositoryInterface;
use Illuminate\Support\Facades\Input;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;
use Illuminate\Support\Facades\DB;
use App\RMS\ReturnMessage;



class CSVImportController extends Controller
{

	private $repo;

    public function __construct(CSVRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function import() {
        $Restaurant_Repo     = new RestaurantRepository();
        $Branch_Repo         = new BranchRepository();

        $restaurant              = $Restaurant_Repo->getAllType();
        $branch                  = $Branch_Repo->getAllType();
        return view('Backend.csv_import.index')->with('restaurants',$restaurant)->with('branchs',$branch);

    }
    
    public function store(CsvEntryRequest $request) {
    	// dd("a");
        $request->validate();

        $restaurant_id      = Input::get('restauranat');
        $branch_id          = Input::get('branch');
        $table_name         = Input::get('tbl_name');
        $csv                = Input::file('csv_upl');
        // dd($csv);
        // dd($request->all());
        // dd($table_name,$csv);
        try {
            DB::beginTransaction();
            $handle         = fopen($csv, 'r');
            $c = 0;
            while (($data   = fgetcsv($handle, 1000, ",")) !== FALSE) {            

                if ($table_name == 'add_on') {
                    $insert_val         = implode("','",$data);
                    // dd("aa");
                    $user_result        = $this->repo->create_add_on($data,$restaurant_id,$branch_id);
                    // dd($user_result);
                    if($user_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Backend\CSV\CSVImportController@import');
                    }
                   
                  }

                if ($table_name == 'category') {
                    $insert_val         = implode("','",$data);
                    // dd("aa");
                    $user_result        = $this->repo->create_category($data,$restaurant_id,$branch_id);

                    if($user_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Backend\CSV\CSVImportController@import');
                    }
                   
                  }


                if ($table_name == 'items') {
                    $insert_val         = implode("','",$data);
                    // dd("aa");
                    $user_result        = $this->repo->create_item($data,$restaurant_id,$branch_id);
                                        
                    if($user_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Backend\CSV\CSVImportController@import');
                    }
                   
                  }

                if ($table_name == 'set_menu') {
                    $insert_val         = implode("','",$data);
                    // dd("aa");
                    $user_result        = $this->repo->create_menu($data,$restaurant_id,$branch_id);
                                        
                    if($user_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Backend\CSV\CSVImportController@import');
                    }
                   
                  }


                  $c = $c + 1;

                }
                DB::commit();
                    alert()->success('Success Message', 'Table has imported successfully')->persistent('Close');
                    return redirect()->action('Backend\CSV\CSVImportController@import');
        } 
        catch(\Exception $e){
            DB::rollback();
        }
    }

}
