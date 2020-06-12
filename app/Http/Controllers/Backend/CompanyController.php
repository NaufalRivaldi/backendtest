<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CompanyRequest;

use App\Models\User;
use App\Models\Company;
use App\Models\Prefecture;
use App\Models\Postcode;

use DB;

class CompanyController extends Controller
{
    private function getRoute(){
        return 'company';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.companies.index');
    }

    // getpostcode
    public function postCode(Request $request){
        $postcode = Postcode::where('postcode', $request->postcode)->first();
        if(!empty($postcode)){
            $prefecture = Prefecture::where('display_name', $postcode->prefecture)->first();
            return response()->json(['data'=>$postcode, 'prefectureId'=>$prefecture->id]);
        }else{
            return response()->json(['data' => (object)[
                'city' => '',
                'local' => '',
            ], 'prefectureId'=>'']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Prefecture();
        $company->form_action = $this->getRoute().'.store';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        
        $prefecture = Prefecture::all();

        return view('backend.companies.form', [
            'company' => $company,
            'prefecture' => $prefecture
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'prefecture_id' => $request->prefecture_id,
            'phone' => $request->phone,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'local' => $request->local,
            'street_address' => $request->street_address,
            'business_hour' => $request->business_hour,
            'regular_holiday' => $request->regular_holiday,
            'image' => $this->imageUpload($request),
            'fax' => $request->fax,
            'url' => $request->url,
            'license_number' => $request->license_number
        ]);

        return redirect()->route('company.index')->with('success', 'Input data successfuly');
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
        $company = new Prefecture();
        $company->form_action = $this->getRoute().'.update';
        $company->page_title = 'Company Edit Page';
        $company->page_type = 'edit';
        $company->data = Company::find($id);
        
        $prefecture = Prefecture::all();

        return view('backend.companies.form', [
            'company' => $company,
            'prefecture' => $prefecture
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request)
    {
        $company = Company::find($request->id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->prefecture_id = $request->prefecture_id;
        $company->phone = $request->phone;
        $company->postcode = $request->postcode;
        $company->city = $request->city;
        $company->local = $request->local;
        $company->street_address = $request->street_address;
        $company->business_hour = $request->business_hour;
        $company->regular_holiday = $request->regular_holiday;
        
        // check image
        if($request->hasFile('image')){
            $company->image = $this->imageUpload($request);
        }else{
            $company->image = $request->imageOld;
        }

        $company->fax = $request->fax;
        $company->url = $request->url;
        $company->license_number = $request->license_number;
        $company->save();

        return redirect()->route('company.index')->with('success', 'Update data successfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->imageDelete($request->id);
        $company = Company::find($request->id);
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Delete data successfuly');
    }

    // image upload
    public function imageUpload($request){
        $statement = DB::select("SHOW TABLE STATUS LIKE 'companies'");
        $id = $statement[0]->Auto_increment;

        $image = $request->file('image');
        $fileName = 'image_'.$id.'.'.$image->getClientOriginalExtension();
        
        $image->move(public_path().'/uploads/files', $fileName);
        $url = '/uploads/files/'.$fileName;
        
        return $url;
    }

    // delete image
    public function imageDelete($id){
        $company = Company::find($id);
        unlink(public_path().$company->image);
    }
}
