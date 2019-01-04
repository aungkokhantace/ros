<?php

namespace App\Http\Controllers\Backend\Continent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RMS\Infrastructure\Forms\ContinentEditRequest;
use App\RMS\Infrastructure\Forms\ContinentEntryRequest;
use App\RMS\Continent\Continent;
use App\RMS\Category\Category;
use App\Status\StatusConstance;
use App\RMS\Continent\ContinentRepositoryInterface;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class ContinentController extends Controller
{

    private $continentRepository;

    public function __construct(ContinentRepositoryInterface $continentRepository){
        $this->continentRepository = $continentRepository;
    }

    public function index()
    {
        $continents        = $this->continentRepository->getContinent();
        return view('Backend.continent.index',compact('continents'));
    }

    public function create()
    {
        $categories   = $this->continentRepository->getCategories();
        return view('Backend.continent.continent',compact('categories'));
    }

    public function store(ContinentEntryRequest $request)
    {
        try{
        $request->validate();
        $name                   = Input::get('continent_name');
        $categories               = (array)Input::get('category');
        $description            = Input::get('description');

        $paramObj               = new Continent();
        $paramObj->name         = $name;
        $paramObj->description  = $description;
        $result                 = $this->continentRepository->store($paramObj,$categories);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Success', 'Continent created ...'));
        }
        else{
            return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Continent did not create ...'));
        }

        }
        catch(\Expection $e){
              return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Continent did not create ...'));

        }

    }

        public function edit($id)
    {
        $continent = $this->continentRepository->getContinentID($id);
        $categories   = $this->continentRepository->getCategories();
        // return $continent;
        return view('Backend.continent.continent',compact('continent','categories'));
    }

    public function update(ContinentEditRequest $request)
    {

    try{
        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('continent_name');
        $categories                  = (array)Input::get('category');
        $description                = Input::get('description');

        $paramObj                   = Continent::where('id',$id)->first();
        $paramObj->name             = $name;
        $paramObj->description      = $description;

        $result = $this->continentRepository->update($paramObj,$categories);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

           return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Success', 'Continent created ...'));
        }

        else{
            return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Continent did not create ...'));
        }

      }
      catch(\Exception $e){
       return redirect()->action('Backend\Continent\ContinentController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Continent did not create ...'));
        }
    }

    public function delete($id)
    {
        $new_string = explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->continentRepository->deleteContinent($id);
        }
        return redirect()->action('Backend\Continent\ContinentController@index')->withMessage(FormatGenerator::message('Success', 'Continent deleted ...'));
    }

    public function getContientByCategory($id)
    {
        $continent = Category::findOrFail($id)->continent()->get(['id','name']);
        return \Response::json($continent);
    }

}
