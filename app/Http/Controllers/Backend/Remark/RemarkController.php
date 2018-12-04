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

class RemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $remarkRepository;

    public function __construct(RemarkRepositoryInterface $remarkRepository){
        $this->remarkRepository = $remarkRepository;
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
          return view('Backend.remark.remark');
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
        // dd($name);

        $paramObj               = new Remark();
        $paramObj->name         = $name;
        $paramObj->description  = $description;
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
        $remark = $this->remarkRepository->getRemarkById($id);
        return view('Backend.remark.remark')->with('remark',$remark);
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
    
}
