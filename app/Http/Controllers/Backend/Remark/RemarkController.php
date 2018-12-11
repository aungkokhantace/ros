<?php

namespace App\Http\Controllers\Backend\Remark;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RMS\Infrastructure\Forms\RemarkEditRequest;
use App\RMS\Infrastructure\Forms\RemarkEntryRequest;
use App\RMS\Remark\Remark;
use App\Status\StatusConstance;
use App\RMS\Remark\RemarkRepositoryInterface;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;
use App\RMS\Utility;


class RemarkController extends Controller
{
    private $remarkRepository;

    public function __construct(RemarkRepositoryInterface $remarkRepository){
        $this->remarkRepository = $remarkRepository;
        $this->restaurantRepo   = new RestaurantRepository();
        $this->branchRepo       = new BranchRepository();
    }

    public function index()
    {
        
        $remarks        = $this->remarkRepository->getRemark();
        return view('Backend.remark.remarkList')->with('remarks',$remarks);
                                                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $branch         = $this->branchRepo->getAllType();
          $restaurant     = $this->restaurantRepo->getAllType();

          return view('Backend.remark.remark')->with('branchs',$branch)
                                                ->with('restaurants',$restaurant);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RemarkEntryRequest $request)

    {
        try{
        $request->validate();
        $name                   = Input::get('remark_name');
        $description            = Input::get('description');

        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');
        // dd($branch_id);     

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
        // dd($name);

        $paramObj               = new Remark();
        $paramObj->name         = $name;
        $paramObj->description  = $description;
        $paramObj->restaurant_id= $restaurant_id;
        $paramObj->branch_id    = $branch_id;
        $paramObj->status       = 1;
        $result                 = $this->remarkRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Remark created ...'));
        }
        else{
            return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Remark did not create ...'));
        }

        }
        catch(\Expection $e){
              return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Remark did not create ...'));

        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $remark         = $this->remarkRepository->getRemarkById($id);
        $branch         = $this->branchRepo->getAllType();
        $restaurant     = $this->restaurantRepo->getAllType();
        return view('Backend.remark.remark')->with('remark',$remark)
                                                ->with('branchs',$branch)
                                                ->with('restaurants',$restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RemarkEditRequest $request)
    {
    try{
        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('remark_name');
        $description                = Input::get('description');

        $paramObj                   = Remark::find($id);
        $paramObj->name             = $name;
        $paramObj->description      = $description;

        $result = $this->remarkRepository->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

           return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Remark created ...'));
        }
        
        else{
            return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Remark did not create ...'));
        }
        

      }
      catch(\Exception $e){
       return redirect()->action('Backend\Remark\RemarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Remark did not create ...'));
        }
      
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $new_string = explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->remarkRepository->deleteRemarkData($id);
        }
        return redirect()->action('Backend\Remark\RemarkController@index')->withMessage(FormatGenerator::message('Success', 'Remark deleted ...'));
    }

      public function active($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->remarkRepository->Remark_active($id);
        }
        return redirect()->action('Backend\Remark\RemarkController@index');
    }
    public function inactive($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->remarkRepository->Remark_inactive($id);
        }
        return redirect()->action('Backend\Remark\RemarkController@index');
    }

     
    
}
